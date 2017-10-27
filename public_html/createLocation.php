<?php
session_start();
if (!isset($_SESSION["sess_user"]))
{
    header("location:loginForm.php");
} else {
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Team Members </title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
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
}
?>

<?php
echo "<form action=addLocation.php method ='POST'>";
echo 'Would you like to add a new location? ';
echo '<input type="text" name="locationInput" placeholder = "Name of Location" class = "inline" id="locationInput">';
echo '<input type="text" name="addressInput" placeholder = "Address" class = "inline" id="addressInput">';
$onclick = "onclick = return confirm('Are you sure you want to add this location?');";
echo '<input type="submit" name = "addplayer" class= "inline" value = "Add Location"  onclick="return confirm(\'Are you sure you want to add this location?\');"></input>';
echo "</input>";
echo '</form>';
?>