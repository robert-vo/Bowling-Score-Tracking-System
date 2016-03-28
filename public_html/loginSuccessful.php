<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title> Successful Login</title>
    </head>

<body>
<?php
function validateLogin($username, $password) {
    if($username == "admin" && $password == "123") {
        echo "hello world";
        echo '<h1><span style = "color:#00FF1D">You Succesfully Logged In!</span></h1>';
    }
    else {
        echo "not an admin";
    }
}

?>

    <br/> <a href="loginF.php">Logout</a>

    <?php validateLogin($_POST["username"], $_POST["password"]); ?>
</body>
</html>


