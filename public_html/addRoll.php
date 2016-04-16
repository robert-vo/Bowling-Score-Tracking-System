<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

if(isset($_POST['submit'])) {
    echo $_POST['balls'];
    if(!isset($_POST['pins'])) {
        echo 'no pins hit!';
    }
    else {
        foreach($_POST['pins'] as $pin) {
            echo 'You have hit pin ' . $pin . '<br>';
        }
    }
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
    <title>Roll</title>
</head>
<body>

<p>
<form action="addRoll.php" method="POST">
    <select name="balls">
        <?php printColorSizeWeightFromBall() ?>
    </select>
    <?php generateCheckboxesForAllPins() ?>
    <br>
    <input type="submit" value="Submit Roll" name="submit">
</form>
</body>
</html>