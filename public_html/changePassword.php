<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:loginForm.php");
} else { ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="update.css">
    <script>
        function checkPassword() {
            var new_pw = document.getElementById("new_pw").value;
            var confirm_pw = document.getElementById("confirm_pw").value;
            var ok = true;
            if (new_pw != confirm_pw) {
                alert("Passwords do not match!");
                ok = false;
            }
            return ok;
        }
    </script>
</head>
<body>
<?php
include 'menuBar.php';
include 'databaseFunctions.php';
generateMenuBar(basename(__FILE__));

function createForm() {
    echo "<br><br><form action='changePassword.php' method='post' onsubmit='return checkPassword()'>";
    echo "<table>";
    echo "<tr><td>Password:</td> <td><input type='password' required name='password' placeholder='Password'></td></tr>";
    echo "<tr><td>New Password:</td> <td><input type='password' required id='new_pw' name='new_pw' placeholder='New Password'></td></tr>";
    echo "<tr><td>Re-enter Password:</td> <td><input type='password' required id='confirm_pw' name='confirm_pw' placeholder='Confirm Password'></td></tr>";
    echo "<tr><td><input type='submit' value='Submit'></td></tr>";
    echo "</table>";
    echo "</form>";
}
if(!isset($_POST['new_pw']) && !isset($_POST['confirm_pw'])) {
    createForm();
} else {
    $dbpass = "";
    $retrievePasswordQuery = "SELECT Password from Players WHERE Email = '" . $_SESSION['sess_user'] . "';";
    $conn = connectToDatabase();
    $result = $conn->query($retrievePasswordQuery);
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dbpass = $row['Password'];
        }
    } else {
        echo "0 results";
}

    if(password_verify($_POST['password'], $dbpass)) { // Verifies inputted password with the pw in the database
        $new_pw = $_POST['new_pw'];
        $passwordHash = password_hash($new_pw, PASSWORD_DEFAULT);
        if(strlen($_POST['new_pw']) < 8 and !empty($_POST['new_pw'])) {
            echo "<script>alert('Password must be at least 8 characters of length.');</script>";
            createForm();
        }
        else if(empty($_POST['new_pw'])) {
            echo "<script>alert('A password of character length with at least 8 characters is required.');</script>";
            createForm();
        }
        else if(strcmp($_POST['new_pw'], $_POST['confirm_pw']) == 0) { // Emails match
            $changePasswordQuery = "UPDATE Players SET Password=" . "'$passwordHash'" . " WHERE Player_ID=" . $_SESSION['player_id'];
            if(mysqli_query($conn, $changePasswordQuery)) { // Runs the query and returns true if there were no errors
                echo "<BR>Password has been updated.<BR><BR>";
            } else { // If false, then the db is unable to update the password.
                echo "<BR>Unable to update password.<BR><BR>";
            }
                echo "<form action='loginSuccessful.php'><input type='submit' value='Back to profile'></form>";
            } else { // Emails don't match
                echo "<script>alert('New passwords do not match);</script>";
                createForm();
            }
        } else { // If the inputted password is invalid, then it alerts 'invalid password' then brings you back to the change password form.
            echo "<script>alert('Invalid password');</script>";
            createForm();
        }
        $conn->close();
    }
?>
</body>
</html>
<?php
}
?>