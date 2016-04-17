<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
    <style>
        tr:nth-child(odd) {
            background-color: #e6e6e6;
        }

        tr.table_header {
            background-color: #4CAF50;
            color: #FFFFFF;
        }
    </style>
</head>

<?php
include 'databaseFunctions.php';


function createPlayersArray() {
    $conn = connectToDatabase();
    $query = "SELECT First_Name, Last_Name, Player_ID from Players";
    $result = $conn->query($query);
    $teams = array();
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $teams[$row['Player_ID']] = $row['First_Name'] . " " . $row['Last_Name'];
        }
    } else {
        echo "0 results";
    }
    return $teams;
}


function printTop10Teams() {
    $conn = connectToDatabase();
    $query = "SELECT * FROM Team ORDER BY Win_Count DESC LIMIT 10";
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printTop10TeamsByPercentage() {
    $conn = connectToDatabase();
    $query = 'SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY 100*Win_Count/Team.Game_Count DESC LIMIT 10';
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printTop10TeamsGamesPlayed() {
    $conn = connectToDatabase();
    $query = 'SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY Game_Count DESC LIMIT 10';
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printPlayersWithPerfectGames() {
    $conn = connectToDatabase();
    $query = 'SELECT * FROM Player_Stats, Players where Player_Stats.Player_ID = Players.Player_ID and Player_Stats.Perfect_Games > 0';
    $result = $conn->query($query);
    printPlayers($result);
    $conn->close();
}


function printPlayers($result) {
    if($result->num_rows > 0) {
        echo '<table>';
        echo '<tr class="table_header"><th>Player Name</th><th>Number of Perfect Games</th><th>Player\'s Email Address</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo '<td>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</td>';
            echo '<td>' . $row['Perfect_Games'] . '</td>';
            echo '<td>' . $row['Email'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else {
        echo 'Fatal error! No team exists.';
    }
}


function printResult($result) {
    if($result->num_rows > 0) {
        echo "<table >";
        echo "<tr class='table_header'><th>Place</th><th>Team Name</th><th>Leader Name</th><th>Games Played</th><th>Win Count</th><th>Win Percentage</th></tr>";
        $place = 1;
        $teams = createPlayersArray();
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>$place</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $teams[$row['Leader']] . "</td>";
            echo "<td>" . $row['Game_Count'] . "</td>";
            echo "<td>" . $row['Win_Count'] . "</td>";

            $percentage = (100 * $row['Win_Count']/$row['Game_Count']);
            echo "<td>" . number_format($percentage, 0, '.', '') . " %</td>";
            echo "</tr>";

            $place++;
        }
        echo "</table>";
    } else {
        echo "Fatal error! No teams exist.";
    }
}


$selection = $_GET['report'];
if($selection == "teams_win_count") {
    echo '<h5>Here are the current top 10 teams with the highest win count.</h5>';
    printTop10Teams();
}
else if ($selection == "teams_win_perc") {
    echo '<h5>Here are the current top 10 teams with the highest win percentage.</h5>';
    printTop10TeamsByPercentage();
}
else if ($selection == "teams_most_games") {
    echo '<h5>Here are the current top 10 teams who have played the most games.</h5>';
    printTop10TeamsGamesPlayed();
}
else if ($selection == "players_perfect_game") {
    echo '<h5>Here are the players who have rolled a perfect game.</h5>';
    printPlayersWithPerfectGames();
}

?>


<body>

</body>
</html>
