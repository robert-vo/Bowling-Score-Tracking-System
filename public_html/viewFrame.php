<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

echo '<h1><div text align="center">Frame Information</div></h1>';

function getRollInformationForFrame($frameID, $frameNumber) {

    $conn = connectToDatabase();
    $sql = "SELECT * FROM ROLL, BALL WHERE Roll.Frame_ID = $frameID and Roll.Ball_ID = Ball.Ball_ID";

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $roll = 1;
        while($row = $result->fetch_assoc()) {
            echo '<br>On Frame Number ' . $frameNumber . ', and for roll number ' . $roll . ', the ' . $row['Size'] . ' ';
            $roll++;
            echo $row['Color'] . ' ball that weighted ' . $row['Weight'] . ' pounds was used.';

            echo '<br>Here is what happened to the following pins:';

            if($row['Hit_Pin_1'] == 1) {
                echo '<br>Pin number 1 was hit!';
            }
            else {
                echo '<br>Pin number 1 was not hit!';
            }

            if($row['Hit_Pin_2'] == 1) {
                echo '<br>Pin number 2 was hit!';
            }
            else {
                echo '<br>Pin number 2 was not hit!';
            }

            if($row['Hit_Pin_3'] == 1) {
                echo '<br>Pin number 3 was hit!';
            }
            else {
                echo '<br>Pin number 3 was not hit!';
            }

            if($row['Hit_Pin_4'] == 1) {
                echo '<br>Pin number 4 was hit!';
            }
            else {
                echo '<br>Pin number 4 was not hit!';
            }

            if($row['Hit_Pin_5'] == 1) {
                echo '<br>Pin number 5 was hit!';
            }
            else {
                echo '<br>Pin number 5 was not hit!';
            }

            if($row['Hit_Pin_6'] == 1) {
                echo '<br>Pin number 6 was hit!';
            }
            else {
                echo '<br>Pin number 6 was not hit!';
            }

            if($row['Hit_Pin_7'] == 1) {
                echo '<br>Pin number 7 was hit!';
            }
            else {
                echo '<br>Pin number 7 was not hit!';
            }

            if($row['Hit_Pin_8'] == 1) {
                echo '<br>Pin number 8 was hit!';
            }
            else {
                echo '<br>Pin number 8 was not hit!';
            }

            if($row['Hit_Pin_9'] == 1) {
                echo '<br>Pin number 9 was hit!';
            }
            else {
                echo '<br>Pin number 9 was not hit!';
            }

            if($row['Hit_Pin_10'] == 1) {
                echo '<br>Pin number 10 was hit!';
            }
            else {
                echo '<br>Pin number 10 was not hit!';
            }

            if($row['Is_Strike'] == 1) {
                echo '<br>There was a strike!';
            }
            else {
                echo '<br>There was not a strike!';
            }

            if($row['Is_Spare'] == 1) {
                echo '<br>There was a spare!';
            }
            else {
                echo '<br>There was not a spare!';
            }

            if($row['Is_Foul'] == 1) {
                echo '<br>There was a foul!';
            }
            else {
                echo '<br>There was not a foul!';
            }
            echo '<br>';
        }
    }

}

getRollInformationForFrame($_GET['frameID'], $_GET['frameNumber']);
