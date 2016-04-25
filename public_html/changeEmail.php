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
            function checkEmail() {
                var new_email = document.getElementById("new_email").value;
                var confirm_email = document.getElementById("confirm_email").value;
                var ok = true;
                if (new_email != confirm_email) {
                    alert("Emails do not match!");
                    ok = false;
                }
                else {
                    //alert("Passwords Match!!!");
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

    
    
    function createForm() { // Function that creates the form to change email address
        echo "<br><br><form action='changeEmail.php' method='post' onsubmit='return checkEmail()'>";
        echo "<table>";
        echo "<tr><td>Password:</td> <td><input type='password' required name='password' placeholder='Password'></td></tr>";
        echo "<tr><td>New Email:</td> <td><input type='email' required id='new_email' name='new_email' placeholder='Enter a valid email address'></td></tr>";
        echo "<tr><td>Re-enter Email:</td> <td><input type='email' required id='confirm_email' name='confirm_email' placeholder='Re-enter email address'></td></tr>";
        echo "<tr><td><input type='submit' value='Submit'></td></tr>";
        echo "</table>";
        echo "</form>";
    }


    
    if(!isset($_POST['new_email']) && !isset($_POST['confirm_email'])) {
        // Form to change password
        createForm();

    }
    else {
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
            $new_email = $_POST['new_email'];

            if(strcmp($_POST['new_email'], $_POST['confirm_email'] == 0)) { // Emails match
                $changeEmailQuery = "UPDATE players SET Email=" . "'$new_email'" . " WHERE Player_ID=" . $_SESSION['player_id'];

                if(mysqli_query($conn, $changeEmailQuery)) {  // Runs the query and returns true if there were no errors
                    $email = "";
                    $query = "SELECT Email FROM Players WHERE Player_ID=" . $_SESSION['player_id'];
                    $result = $conn->query($query); // Retrieves the newly updated email from the database and displays it.

                    if($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $email = $row['Email'];
                        }
                    } else {
                        echo "0 results";
                    }

                    echo "<BR>Email updated to: $email<BR><BR>";
                    $_SESSION['sess_user'] = $email; // Updates the username to the new email of the current session user.
                    echo "<form action='loginSuccessful.php'><input type='submit' value='Back to profile'></form>";
                }
                else {
                    echo "<br>Unable to update email.<br>";
                }
            }
            else { // Emails don't match, brings you back to the change email form.
                echo "<script>alert('Emails do not match');</script>";
                createForm();
            }
        }
        else { // If the inputted password is invalid, then it alerts 'invalid password' then brings you back to the change email form.

            echo "<script>alert('Invalid password');</script>";
            createForm();
        }

    }
    ?>

    </body>
    </html>
    <?php
}
?>