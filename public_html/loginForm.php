<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
    <style>
        div#error{
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
if (isset($_SESSION['user_role'])) {
    header("location:index.php");
}
else {
?>
<br>
<div id="box1">
    <div id="boxH">
        LOGIN
    </div>
    <div id="boxF">
        <form action="loginForm.php" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="valid" value="Login">
        </form>
    </div>
</div>
<br>
<div id="centerT"><a href="Register.php">Create account</a></div>
<div id="centerT"><a href="passwordReset.php">Forgot your password?</a></div>
<?php
include 'databaseFunctions.php';
    if (isset($_POST["valid"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = connectToDatabase();
        $query = "SELECT * FROM Players WHERE Email = '$username'";
        $result = $conn->query($query);
        $numrows = $result->num_rows;
        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $dbuser = $row['Email'];
                $dbpass = $row['Password'];
                $userRole = $row['Is_Admin'];
                $playerID = $row['Player_ID'];
            }
            if ($username == $dbuser and password_verify($password, $dbpass)) {
                session_start();
                $_SESSION['sess_user'] = $username;
                $_SESSION['player_id'] = $playerID;
                $_SESSION['user_role'] = $userRole;
                header("location:loginSuccessful.php");
            } else {
                ?>
                <div id="error">Invalid username or password</div>
                <?php
            }
        } else {
            ?>
            <div id="error">Invalid username or password</div>
            <?php
        }
    }
}
?>
</body>
</html>