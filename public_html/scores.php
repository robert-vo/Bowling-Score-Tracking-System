<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

<body>

<?php
session_start();
include 'menuBar.php';
include 'databaseFunctions.php';
generateMenuBar(basename(__FILE__));
?>
<?php
function createPlayersArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT First_Name, Last_Name, Player_ID from Players";
    $result = $conn->query($sql);
    $teams = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teams[$row['Player_ID']] = $row['First_Name'] . ' ' . $row['Last_Name'];
        }
    } else {
        echo "0 results";
    }
    return $teams;
}
?>
<?php

function printTop10Teams() {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM TEAM ORDER BY Win_Count DESC LIMIT 10";
    $result = $conn->query($sql);
    printResult($result);
    $conn->close();
}
function printTop10TeamsByPercentage() {
    $conn = connectToDatabase();
    $sql = 'SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY 100*Win_Count/Team.Game_Count DESC LIMIT 10';
    $result = $conn->query($sql);
    printResult($result);
    $conn->close();
}
function printTop10TeamsGamesPlayed() {
    $conn = connectToDatabase();
    $sql = 'SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY Game_Count DESC LIMIT 10';
    $result = $conn->query($sql);
    printResult($result);
    $conn->close();
}
function printPlayersWithPerfectGames() {
    $conn = connectToDatabase();
    $sql = 'SELECT * FROM Player_Stats, Players where Player_Stats.Player_ID = Players.Player_ID and Player_Stats.Perfect_Games > 0';
    $result = $conn->query($sql);
    printPlayers($result);
    $conn->close();
}

function printPlayers($result) {
    if($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>Player Name</th><th>Number of Perfect Games</th><th>Player\'s Email Address</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo '<th>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</th>';
            echo '<th>' . $row['Perfect_Games'] . '</th>';
            echo '<th>' . $row['Email'] . '</th>';
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
        $place = 1;
        echo '<table>';
        echo '<tr><th>Place</th><th>Team Name</th><th>Team Leader\'s Name</th><th>Game Played</th><th>Win Count</th><th>Win Count/Games Played Percentage</th></tr>';
        $teams = createPlayersArray();
        while($row = $result->fetch_assoc()) {
            echo '<tr><th>' . $place. '</th>' . $row['Name'];
            $place++;
            echo '<th>' . $row['Name'] . '</th>';

            echo '<th>' . $teams[$row['Leader']] . '</th>';
            echo '<th>' . $row['Game_Count'] . '</th>';
            echo '<th>' . $row['Win_Count'] . '</th>';
            echo '<th>' . 100*$row['Win_Count']/$row['Game_Count'] . '%</th>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else {
        echo 'Fatal error! No team exists.';
    }
}


    echo '<h5>Hello there! Here are the current top 10 teams in the bowling score tracking system database, ordered by win count.</h5>';
    printTop10Teams();
    echo '<h5>Here are the current top 10 teams in the bowling score tracking system database, ordered by win percentage.</h5>';
    printTop10TeamsByPercentage();
    echo '<h5>Here are the teams who have played the most games.</h5>';
    printTop10TeamsGamesPlayed();
    echo '<h5>Here are the players who have rolled a perfect game.</h5>';
    printPlayersWithPerfectGames();
?>


</body>
</html>
