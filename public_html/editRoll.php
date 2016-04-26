<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

echo '<h1><div text align="center">Roll Information</div></h1>';

//$gameID = $_POST['gameID'];
if(isset($_POST['submit'])){
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "UPDATE roll SET 
                  Is_Strike = $isStrike
                  Is_Spare = $isSpare
                  Is_Foul = $isFoul
                  Hit_Pin_1 = $pinHit[0]
                  Hit_Pin_2 = $pinHit[1]
                  Hit_Pin_3 = $pinHit[2]
                  Hit_Pin_4 = $pinHit[3]
                  Hit_Pin_5 = $pinHit[4]
                  Hit_Pin_6 = $pinHit[5]
                  Hit_Pin_7 = $pinHit[6]
                  Hit_Pin_8 = $pinHit[7]
                  Hit_Pin_9 = $pinHit[8]
                  Hit_Pin_10 = $pinHit[9]
                  WHERE Roll_ID = $rollID";
    $result = $conn->query($query);
    if($result){
        echo "<script type='text/javascript'>alert('Roll Updated!');</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('The roll could not be recorded!');</script>";
    }
}

function getRollInformation($rollID) {
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM ROLL, BALL WHERE Roll_ID= $rollID and Roll.Ball_ID = Ball.Ball_ID";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        $gameID = $_GET['gameID'];
        echo "<form action='viewGame.php?gameID=$gameID method='post' onsubmit=\"return confirm('Are you sure the information is correct?');\">";

        //get data from checkboxes
        $isChecked = "";
        $isStrike = 0;
        $isSpare = 0;
        $isFoul = 0;

        if($row["Is_Strike"] == 1) {
            $isChecked = "checked";
            $isStrike = 1;
        }
        else $isChecked = "";
        echo "<br>Strike:<a type='checkbox' name='isStrike' $isChecked></a>";

        if($row["Is_Spare"] == 1) {
            $isChecked = "checked";
            $isSpare = 1;
        }
        else $isChecked = "";
        echo "<br>Spare:<input type='checkbox' name='isSpare' $isChecked>";

        if($row["Is_Foul"] == 1) {
            $isChecked = "checked";
            $isFoul = 1;
        }
        else $isChecked = "";
        echo "<br>Foul:<input type='checkbox' name='isFoul' $isChecked>";

        echo "<br><br>";

        //get data from pins
        $pinHit = array(0,0,0,0,0,0,0,0,0,0);
        for ($pin = 1; $pin < 10; $pin++) {
            $pinHit[$pin] = $row["Hit_Pin_$pin"];
//            echo $pinHit[$pin];

            if($row["Hit_Pin_$pin"] == 1) $isChecked = "checked";
            else $isChecked = "";
            echo "Pin $pin : <input type='checkbox' name='pin$pin' $isChecked><br>";
        }
        echo "<input type='submit' value='Enter'>
            </form>";


    }

}

getRollInformation($_GET['rollID']);
