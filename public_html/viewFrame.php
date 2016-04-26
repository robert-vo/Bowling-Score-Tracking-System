<link rel="stylesheet" type="text/css" href="audit.css">
<link rel="stylesheet" type="text/css" href="roll.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

echo '<h1><div text align="center">Frame Information</div></h1>';

function printBall($pinNumber, $checked) {
    if($checked == 1) {
        echo '<td>';
        echo "✓";
        echo '</td>';

    }
    else {
        echo '<td>';
        echo "";
        echo '</td>';
    }
}

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

            echo '<table><tr><td>Pin 1</td><td>Pin 2</td><td>Pin 3</td><td>Pin 4</td><td>Pin 5</td><td>Pin 6</td><td>Pin 7</td><td>Pin 8</td><td>Pin 9</td><td>Pin 10</td></tr>';

            echo '<tr>';
            if($row['Hit_Pin_1'] == 1) {
                printBall(1, 1);
            }
            else {
                printBall(1, 0);
            }

            if($row['Hit_Pin_2'] == 1) {
                printBall(2, 1);
            }
            else {
                printBall(2, 0);
            }

            if($row['Hit_Pin_3'] == 1) {
                printBall(3, 1);
            }
            else {
                printBall(3, 0);
            }

            if($row['Hit_Pin_4'] == 1) {
                printBall(4, 1);
            }
            else {
                printBall(4, 0);
            }

            if($row['Hit_Pin_5'] == 1) {
                printBall(5, 1);
            }
            else {
                printBall(5, 0);
            }

            if($row['Hit_Pin_6'] == 1) {
                printBall(6, 1);
            }
            else {
                printBall(6, 0);
            }

            if($row['Hit_Pin_7'] == 1) {
                printBall(7, 1);
            }
            else {
                printBall(7, 0);
            }

            if($row['Hit_Pin_8'] == 1) {
                printBall(8, 1);
            }
            else {
                printBall(8, 0);
            }

            if($row['Hit_Pin_9'] == 1) {
                printBall(9, 1);
            }
            else {
                printBall(9, 0);
            }

            if($row['Hit_Pin_10'] == 1) {
                printBall(10, 1);
            }
            else {
                printBall(10, 0);
            }
            echo '</tr>';
            echo '</table>';

            echo '<br>';
            echo '<table>';
            echo '<tr><td>Strike</td><td>Spare</td><td>Foul</td></tr>';
            echo '<tr>';
            if($row['Is_Strike'] == 1) {
                echo '<td>✓</td>';
            }
            else {
                echo '<td></td>';
            }

            if($row['Is_Spare'] == 1) {
                echo '<td>✓</td>';
            }
            else {
                echo '<td></td>';
            }

            if($row['Is_Foul'] == 1) {
                echo '<td>✓</td>';
            }
            else {
                echo '<td></td>';
            }
            echo '</tr>';
            echo '</table>';

            echo '<br>';
        }
    }

}

getRollInformationForFrame($_GET['frameID'], $_GET['frameNumber']);
