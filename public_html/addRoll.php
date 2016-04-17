<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
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
        }
        }
    else {
        echo "<script type='text/javascript'>alert('Forgot to select a ball!');</script>";;
    }
}
else if(isset($_POST['ballInsertion'])) {
    header("location:createBall.php");
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

<p>
<form action="addRoll.php" method="POST">
    <input type="submit" value="Click here to add a new ball!" name = "ballInsertion">
    <?php
    if(!isset($_GET['orderBy'])) {
        $toPrint = getAllBalls();
        printColorSizeWeightFromBall($toPrint);
    }
    else {
        $toPrint = getAllBallsFiltered($_GET['orderBy']);
        printColorSizeWeightFromBall($toPrint);
    }?>
    <?php generateCheckboxesForAllPins() ?>
    <h5>
        <input type="submit" value="Submit Roll" name="submit" class="submitButton" onclick="return confirm('Are you sure you have selected the correct pins and a ball for this frame?');">
    </h5>
    <br>
</form>
</body>
</html>