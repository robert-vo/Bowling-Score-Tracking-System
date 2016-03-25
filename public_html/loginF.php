<!DOCTYPE html>
<html>
<head>
    <style>
        div#box{
            background-color: white;
            border: 1px solid #4CAF50;
            width: 350px;
            margin:0 auto;
            box-shadow: 1px 0px 15px #4CAF50;
        }
        input{
            display: block;
            margin: 10px;
        }
        div#boxH{
            background-color: #4CAF50;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: white;
            padding: 20px;
        }
        input[type=text],input[type=password]{
            font-size: 15px;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #4CAF50;
        }
        input[type=submit]{
            background-color: #4CAF50;
            padding: 5px 10px 5px 10px;
            border-radius:3px ;
            border: 1px solid #4CAF50;
            color: white;
            font-weight: bold;
        }
        div#boxF{
            display: flex;
            justify-content: center;
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
<br>
<div id="box">
    <div id="boxH">
        LOGIN
    </div>
    <div id="boxF">
        <form>
            <input type="text" name="username" placeholder="Username" >
            <input type="password" name="pass" placeholder="Password" >
            <input type="submit" name="valid" value="Login">
        </form>
    </div>

</div>


</body>
</html>
