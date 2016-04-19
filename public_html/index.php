<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php
session_start();
include 'databaseFunctions.php';
?>


<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<h1><div text align="center">Welcome to Bowling Score Tracking System!</div></h1>
<img src="../resources/img/Bowling-Strike.jpg" alt="Bowling Strike" style="width:1250px;height:500px;">

</body>
</html>
