<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="audit.css">

<?php
//session_start();
//include 'menuBar.php';
//generateMenuBar(basename(__FILE__));
//include 'databaseFunctions.php';
include 'practiceScore.php';
function retrieveAllStats($playerID) {
    $conn = connectToDatabase();
    $sql = "select * from Player_Stats where Player_ID = '$playerID'";

    return $conn->query($sql);
}

function displayAllStatsForPlayer($playerID) {
    $result = retrieveAllStats($playerID);

    if($result->num_rows > 0) {
        echo '<br><table>';
        echo '<tr><th>Number of Strikes</th><th>Total Games Played</th><th>Number of Perfect Games</th><th>Total Number of Spares</th>';
        echo '<th>Pins Left</th><th>Average Pins Left</th><th>Foul Count</th><th>Pins Hit</th>';
        echo '</tr>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';

            echo '<th>' . $row['Strikes'] . '</th>';
            echo '<th>' . $row['Games_Played'] . '</th>';
            echo '<th>' . $row['Perfect_Games'] . '</th>';
            echo '<th>' . $row['Spares'] . '</th>';
            echo '<th>' . $row['Pins_Left'] . '</th>';
            echo '<th>' . round($row['Average_Pin_Left'], 3) . '</th>';
            echo '<th>' . $row['Foul_Count'] . '</th>';
            echo '<th>' . $row['Pins_Hit'] . '</th>';

            echo '</tr>';
        }

        echo '</table>';
    }
    else {
        echo 'No statistics found.';
    }
}

if($_SESSION['player_id']) {
    echo '<br><b>Hello there! Here are your statistics for the bowling score tracking system.</br>';
    displayAllStatsForPlayer($_SESSION['player_id']);
}
else {
    echo "<br>Fatal Error, cannot find player_ID.";
}

?>


