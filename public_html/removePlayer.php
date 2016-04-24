<?php
session_start();
if (!isset($_SESSION["sess_user"]))
{
    header("location:loginForm.php");
}
else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title> Team Members </title>

        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css"
              href="loginAndRegistrationForm.css">
        <link rel="stylesheet" type="text/css" href="team.css">

        <style>
            div#error {
                color: red;
            }
        </style>
    </head>

    <body>
    <?php
    include 'menuBar.php';
    generateMenuBar(basename(__FILE__));
    include 'databaseFunctions.php';
    $conn = connectToDatabase();

    ?>


    </body>
    </html>
    <?php

//echo 'You are about to delete player number ' . $_POST['player'];
    echo '<br>You are about to delete a player from team ' . $_POST['team'];



    $teamID = $_POST['team'];
    if ($_POST['player'] == "Remove Player 1") {
        echo '<br>You have deleted ' . $_POST['player1'];
        $sql = "update team set Player_1 = null where team.Team_ID = $teamID";
        echo "<script type='text/javascript'>
            alert('Player has been deleted!');
            history.go(-1);
            document.location = 'manager.php';
        </script>";
    } else if ($_POST['player'] == "Remove Player 2") {
        echo '<br>You have deleted ' . $_POST['player2'];
        $sql = "update team set Player_2 = null where team.Team_ID = $teamID";
        echo "<script type='text/javascript'>
            alert('Player has been deleted!');
            history.go(-1);
            document.location = 'manager.php';
        </script>";
    } else if ($_POST['player'] == "Remove Player 3") {
        echo '<br>You have deleted ' . $_POST['player3'];
        $sql = "update team set Player_3 = null where team.Team_ID = $teamID";
        echo "<script type='text/javascript'>
            alert('Player has been deleted!');
            history.go(-1);
            document.location = 'manager.php';
        </script>";
    } else if ($_POST['player'] == "Remove Player 4") {
        echo '<br>You have deleted ' . $_POST['player4'];
        $sql = "update team set Player_4 = null where team.Team_ID = $teamID";
        echo "<script type='text/javascript'>
            alert('Player has been deleted!');
            history.go(-1);
            document.location = 'manager.php';
        </script>";
    } else if ($_POST['player'] == "Remove Player 5") {
        echo '<br>You have deleted ' . $_POST['player5'];
        $sql = "update team set Player_5 = null where team.Team_ID = $teamID";
        echo "<script type='text/javascript'>
            alert('Player has been deleted!');
            history.go(-1);
            document.location = 'manager.php';
        </script>";
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

    if (attemptDataManipulationLanguageQuery($sql)) {
        echo '<br>Player Deleted';
    } else {
        echo 'Could not delete player!';
    }
}

/**
 * Created by PhpStorm.
 * User: William
 * Date: 4/22/2016
 * Time: 1:38 PM
 */