<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            margin: 50px auto;
            width: 640px;
        }

        .login {
            position: relative;
            margin: 0 auto;
            padding: 20px 20px 20px;
            width: 310px;
        }
    </style>
    <title>Bootstrap Example</title>
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
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a class = "active" href="loginF.php">Login</a></li>
</ul>




<form><div style="width: 250px; margin: 200px auto 0 auto; ">

    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="pass" placeholder="Password"><br>
    <input type="submit" name="valid" value="Login">
    </div>
</form>




</body>
</html>
