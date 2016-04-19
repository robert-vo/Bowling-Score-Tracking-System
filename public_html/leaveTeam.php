<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';


function leaveTeam($teamID, $playerPosition) {
    $conn = connectToDatabase();
    $sql = "UPDATE TEAM SET " . $playerPosition . " = NULL where Team_ID = $teamID";

    if(mysqli_query($conn, $sql) == TRUE) {
        echo '<br>Boo hoo! Your team members will miss you. <a href=team.php>Click Here</a> to go back to the team page.';
    }
    else {
        echo '<br>For some reason you were unable to leave your team. The error is ' . $conn->error . '<a href=team.php>Click Here</a> to go back to the team page.';
    }
}

function showDialog($teamID, $playerPosition) {
    echo '<br>Are you sure you want to leave your team?<br>';

    $prepareYesURL = "?teamID=" . $teamID . "&player=" . $playerPosition . "&accepted=1";
    $prepareNoURL = "?teamID=" . $teamID . "&player=" . $playerPosition . "&accepted=0";

    echo '<a href=leaveTeam.php' . $prepareYesURL . '>Yes</a><br>';
    echo '<a href=leaveTeam.php' . $prepareNoURL . '>No</a><br>';
}

if(!isset($_GET['accepted'])) {
    showDialog($_GET['teamID'], $_GET['player']);
}
else {
    if($_GET['accepted'] == 1) {
        leaveTeam($_GET['teamID'], $_GET['player']);
    }
    else {
        echo '<br>Yay! You did not leave your team. <a href=team.php>Click Here</a> to go back to the team page.';
    }
}

