<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title> Successful Login</title>
    </head>

<body>
<?php
function validateLogin($username, $password) {

    $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';
    //rasmuslerdorf
    if (password_verify($password, $hash)) {
        echo 'Password is valid!';
    } else {
        echo 'Invalid password.';
    }
}

?>

    <br/> <a href="loginF.php">Logout</a>

    <?php validateLogin($_POST["username"], $_POST["password"]); ?>
</body>
</html>


