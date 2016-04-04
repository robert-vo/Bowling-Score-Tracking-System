<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php

include 'databaseFunctions.php';

//joseph test

function retrieveAndPrintAllFromTable($tableName, $destination) {
    $conn = connectToDatabase($destination);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM $tableName";
    $result = $conn->query($sql);

    printResult($result);

    $conn->close();
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


<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
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
            <p><?php retrieveAndPrintAllFromTable('Ball', 'Remote') ?></p>
        </div>
        <div class="col-sm-4">
            <h3>Column 2</h3>
            <p>Latin is weird.</p>
            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
            <p>William testing</p>
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
