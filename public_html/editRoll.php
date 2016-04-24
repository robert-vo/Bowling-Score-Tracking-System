<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

echo '<h1><div text align="center">Roll Information</div></h1>';

function getRollInformation($rollID) {

    $conn = connectToDatabase();
    $sql = "SELECT * FROM ROLL, BALL WHERE Roll_ID= $rollID and Roll.Ball_ID = Ball.Ball_ID";

    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        $pin = 1;
        while($row = $result->fetch_assoc()) {
            $roll = 1;
            echo '<br>On Roll ' . $rollID . ', the ' . $row['Size'] . ' '. $row['Color'] . ' 
                ball that weighed ' . $row['Weight'] . ' pounds was used.';

        }
    }

}

getRollInformation($_GET['rollID']);
