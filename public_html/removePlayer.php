<?php
//echo 'You are about to delete player number ' . $_POST['player'];
echo '<br>From this team ID ' . $_POST['team'];

include 'databaseFunctions.php';

$teamID = $_POST['team'];
if($_POST['player'] ==  "Remove Player 1")
{
    echo 'You are about to delete player number ' . $_POST['player1'];
        $sql = "update team set Player_1 = null where team.Team_ID = $teamID";
}
else if($_POST['player'] ==  "Remove Player 2")
{
    echo 'You are about to delete player number ' . $_POST['player2'];
    $sql = "update team set Player_2 = null where team.Team_ID = $teamID";
}
else if($_POST['player'] ==  "Remove Player 3")
{
    echo 'You are about to delete player number ' . $_POST['player3'];
    $sql = "update team set Player_3 = null where team.Team_ID = $teamID";
}
else if($_POST['player'] ==  "Remove Player 4")
{
    echo 'You are about to delete player number ' . $_POST['player4'];
    $sql = "update team set Player_4 = null where team.Team_ID = $teamID";
}
else if($_POST['player'] ==  "Remove Player 5")
{
    echo 'You are about to delete player number ' . $_POST['player5'];
    $sql = "update team set Player_5 = null where team.Team_ID = $teamID";
}

//
//switch($_POST['player1'] or $_POST['player2'] or $_POST['player3'] or $_POST['player4'] or $_POST['player5']) {
//    case 'player1':
//        echo '<br>You are about to delete player number ' . $_POST['player1'];
//        $sql = "update team set Player_1 = null where team.Team_ID = $teamID";
//        break;
//    case 'player2':
//        echo '<br>You are about to delete player number ' . $_POST['player2'];
//        $sql = "update team set Player_2 = null where team.Team_ID = $teamID";
//        break;
//    case 'player3':
//        echo '<br>You are about to delete player number ' . $_POST['player3'];
//        $sql = "update team set Player_3 = null where team.Team_ID = $teamID";
//        break;
//    case 'player4':
//        echo '<br>You are about to delete player number ' . $_POST['player4'];
//        $sql = "update team set Player_4 = null where team.Team_ID = $teamID";
//        break;
//    case 'player5':
//        echo '<br>You are about to delete player number ' . $_POST['player5'];
//        $sql = "update team set Player_5 = null where team.Team_ID = $teamID";
//        break;
//    default:
//        echo 'Invalid player!';
//        break;
//}

if(attemptDataManipulationLanguageQuery($sql)) {
    echo '<br>Player Deleted';
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