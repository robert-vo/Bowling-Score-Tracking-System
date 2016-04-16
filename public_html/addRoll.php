<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

if(isset($_POST['pin1'])) {
    echo 'yay pin 1 is set';
}
else {
    echo 'not yet :(';
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="roll.css">
    <title>Roll</title>
</head>

<body>

<p>
<form action="addRoll.php">

    <input type='checkbox' name='pin1' value='yes'/><label></label>
    <!--        <input type='checkbox' name='pin2' value='pin2'/><label></label>-->
    <!--        <input type='checkbox' name='pin3' value='pin3'/><label></label>-->
    <!--        <input type='checkbox' name='pin4' value='pin4'/><label></label>-->
    <!--        <input type='checkbox' name='pin5' value='pin5'/><label></label>-->
    <!--        <input type='checkbox' name='pin6' value='pin6'/><label></label>-->
    <!--        <input type='checkbox' name='pin7' value='pin7'/><label></label>-->
    <!--        <input type='checkbox' name='pin8' value='pin8'/><label></label>-->
    <!--        <input type='checkbox' name='pin9' value='pin9'/><label></label>-->
    <!--        <input type='checkbox' name='pin10' value='pin10'/><label></label>-->

    <input type="submit" value="Submit Roll" name="submit">
</form>
</body>
</html>