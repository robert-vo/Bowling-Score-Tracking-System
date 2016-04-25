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

if($inputLocation == '' or $inputAddress == '')
{
    echo 'Please fill out the form';
}
else {
    $sql = "INSERT into game_location(Game_Location_Name, Game_Address) VALUES ('$inputLocation','$inputAddress')";

    $message = 'New Game Location has been added!';
}
if (attemptDataManipulationLanguageQuery($sql)) {
    echo '<br>New Location Added!';

} else {
    echo 'Could not add location!';
}
popupMessageAndRedirectBrowser($message);
  ?>