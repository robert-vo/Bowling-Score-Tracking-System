<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <style>
        table#report{
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr:nth-child(even) {
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


function printTop10Teams($orderBy, $showTop) {
    $conn = connectToDatabase();
    $query = "SELECT * FROM Team ORDER BY Win_Count " . $orderBy . " LIMIT " . $showTop;
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printTop10TeamsByPercentage($orderBy, $showTop) {
    $conn = connectToDatabase();
    $query = 'SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY 100*Win_Count/Team.Game_Count ' . $orderBy . ' LIMIT ' . $showTop;
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printTop10TeamsGamesPlayed($orderBy, $showTop) {
    $conn = connectToDatabase();
    $query = "SELECT Name, Leader, Game_Count, Win_Count, 100*Win_Count/Team.Game_Count FROM TEAM ORDER BY Game_Count " . $orderBy . " LIMIT " . $showTop;
    $result = $conn->query($query);
    printResult($result);
    $conn->close();
}


function printPlayersReport($report, $showTop, $orderBy) {
    $conn = connectToDatabase();
    $query = 'SELECT * FROM Player_Stats, Players where Player_Stats.Player_ID = Players.Player_ID and Player_Stats.' . $report . ' > 0 ORDER BY Player_Stats.' . $report . ' ' . $orderBy . ' LIMIT ' . $showTop . ';';
    //echo $query;
    $result = $conn->query($query);
    printPlayers($report, $result);
    $conn->close();
}


function printPlayers($report, $result) {
    if($result->num_rows > 0) {
        echo '<table id="report">';
        $reportHeader = "";
        if($report == "Best_Score")
            $reportHeader = "Best Score";
        else if ($report == "Average_Pin_Left")
            $reportHeader = "Average # of Pins Left";
        else
            $reportHeader = "Number of " . $report;

        echo '<tr class="table_header"><th>Place</th><th>Player Name</th><th>' . $reportHeader . '</th><th>Games  Played</th><th>Player\'s Email Address</th></tr>';
        $place = 1;
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo '<td align=\'center\'>' . $place . '</td>';
            echo '<td align=\'center\'>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</td>';
            echo '<td align=\'center\'>' . $row[$report] . '</td>';
            echo '<td align=\'center\'>' . $row['Games_Played'] . '</td>';
            echo '<td align=\'center\'>' . $row['Email'] . '</td>';
            echo '</tr>';

            $place++;
        }
        echo '</table>';
    }
    else {
        echo 'Fatal error! No team exists.';
    }
}


function printResult($result) {
    if($result->num_rows > 0) {
        echo "<table id='report'>";
        echo "<tr class='table_header'><th>Place</th><th>Team Name</th><th>Leader Name</th><th>Games Played</th><th>Win Count</th><th>Win Percentage</th></tr>";
        $place = 1;
        $teams = createPlayersArray();
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td align='center'>$place</td>";
            echo "<td align='center'>" . $row['Name'] . "</td>";
            echo "<td align='center'>" . $teams[$row['Leader']] . "</td>";
            echo "<td align='center'>" . $row['Game_Count'] . "</td>";
            echo "<td align='center'>" . $row['Win_Count'] . "</td>";

            $percentage = (100 * $row['Win_Count']/$row['Game_Count']);
            echo "<td align='center'>" . number_format($percentage, 0, '.', '') . " %</td>";
            echo "</tr>";

            $place++;
        }
        echo "</table>";
    } else {
        echo "Fatal error! No teams exist.";
    }
}



$category = $_POST['category'];
$reportType = $_POST[ $category . 'ReportType'] ;
$orderBy = $_POST[ $category . 'OrderBy' ];
$showTop = $_POST[ $category . 'ShowTop' ];

//echo $reportType . " " . $orderBy . " " . $category . " " . $showTop;

if($category == "players") { // Queries and prints for the 'players' category.

    if($reportType == "Best_Score"){

        $order = "";
        if ($orderBy == "ASC")
            $order = 'worst';
        else
            $order = 'best';
        echo '<h5>Here are the top ' . $showTop . ' players who have the ' . $order . ' high score</h5>';
        printPlayersReport($reportType, $showTop, $orderBy);

    } else if($reportType == "Average_Pin_Left") {
        $order = "";
        if ($orderBy == "ASC")
            $order = 'lowest';
        else
            $order = 'highest';

        echo "<h5>Here are the top " . $showTop . " who have the " . $order . " average number of pins left after the first roll of the frame.</h5>";
        printPlayersReport($reportType, $showTop, $orderBy);

    } else {

        $order = "";
        if ($orderBy == "ASC")
            $order = 'least';
        else
            $order = 'most';

        echo '<h5>Here are the top ' . $showTop . ' players who have rolled the ' . $order . ' ' . $reportType . '</h5>';
        printPlayersReport($reportType, $showTop, $orderBy);
    }

}
else if ($category == "teams") { // Queries and prints for the 'teams' category.

    if($reportType == "win_count") {

        $order = "";
        if($orderBy == "ASC") {
            $order = 'lowest';
        }
        else {
            $order = 'highest';
        }

        echo '<h5>Here are the current top ' . $showTop . ' teams with the ' . $order . ' win count</h5>';
        printTop10Teams($orderBy, $showTop);
        
    } 
    else if ($reportType == "win_percentage") {

        $order = "";
        if($orderBy == "ASC") {
            $order = 'lowest';
        }
        else {
            $order = 'highest';
        }

        echo '<h5>Here are the current top ' . $showTop . ' teams with the ' . $order . ' win percentage</h5>';
        printTop10TeamsByPercentage($orderBy, $showTop);
        
    }
    else if ($reportType == "games_played") {
        
        $order = "";
        if($orderBy == "ASC") {
            $order = 'least';
        }
        else {
            $order = 'most';
        }

        echo '<h5>Here are the current top ' . $showTop . ' teams who have played the ' . $order . ' games</h5>';
        printTop10TeamsGamesPlayed($orderBy, $showTop);
    }
}

?>


<body>

</body>
</html>
