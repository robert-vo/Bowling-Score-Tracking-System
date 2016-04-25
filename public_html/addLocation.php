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



//    function popupMessageAndRedirectBrowser($message) {
//        echo "<script type='text/javascript'>alert('$message');history.go(-1);document.location = 'manager.php';</script>";
//    }
}
?>

<?php
$inputLocation = $_POST['locationInput'];
$inputAddress = $_POST['addressInput'];
$sql = "UPDATE game_location SET Game_Location_Name = $inputLocation";
$sql = "UPDATE game_location SET Game_Address = $inputAddress";
if (attemptDataManipulationLanguageQuery($sql)) {
    echo '<br>New Location Added!';
} else {
    echo 'Could not add location!';
}
  ?>