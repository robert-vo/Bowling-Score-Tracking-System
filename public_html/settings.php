<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:loginForm.php");

} else {
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Settings </title>

    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
    <link rel="stylesheet" type="text/css" href="settings.css">

    <style>
        div#error {
            color: red;
        }
    </style>
</head>

<body>


<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
}
?>
