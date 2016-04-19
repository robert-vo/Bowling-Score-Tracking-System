<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
</head>

<?php
include 'menuBar.php';
generateMenuBar(basename(__FILE__));

function displayAlertWithMessage($message) {
    echo "<script type='text/javascript'>
            alert('$message');
            history.go(-1);
        </script>";
}


if(isset($_GET['key'])) {
    $alertMessage = "You are logged in! There is no need to reset your password.";
    session_start();
    include 'databaseFunctions.php';
    function changePasswordForPlayerWithResetKey($resetKey, $password)
    {
        $conn = connectToDatabase();
        $newPassword = password_hash($password, PASSWORD_DEFAULT);
        $resetKey = explode("<", $resetKey, 2)[0];

        $sql = "update Players set Players.Password = '$newPassword', Players.Reset_Key = null";
        $sql = $sql . " where Players.Reset_Key = '$resetKey'";

        if(mysqli_query($conn, $sql)) {
            $alertMessage = "Password Update successful! Taking you back to the login screen.";
            echo "<script type='text/javascript'>
            alert('$alertMessage');
            window.location.href = 'loginForm.php';
        </script>";
        }
        else {
            $alertMessage = "Sorry! Please try resetting your password again. Make sure you have clicked the right link in the email.";
        }

        $conn->close();

        return $alertMessage;
    }

    if (isset($_POST['valid'])) {
        if (!empty($_POST["password"]) and strlen($_POST["password"]) < 8) {
            $alertMessage = 'Password must be at least 8 characters of length.';
        } else if (strcmp($_POST['verifyPassword'], $_POST['password']) != 0) {
            $alertMessage = 'Passwords do not match!';
        } else {
            $alertMessage = changePasswordForPlayerWithResetKey($_GET['key'], $_POST['password']);
        }
        displayAlertWithMessage($alertMessage);
    } else {
        if (isset($_SESSION['sess_user'])) {
            displayAlertWithMessage($alertMessage);
        } else {
            echo '<br><div id="box"><div id="boxH">Password Reset</div>   
    <br><div align="center"> Please enter in your new password.</div> 
    <div id="boxF">
        <form method="POST" action="resetPassword.php?key=';
            echo $_GET['key'];
            echo '<input type="text" name="gake" placeholder="Password">';
            echo '<input type="password" name="password" placeholder="Password">';
            echo '<input type="password" name="verifyPassword" placeholder="Verify Password">
            <input type="submit" name="valid" value="Reset">
        </form></div></div><br>';
        }
    }
}
else {
    echo "<script type='text/javascript'>
            alert('Error, invalid page. Please use the menu bar to visit a different page.');
            history.go(-1);
        </script>";

}
?>

