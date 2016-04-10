<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

<body>


<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<p>
    Which table do you want to edit?
    <form action="runAudit.php" method="post">
    <select name="bowlingAudit">
        <option value="">Select...</option>
            <option value ="Ball">Ball</option>
            <option value ="Frame">Frame</option>
            <option value ="Game">Game</option>
            <option value ="Game_Location">Game Location</option>
            <option value ="Player_Stats">Player Statistics</option>
            <option value ="Players">Players</option>
            <option value ="Roll">Roll</option>
            <option value ="Team">Team</option>
            <option value ="Ball_Archive">Ball Archive</option>
            <option value ="Frame_Archive">Frame Archive</option>
            <option value ="Game_Archive">Game Archive</option>
            <option value ="Game_Location_Archive">Game Location Archive</option>
            <option value ="Player_Stats_Archive">Player Statistics Archive</option>
            <option value ="Players_Archive">Players Archive</option>
            <option value ="Roll_Archive">Roll Archive</option>
            <option value ="Team_Archive">Team Archive</option>
    </select>
    <input type="submit" value="Submit">
</form>
</p>




</body>
</html>
