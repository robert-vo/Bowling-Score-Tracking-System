<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php

function connectToDatabase($destination) {
    if($destination == 'Local') {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    else { //Remote
        $servername = "us-cdbr-azure-central-a.cloudapp.net";
        $username = "ba27b2787a498a";
        $password = "e24ebaaa";
        $dbname = "bowling";
    }
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}



?>


<ul>
    <li><a href="index.php">Home</a></li>
    <li><a class = "active" href="scores.php">Scores</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a href="loginForm.php">Login</a></li>
</ul>



</body>
</html>
