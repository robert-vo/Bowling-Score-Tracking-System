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
    $sql = "SELECT * FROM Roll, Ball WHERE Roll.Frame_ID = $frameID and Roll.Ball_ID = Ball.Ball_ID";

    $result = $conn->query($sql);

    $hitpin1 = 0;
    $hitpin2 = 0;
    $hitpin3 = 0;
    $hitpin4 = 0;
    $hitpin5 = 0;
    $hitpin6 = 0;
    $hitpin7 = 0;
    $hitpin8 = 0;
    $hitpin9 = 0;
    $hitpin10 = 0;

    if($result->num_rows > 0) {
        $roll = 1;
        while($row = $result->fetch_assoc()) {
            echo '<br>On Frame Number ' . $frameNumber . ', and for roll number ' . $roll . ', the ' . $row['Size'] . ' ';
            $roll++;



            echo $row['Color'] . ' ball that weighted ' . $row['Weight'] . ' pounds was used.';
            $color = $row['Color'];
            echo ' Bowling ball for reference: <svg height = 50 width = 50>';
            echo "<circle cx=25 cy=25 r=20 stroke=black stroke-width=2 fill='$color'/>";
            echo '</svg>';

            echo '<br>Here are the new pins hit:<br>';

            echo '<table><tr><td>Pin 1</td><td>Pin 2</td><td>Pin 3</td><td>Pin 4</td><td>Pin 5</td><td>Pin 6</td><td>Pin 7</td><td>Pin 8</td><td>Pin 9</td><td>Pin 10</td></tr>';

            echo '<tr>';
            if($row['Hit_Pin_1'] == 1) {
                printBall(1, 1);
                $hitpin1 = 1;
            }
            else {
                printBall(1, 0);
            }

            if($row['Hit_Pin_2'] == 1) {
                printBall(2, 1);
                $hitpin2 = 1;
            }
            else {
                printBall(2, 0);
            }

            if($row['Hit_Pin_3'] == 1) {
                printBall(3, 1);
                $hitpin3 = 1;
            }
            else {
                printBall(3, 0);
            }

            if($row['Hit_Pin_4'] == 1) {
                printBall(4, 1);
                $hitpin4 = 1;
            }
            else {
                printBall(4, 0);
            }

            if($row['Hit_Pin_5'] == 1) {
                printBall(5, 1);
                $hitpin5 = 1;
            }
            else {
                printBall(5, 0);
            }

            if($row['Hit_Pin_6'] == 1) {
                printBall(6, 1);
                $hitpin6 = 1;
            }
            else {
                printBall(6, 0);
            }

            if($row['Hit_Pin_7'] == 1) {
                printBall(7, 1);
                $hitpin7 = 1;
            }
            else {
                printBall(7, 0);
            }

            if($row['Hit_Pin_8'] == 1) {
                printBall(8, 1);
                $hitpin8 = 1;
            }
            else {
                printBall(8, 0);
            }

            if($row['Hit_Pin_9'] == 1) {
                printBall(9, 1);
                $hitpin9 = 1;
            }
            else {
                printBall(9, 0);
            }

            if($row['Hit_Pin_10'] == 1) {
                printBall(10, 1);
                $hitpin19 = 1;
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

    echo '<br>Out of all of the frames, here are all of the pins you hit.';
    echo '<table><tr><td>Pin 1</td><td>Pin 2</td><td>Pin 3</td><td>Pin 4</td><td>Pin 5</td><td>Pin 6</td><td>Pin 7</td><td>Pin 8</td><td>Pin 9</td><td>Pin 10</td></tr>';

    echo '<tr>';
    if($hitpin1) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin2) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin3) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin4) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin5) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin6) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin7) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin8) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin9) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    if($hitpin10) {
        echo '<td>✓</td>';
    }
    else {
        echo '<td></td>';
    }

    echo '</tr>';
}

getRollInformationForFrame($_GET['frameID'], $_GET['frameNumber']);
