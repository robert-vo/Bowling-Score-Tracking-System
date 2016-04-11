<?php
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
session_start();
include 'databaseFunctions.php';

function prepareSqlQuery($yourTeam, $otherTeams, $gameTitle, $gameLocation, $gameType) {
    $allTeams = $yourTeam;

    if(!$gameTitle) {
        $gameTitle = 'Generic Game';
    }
    if(isset($otherTeams)) {
        foreach ($otherTeams as $otherTeam) {
            $allTeams = $allTeams . ',' . $otherTeam;
        }
    }


    $sql = "insert into Game(Teams, Title, Location_ID, Event_Type) VALUES ('$allTeams', '$gameTitle', '$gameLocation', '$gameType')";

    echo $sql;

    return $sql;
}

function performInsertQuery() {
    $sql = prepareSqlQuery($_POST['yourTeam'], $_POST['formTeams'], $_POST['game_title'], $_POST['location'], $_POST['eventType']);
    $conn = connectToDatabase();
    if (mysqli_query($conn, $sql) == TRUE) {
        echo "Insertion successful";
    } else {
        echo "<div id=\"error\">Sorry, $conn->error,  please try creating a team again. </div><br>";
    }
    $conn->close();
}

performInsertQuery();
