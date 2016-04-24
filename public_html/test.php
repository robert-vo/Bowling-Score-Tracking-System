<?php
session_start();
//include 'menuBar.php';
//generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

if(isset($_POST['submit'])) {
    if(isset($_POST['color'])) {
        if(!isset($_POST['pins'])) {
            echo 'No pins hit!';
        }
        else {
            echo 'You hit ' . count($_POST['pins']) . ' balls!<br>';
            foreach($_POST['pins'] as $pin) {
                echo 'You have hit pin ' . $pin . '<br>';
            }
            if(count($_POST['pins']) == 10) {
                playMarioVideo();
                header( "refresh:6;url=test.php" );

            }
            else {
                playAndyVideo();
                header( "refresh:3;url=test.php" );

            }
        }
    }
    else {
        echo "<script type='text/javascript'>alert('Forgot to select a ball!');</script>";;
    }
}
else if(isset($_POST['ballInsertion'])) {
    header("location:createBall.php");
}

function playMarioVideo() {
    echo '<div style=\'position:absolute;z-index:9;left:50px;top:0;width:100%;height:100%\'><video width="1000" height="1000" autoplay>
  <source src="../resources/img/strike.mp4" type="video/mp4">
</video></div>';
}

function playAndyVideo() {
    echo '<div style=\'position:absolute;z-index:9;left:50px;top:0;width:100%;height:100%\'><video width="1000" height="1000" autoplay>
  <source src="../resources/img/test.mp4" type="video/mp4">
</video></div>';
}
function generateCheckboxesForAllPins () {
    foreach (range(1, 10) as $pin) {
        echo "<span class = pin$pin>";
        echo "<input type = checkbox name =pins[] value = $pin id = 'pin$pin'/>";
        echo "<label for = 'pin$pin'>$pin</label>";
        echo "</span>";
    }
}
?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="roll.css">
    <link rel="stylesheet" type="text/css" href="audit.css">

    <title>Roll</title>
</head>
<body>

<?php
foreach (range(11,140) as $item) {
    if($item % 10 == 0) {
                echo "<br>INSERT INTO bowling.Roll 
        (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
            1 . ", " . 0 . ", " . 1 . ", " . 0 . ", " . 1 . ", " . 1 . ", " . 1 . ", " . 0 . ", " . 1 . ", " . 0 . ");";
        echo "<br>INSERT INTO bowling.Roll 
        (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Spare) VALUES ($item,  " . rand(1, 20) . ", " .
            0 . ", " . 1 . ", " . 0 . ", " . 1 . ", " . 0 . ", " . 0 . ", " . 0 . ", " . 1 . ", " . 0 . ", " . 1 . ", 1);";

//        $counter = 0;
//        $pin1 = rand(0, 1);
//        $pin2 = rand(0, 1);
//        $pin3 = rand(0, 1);
//        $pin4 = rand(0, 1);
//        $pin5 = rand(0, 1);
//        $pin6 = rand(0, 1);
//        $pin7 = rand(0, 1);
//        $pin8 = rand(0, 1);
//        $pin9 = rand(0, 1);
//        $pin10 = rand(0, 1);
//        echo "<br>INSERT INTO bowling.ROLL
//        (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
//            $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ");";
//        if($pin1 == 1) {
//            $counter++;
//            $pin1 = 0;
//        }
//        else {
//            $pin1 = rand(0, 1);
//        }
//        if($pin2 == 1) {
//            $counter++;
//            $pin2 = 0;
//        }
//        else {
//            $pin2 = rand(0, 1);
//        }
//        if($pin3 == 1) {
//            $counter++;
//            $pin3 = 0;
//        }
//        else {
//            $pin3 = rand(0, 1);
//        }
//        if($pin4 == 1) {
//            $counter++;
//            $pin4 = 0;
//        }
//        else {
//            $pin4 = rand(0, 1);
//        }
//        if($pin5 == 1) {
//            $counter++;
//            $pin5 = 0;
//        }
//        else {
//            $pin5 = rand(0, 1);
//        }
//        if($pin6 == 1) {
//            $counter++;
//            $pin6 = 0;
//        }
//        else {
//            $pin6 = rand(0, 1);
//        }
//        if($pin7 == 1) {
//            $counter++;
//            $pin7 = 0;
//        }
//        else {
//            $pin7 = rand(0, 1);
//        }
//        if($pin8 == 1) {
//            $counter++;
//            $pin8 = 0;
//        }
//        else {
//            $pin8 = rand(0, 1);
//        }
//        if($pin9 == 1) {
//            $counter++;
//            $pin9 = 0;
//        }
//        else {
//            $pin9 = rand(0, 1);
//        }
//        if($pin10 == 1) {
//            $counter++;
//            $pin10 = 0;
//        }
//        else {
//            $pin10 = rand(0, 1);
//        }
//        echo "<br>INSERT INTO bowling.ROLL
//        (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
//            $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ");";

//        if($counter == 10) {
            echo "<br>INSERT INTO bowling.Roll 
                (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
                rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ", " . rand(0,1) . ");";
//        }
//        else {
//        }

    }
    else {
        $pin1 = rand(0, 1);
        $pin2 = rand(0, 1);
        $pin3 = rand(0, 1);
        $pin4 = rand(0, 1);
        $pin5 = rand(0, 1);
        $pin6 = rand(0, 1);
        $pin7 = rand(0, 1);
        $pin8 = rand(0, 1);
        $pin9 = rand(0, 1);
        $pin10 = rand(0, 1);
        $pinsHit = $pin1 + $pin2 + $pin3 + $pin4 + $pin5 + $pin6 + $pin7 + $pin8 + $pin9 + $pin10;
        if($pinsHit == 10) {
            echo "<br>INSERT INTO bowling.Roll 
        (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Strike) VALUES ($item,  " . rand(1, 20) . ", " .
                $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ", 1);";
        }
        else {
            echo "<br>INSERT INTO bowling.Roll 
            (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
                $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ");";
            $pin1 = $pin1 == 1 ? 0 : rand(0, 1);
            $pin2 = $pin2 == 1 ? 0 : rand(0, 1);
            $pin3 = $pin3 == 1 ? 0 : rand(0, 1);
            $pin4 = $pin4 == 1 ? 0 : rand(0, 1);
            $pin5 = $pin5 == 1 ? 0 : rand(0, 1);
            $pin6 = $pin6 == 1 ? 0 : rand(0, 1);
            $pin7 = $pin7 == 1 ? 0 : rand(0, 1);
            $pin8 = $pin8 == 1 ? 0 : rand(0, 1);
            $pin9 = $pin9 == 1 ? 0 : rand(0, 1);
            $pin10 = $pin10 == 1 ? 0 : rand(0, 1);
            $pinsHit += $pin1 + $pin2 + $pin3 + $pin4 + $pin5 + $pin6 + $pin7 + $pin8 + $pin9 + $pin10;
            if($pinsHit == 10) {
                echo "<br>INSERT INTO bowling.Roll 
                    (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Spare) VALUES ($item,  " . rand(1, 20) . ", " .
                    $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ", 1);";
            }
            else {
                echo "<br>INSERT INTO bowling.Roll 
                (Frame_ID, Ball_ID, Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) VALUES ($item,  " . rand(1, 20) . ", " .
                $pin1 . ", " . $pin2 . ", " . $pin3 . ", " . $pin4 . ", " . $pin5 . ", " . $pin6 . ", " . $pin7 . ", " . $pin8 . ", " . $pin9 . ", " . $pin10 . ");";
            }
        }
    }
}
?>


<p>
<!--<form action="test.php" method="POST">-->
<!--    <input type="submit" value="Click here to add a new ball!" name = "ballInsertion">-->
<!--    --><?php
//    if(!isset($_GET['orderBy'])) {
//        $toPrint = getAllBalls();
//        printColorSizeWeightFromBall($toPrint);
//    }
//    else {
//        $toPrint = getAllBallsFiltered($_GET['orderBy']);
//        printColorSizeWeightFromBall($toPrint);
//    }?>
<!--    --><?php //generateCheckboxesForAllPins() ?>
<!--    <h5>-->
<!--        <input type="submit" value="Submit Roll" name="submit" class="submitButton" onclick="return confirm('Are you sure you have selected the correct pins and a ball for this frame?');">-->
<!--    </h5>-->
<!--    <br>-->
<!--</form>-->
</body>
</html>