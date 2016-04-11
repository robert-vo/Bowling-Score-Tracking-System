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
session_start();
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

</body>
</html>
