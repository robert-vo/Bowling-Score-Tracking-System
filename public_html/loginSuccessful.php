
<?php
session_start();
if(!isset($_SESSION["sess_user"])){
    echo "ehllo";
    header("location:loginF.php");
    
}
else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" type="text/css" href="index.css">
    </head>
    <body>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="scores.php">Scores</a></li>
        <li style="float:right"><a href="about.php">About</a></li>
        <li style="float:right"><a class = "active" href="logout.php">Logout</a></li>
    </ul>
    <?= $_SESSION['sess_user'] ?>!
    
    </body>
    </html>

    <?php
}
?>