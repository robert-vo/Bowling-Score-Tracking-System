<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>

<?php

function retrieveAndPrintAllFromTable($tableName) {
    $servername = "localhost:3306";
    $username = "root";
    $password = "password";
    $dbname = "bowling";

    // Create connection
    // $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection

    $conn = new PDO("mysql:host=localhost:3306;dbname=bowling", 'root', 'password');

    $getUsers = $conn->prepare("SELECT * FROM BALL");
    $getUsers->execute();

    $users = $getUsers->fetchAll();
    foreach ($users as $user) {
        echo $user['Size'] . '<br />';
    }

    //$conn->close();
}

function printResult($result) {
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<br> Color: " . $row["Color"] . " - Weight: " . $row["Weight"] . " - Size: " . $row["Size"] . "<br>";
        }
    } else {
        echo "0 results";
    }
}

?>


<div class="container">
    <div class="jumbotron">
        <h1>Bowling Score Tracking System</h1>
        <p>Database to collect scores, events, pin falls, players, balls used, etc. The reports could be various
            statistics about players such as single-pin spares left, strike percentage, split-conversion percentage,
            etc.)</p>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <h3>Balls</h3>
            <p><?php retrieveAndPrintAllFromTable('Ball') ?></p>
        </div>
        <div class="col-sm-4">
            <h3>Column 2</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
        <div class="col-sm-4">
            <h3>Column 3</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
        </div>
    </div>
</div>


</body>


</html>
