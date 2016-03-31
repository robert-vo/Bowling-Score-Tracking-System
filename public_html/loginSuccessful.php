<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    echo "ehllo";
    header("location:loginForm.php");

} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <style>
            div#id {
                font-size: x-large;
                font-weight: bold;
                color: #4CAF50;
            }
        </style>
    </head>
    <body>
    <?php include 'menuBar.php';
    generateMenuBar(basename(__FILE__));
    ?>

    <div id="id">PROFILE:</div>
    <?php
    $user = $_SESSION['sess_user'];
    include 'databaseFunctions.php';
    $conn = connectToDatabase();
    $query = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query);
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fname = $row['First_Name'];
            $lname = $row['Last_Name'];
        }
    }
    $fname = ucfirst($fname);
    $lname = ucfirst($lname);
    echo "$fname $lname";

    ?>

    </body>
    </html>

    <?php
}
?>