<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
</head>

<?php
session_start();
include 'databaseFunctions.php';

include 'menuBar.php';
generateMenuBar(basename(__FILE__));

if(isset($_SESSION['sess_user'])) {
    echo "<script type='text/javascript'>
            alert('You are logged in! There is no need to reset your password.');
            history.go(-1);
        </script>";
}
else {
    echo '<br><div id="box"><div id="boxH">Password Reset</div>   
    <br><div align="center"> Please enter in the email address you have on file.</div> 
    <div id="boxF">
        <form action="sendUserResetKey.php" method="POST">
            <input type="text" name="email" placeholder="Email Address">
            <input type="submit" name="valid" value="Reset">
        </form></div></div><br>';
}

?>