<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
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

    return $sql;
}

function prepareSqlQuery2($yourTeam, $gameTitle, $gameLocation, $gameType) {
    $allTeams = $yourTeam;

    if(!$gameTitle) {
        $gameTitle = 'Generic Game';
    }

    $sql = "insert into Game(Teams, Title, Location_ID, Event_Type) VALUES ('$allTeams', '$gameTitle', '$gameLocation', '$gameType')";

    return $sql;
}

function performInsertQuery() {
    if(!isset($_POST['formTeams'])) {
        $sql = prepareSqlQuery2($_POST['yourTeam'], $_POST['game_title'], $_POST['location'], $_POST['eventType']);
    }
    else {
        $sql = prepareSqlQuery($_POST['yourTeam'], $_POST['formTeams'], $_POST['game_title'], $_POST['location'], $_POST['eventType']);
    }
    $conn = connectToDatabase();
    if (mysqli_query($conn, $sql) == TRUE) {
        echo "<br>New game has been created! Please click <a href='games.php'>here</a> to see all of your games!";
//        updateAllTeamsGameCount($_POST['yourTeam'], $_POST['formTeams']);
    } else {
        echo "<div id=\"error\">Sorry, $conn->error,  please try creating a team again. </div><br>";
    }
    $conn->close();
}

function updateAllTeamsGameCount($yourTeam, $otherTeams) {
    $sql = "UPDATE Team SET Team.Game_Count = Team.Game_Count + 1 WHERE Team.Team_ID = '$yourTeam'";
    $conn = connectToDatabase();

    if (mysqli_query($conn, $sql) == TRUE) {
    } else {
        echo "<div id=\"error\">Sorry, $conn->error. Game count was unable to update.</div><br>";
    }

    if(isset($otherTeams)) {
        foreach ($otherTeams as $otherTeam) {
            $sql = "UPDATE Team SET Team.Game_Count = Team.Game_Count + 1 WHERE Team.Team_ID = '$otherTeam'";
            if (mysqli_query($conn, $sql) == TRUE) {
            } else {
                echo "<div id=\"error\">Sorry, $conn->error. Game count was unable to update.</div><br>";
            }
        }
    }

    $conn->close();

}

performInsertQuery();
