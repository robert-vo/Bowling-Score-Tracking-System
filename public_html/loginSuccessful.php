
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
    </head>
    <body>
    <?= $_SESSION['sess_user'] ?>! <a href="logout.php">Logout</a>
    fffff
    </body>
    </html>

    <?php
}
?>