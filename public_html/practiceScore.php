<?php
session_start();
include 'databaseFunctions.php';
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
$playerid = $_SESSION['player_id'];

$conn = connectToDatabase();
$sql = "Select * from frame where Player_ID = '$playerid'";
$result = $conn->query($sql);
$numrows = $result->num_rows;
$frame = array ();
if($numrows != 0){
    while ($row = mysqli_fetch_assoc($result)){
        $frame[$row['Frame_ID']] = $row['Frame_ID'];
    }
}
//print_r($frame);
//echo "<br> Frames for player: ".count($frame)."<br><br>";


$frame = array_values($frame);
$pins = array ();
for($i = 0; $i < count($frame);$i++){
    $sql = "select * from roll where Frame_ID = '$frame[$i]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while($row = mysqli_fetch_assoc($result)){
            $pins[$row['Roll_ID']] = $row['Hit_Pin_1'] + $row['Hit_Pin_2'] + $row['Hit_Pin_3'] + $row['Hit_Pin_4'] + $row['Hit_Pin_5'] + $row['Hit_Pin_6'] + $row['Hit_Pin_7'] + $row['Hit_Pin_8'] + $row['Hit_Pin_9'] + $row['Hit_Pin_10'];
        }
    }
}

//print_r($pins);
//echo "<br>". count($pins);
$pinsLeft = (count($pins) * 10) - array_sum($pins);
//echo "<br>". $pinsLeft;

$PLA = $pinsLeft / count($pins);


//echo "<br>". $PLA;

$sql = "update Player_Stats set player_stats.Pins_Left = '$pinsLeft' where Player_ID = '$playerid'";
$conn = connectToDatabase();
$conn->query($sql);

$sql = "update Player_Stats set player_stats.Average_Pin_Left = '$PLA' where Player_ID = '$playerid'";
$conn = connectToDatabase();
$conn->query($sql);

?>