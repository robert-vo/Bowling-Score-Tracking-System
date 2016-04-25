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
        $row = $result->fetch_assoc();
        echo '<br>On Roll ' . $rollID . ' of Frame '.$row["Frame_ID"].', the ' . $row['Size'] . ' '. $row['Color'] . ' 
            ball that weighed ' . $row['Weight'] . ' pounds was used.<br>';

        $isChecked = "";
        echo "<form action='viewGame.php' method='post' onsubmit=\"return confirm('Are you sure the information is correct?');\">";

        
        if($row["Is_Strike"] == 1) $isChecked = "checked";
        else $isChecked = "";
        echo "<br>Strike:<input type='checkbox' name='isStrike' $isChecked>";

        if($row["Is_Spare"] == 1) $isChecked = "checked";
        else $isChecked = "";
        echo "<br>Spare:<input type='checkbox' name='isSpare' $isChecked>";

        if($row["Is_Foul"] == 1) $isChecked = "checked";
        else $isChecked = "";
        echo "<br>Foul:<input type='checkbox' name='isFoul' $isChecked>";

        echo "<br><br>";

        for ($pin = 1; $pin < 10; $pin++) {
            if($row["Hit_Pin_$pin"] == 1) $isChecked = "checked";
            else $isChecked = "";
            echo "Pin $pin : <input type='checkbox' name='pin$pin' $isChecked><br>";
        }

        echo "<input type='submit' value='Enter'>
            </form>";


    }

}

getRollInformation($_GET['rollID']);
