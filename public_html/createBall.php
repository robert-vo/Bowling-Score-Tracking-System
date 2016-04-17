<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

function validateBallInputs() {
    $isValid = true;

    if(!isset($_POST['weight']) or $_POST['weight'] <= 0) {
        echo '<br>Invalid Weight for Ball';
        $isValid = false;
    }
    else if(!ctype_digit($_POST['weight'])) {
        echo '<br>Invalid Weight for Ball (not an int)';
        $isValid = false;
    }


    if(!isset($_POST['size']) or $_POST['size'] == "") {
        echo '<br>Forgot to select size!';
        $isValid = false;
    }

    if(!isset($_POST['ballColor']) or $_POST['ballColor'] == "") {
        echo '<br>Invalid color!';
        $isValid = false;
    }

    return $isValid;
}
if(isset($_POST['submit'])) {
    if(validateBallInputs()) {
        attemptToInsertIntoBalls($_POST['ballColor'], $_POST['weight'], $_POST['size']);
    }
}
else if(isset($_POST['goBack'])) {
    header('location:games.php');
}
?>

<html>

<p>
To add a new ball, please fill in every single item in the following form.
<form action="createBall.php" method="POST">

    <input type="text" name="weight" placeholder = "Enter weight in pounds."/>
    <select name="size">
        <option value="">Select ball size</option>
        <option value="1">Extra Small</option>
        <option value="2">Small</option>
        <option value="3">Medium</option>
        <option value="4">Large</option>
        <option value="5">Extra Large</option>
        <option value="6">Extra Extra Large</option>
    </select>
    <input type="color" name="ballColor" value="#ff0000">

    <input type="submit" value="Submit" name="submit">
</form>

<form action="createBall.php" method="POST">
    <input type="submit" value="Go Back To Games Page" name="goBack" onclick="return confirm('Are you sure you want to go back to the games page?');">
</form>

</p>
</html>
