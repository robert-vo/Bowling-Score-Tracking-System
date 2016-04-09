<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<?php

include 'databaseFunctions.php';

function updateResetKeyOfPlayerWithEmail($email) {
    $conn = connectToDatabase();

    $md5VersionOFEmail = md5($email);

    $sql = "update Players set Players.Reset_Key = '$md5VersionOFEmail' where Email = '$email'";

    if (mysqli_query($conn, $sql) == TRUE) {
        $subject = 'Bowling Score Tracking System Password Reset';
        $message = 'hello' . $md5VersionOFEmail;
        $headers = 'From: bowling@bowling-score-tracking-system.com' . "\r\n" .
            'Reply-To: noreply@bowling-score-tracking-system.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail('robertvo79@gmail.com', $subject, $message, $headers);

        echo "<script type='text/javascript'>
            alert('Email sent to your following email account! Please check your email address for more information.');
            history.go(-2);</script>";
    } else {
        echo "<script type='text/javascript'>
            alert('Unable to send the email. Please try again.');
            history.go(-1);
        </script>";
    }

}

function sendEmailToCorrespondingUser() {
    $conn = connectToDatabase();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];

    $sql = "SELECT * FROM Players where Players.Email = '$email';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 0;
        while ($row = $result->fetch_assoc() and $count == 0) {
            $count = 1;
            updateResetKeyOfPlayerWithEmail($email);
        }
    } else {
        echo "<script type='text/javascript'>
            alert('No email found on file. Please try again.');
            history.go(-1);
        </script>";
    }

    $conn->close();
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "<script type='text/javascript'>
            alert('A valid email address is required. Please try again.');
            history.go(-1);
        </script>";
}
else { 
    sendEmailToCorrespondingUser();

}

?>