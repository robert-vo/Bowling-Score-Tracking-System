<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<?php

include 'databaseFunctions.php';

function sendEmailTo($email, $reset_key, $firstName, $lastName) {
    $url = 'https://api.sendgrid.com/';
    $user = 'azure_14ef7c1218f26530d7a8a25a9f15aae4@azure.com';
    $pass = 'cosc3380';
    $link = "http://bowling-score-tracking-system.azurewebsites.net/public_html/resetPassword.php?key=$reset_key";
    $message = "Hello $firstName $lastName! <br>You can change your password <a href=$link>here!</a><br><br>Have a good day!";

    $params = array(
        'api_user' => $user,
        'api_key' => $pass,
        'to' => $email,
        'subject' => 'Password Reset for Bowling Score Tracking System',
        'html' => $message,
        'from' => 'noreply@bowling-score-tracking-system.com'
    );
    $request = $url.'api/mail.send.json';
    $session = curl_init($request);
    curl_setopt ($session, CURLOPT_POST, true);
    curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($session);
    if (curl_errno($session)) { echo 'Curl error: ' . curl_error($session); }
    curl_close($session);
    print_r($response);
}

function updateResetKeyOfPlayerWithEmail($email, $firstName, $lastName) {
    $conn = connectToDatabase();

    $md5VersionOFEmail = md5($email);

    $sql = "update Players set Players.Reset_Key = '$md5VersionOFEmail' where Email = '$email'";

    if (mysqli_query($conn, $sql) == TRUE) {
        sendEmailTo($email, $md5VersionOFEmail, $firstName, $lastName);
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

function checkIfEmailExists() {
    $conn = connectToDatabase();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];

    $sql = "SELECT * FROM Players where Players.Email = '$email';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            updateResetKeyOfPlayerWithEmail($email, $row['First_Name'], $row['Last_Name']);
            break;
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
    checkIfEmailExists();

}

?>