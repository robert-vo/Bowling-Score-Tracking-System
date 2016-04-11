<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:loginForm.php");
} else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title> Registration</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
        <style>

        </style>
    </head>
    <body>
    <?php
    include 'menuBar.php';
    generateMenuBar(basename(__FILE__));
    include 'databaseFunctions.php';

    ?>
    <br><b>Create a team! * denotes that it is required.</b>
    <form action="createTeamPart2.php" method="post">
        <input type="text" name="name" placeholder="Team Name*">
        How many other players do you want on your team?
            <select name="numberOfPlayers">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

        <input type="submit" value="Next Page" name="submit">
    </form>
    <?php
}
?>
    </body>
    </html>
