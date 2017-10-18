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



    function popupMessageAndRedirectBrowser($message) {
        echo "<script type='text/javascript'>alert('$message');history.go(-2);document.location = 'createGame.php';</script>";
    }
}
?>

<?php
$inputLocation = $_POST['locationInput'];
$inputAddress = $_POST['addressInput'];

if(strlen($inputLocation) < 8 or strlen($inputAddress) < 8)
{
    $message = 'Invalid form. Please try to enter a location and address of 8 characters of more.';
}
else {
    $sql = "INSERT into Game_Location(Game_Location_Name, Game_Address) VALUES ('$inputLocation','$inputAddress')";
    if (attemptDataManipulationLanguageQuery($sql)) {
        echo '<br>New Location Added!';
        $message = 'New Game Location has been added!';

    } else {
        $message = 'Could not add location!';
    }
}
popupMessageAndRedirectBrowser($message);


  ?>