<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

$gameID = $_POST['gameID'];
$teamID =  $_POST['teamID'];
$playerID = $_POST['playerID'];
$frameNumber = $_POST['frameNumber'];
$rollID = $_POST['rollID'];

$conn = connectToDatabase();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM Frame WHERE Player_ID = $playerID AND Game_ID = $gameID AND Team_ID = $teamID AND Frame_Number = $frameNumber";
$result = $conn->query($query);
if($result->num_rows > 0) {//frame exists
    echo "The current frame is $frameNumber.<br>";
    $row = $result->fetch_assoc();
    $currentRoll;
    $frameID = $row['Frame_ID'];
    $rollOneID = $row['Roll_One_ID'];
    $rollTwoID = $row['Roll_Two_ID'];
    $rollThreeID = $row['Roll_Three_ID'];

    //pick the next empty roll

    if($frameNumber == 10){ //finish final frame

        //query to test which roll is null
        $query = "SELECT * FROM Roll WHERE Roll_ID = $rollOneID";
        $result = $conn->query($query);
        if($result->num_rows <= 0){

            $currentRoll = $rollOneID;
        }
        else{
            $query = "SELECT * FROM Roll WHERE Roll_ID = $rollTwoID";
            $result = $conn->query($query);
            if($result->num_rows <= 0){

                $currentRoll = $rollTwoID;
            }
            else{
                $query = "SELECT * FROM Roll WHERE Roll_ID = $rollThreeID";
                $result = $conn->query($query);
                if($result->num_rows <= 0){

                    $currentRoll = $rollThreeID;
                }
            }
        }
    }
    else if($frameNumber < 10){//finish current frame
        //select next empty roll ID into currentRoll
        $query = "SELECT * FROM Roll WHERE Roll_ID = $rollOneID";
        $result = $conn->query($query);

        if($result->num_rows > 0){//roll 1 exists
            $pinsDown1 = getNumberOfPinsHitForRollID($rollOneID);
            if($pinsDown1 > 0){//roll one is full

                //look for next roll
                $query = "SELECT * FROM Roll WHERE Roll_ID = $rollTwoID";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {//roll 2 exists
                    $pinsDown2 = getNumberOfPinsHitForRollID($rollTwoID);
                    if($pinsDown2 > 0){
                    }
                }
                else{//roll 2 does not exists
                    $currentRoll = $rollTwoID;
                }
            }

        }
        else{//roll 1 does not exists
            $currentRoll = $rollOneID;
        }
    }
}
else{//query was null, make new frame

    //get next frame ID
    $query = "SELECT max(Frame_ID) as 'max' FROM Frame";
    $result = $conn->query($query);
    $temp = $result->fetch_assoc();
    $newFrameID = $temp['max'] + 1;

    //get next roll ID
    $query = "SELECT max(Roll_ID) as 'max' FROM Roll";
    $result = $conn->query($query);
    $temp = $result->fetch_assoc();
    $newRollID = $temp['max'] + 1;
    $newRollID2 = $newRollID + 1;

    //insert into frame (...)
    $query = "INSERT INTO Frame (Frame_ID, Frame_Number, Player_ID, Roll_One_ID, Roll_Two_ID, Team_ID, Game_ID, Date_Added) values 
              ($newFrameID, $frameNumber, $playerID, $newRollID, $newRollID2, $teamID, $gameID, NOW())";
    $result = $conn->query($query);
    if($result){
    }
    else{
        echo "error: frame not created";
    }

    $currentRoll = $newRollID;
    $frameID = $newFrameID;
}

//we have currentRoll, now get page submit info
$pinHit = array(0,0,0,0,0,0,0,0,0,0);
$ballID;

//read and submit roll
if(isset($_POST['submit'])) {
    if(isset($_POST['ballID'])) {
        $ballID = $_POST['ballID'];
        if(!isset($_POST['pins'])) {
            echo 'No pins hit!';
        }
        else {
            echo 'You hit ' . count($_POST['pins']) . ' pins!<br>';
            foreach($_POST['pins'] as $pin) {
                echo 'You have hit pin ' . $pin . '<br>';
                $pinHit[$pin-1] = 1;
            }
        }
        //calculate special fields
        $isStrike = 0;
        $isFoul = 0;
        if(isset($_POST['isFoul'])){
            $isFoul = 1;
            $query = "INSERT INTO Roll (Roll_ID, Frame_ID, Ball_ID, Is_Foul) VALUES ($currentRoll, $frameID, $ballID, $isFoul)";
        }
        else if(array_sum($pinHit) == 10){
            $isStrike = 1;
            $query = "INSERT INTO Roll 
                  (Roll_ID, Frame_ID, Ball_ID, Is_Strike,
                  Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) 
                  values 
                  ($currentRoll, $frameID, $ballID, $isStrike, $isFoul,
                  $pinHit[0],$pinHit[1],$pinHit[2],$pinHit[3],$pinHit[4],$pinHit[5],$pinHit[6],$pinHit[7],$pinHit[8],$pinHit[9])";
        }
        else {
            $query = "INSERT INTO Roll 
                  (Roll_ID, Frame_ID, Ball_ID, Is_Strike, Is_Foul, 
                  Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10) 
                  values 
                  ($currentRoll, $frameID, $ballID, $isStrike, $isFoul,
                  $pinHit[0],$pinHit[1],$pinHit[2],$pinHit[3],$pinHit[4],$pinHit[5],$pinHit[6],$pinHit[7],$pinHit[8],$pinHit[9])";
        }
        $result = $conn->query($query);
        if($result){
            echo "<script type='text/javascript'>
                   alert('You made a roll!');
                   document.location = 'viewGame.php?gameID=$gameID'
                   </script>";
        }
        else{
            echo "<script type='text/javascript'>alert('The roll could not be recorded!');</script>";
        }
//
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

function getNumberOfPinsHitForRollID($rollID) {
    $sql = "select Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Foul, Is_Spare, Is_Strike from Roll where Roll_ID = $rollID;";
    $conn = connectToDatabase();

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['Is_Foul']) {
                return 'F';
            }
            else if ($row['Is_Spare']) {
                return '/';
            }
            else if($row['Is_Strike']) {
                return 'X';
            }
            else {
                return calculateNumberOfPinsHit($row['Hit_Pin_1'],
                    $row['Hit_Pin_2'], $row['Hit_Pin_3'], $row['Hit_Pin_4'],
                    $row['Hit_Pin_5'], $row['Hit_Pin_6'], $row['Hit_Pin_7'],
                    $row['Hit_Pin_8'], $row['Hit_Pin_9'], $row['Hit_Pin_10']
                );
            }
        }
    }
    return '&nbsp';
}


function calculateNumberOfPinsHit(...$pins) {
    return array_sum($pins) == 0 ? '-' : array_sum($pins);
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
        <?php
        
        echo "<input type='hidden' name='gameID' value=$gameID>
            <input type='hidden' name='teamID' value=$teamID>
            <input type='hidden' name='playerID' value=$playerID>
            <input type='hidden' name='frameNumber' value=$frameNumber>
            <input type='hidden' name='rollID' value='$rollID'>";
        ?>
        <input type="radio" name="isFoul" class="submitButton">foul
        <br>
        <input type="submit" value="Submit Roll" name="submit" class="submitButton" onclick="return confirm('Are you sure you have selected the correct pins and a ball for this frame?');">
    </h5>
    <br>
</form>
</body>
</html>