<?php
echo 'You are about to delete player number ' . $_POST['player'];
echo '<br>From this team ID ' . $_POST['team'];

include 'databaseFunctions.php';

$teamID = $_POST['team'];
switch($_POST['player']) {
    case 'player1':
        $sql = "update team set player_1 = null where team.Team_ID = $teamID";
        break;
    case 'player2':
        $sql = "update team set player_2 = null where team.Team_ID = $teamID";
        break;
    case 'player3':
        $sql = "update team set player_3 = null where team.Team_ID = $teamID";
        break;
    case 'player4':
        $sql = "update team set player_4 = null where team.Team_ID = $teamID";
        break;
    case 'player5':
        $sql = "update team set player_5 = null where team.Team_ID = $teamID";
        break;
    default:
        echo 'Invalid player!';
        break;
}

if(attemptDataManipulationLanguageQuery($sql)) {
    echo 'Player Deleted';
}
else {
    echo 'Could not delete player!';
}

/**
 * Created by PhpStorm.
 * User: William
 * Date: 4/22/2016
 * Time: 1:38 PM
 */