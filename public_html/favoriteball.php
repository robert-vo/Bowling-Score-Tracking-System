<?php
session_start();
include 'databaseFunctions.php';
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
$playerid = $_SESSION['player_id'];

$conn = connectToDatabase();
$sql = "Select * from Frame where Player_ID = '$playerid'";
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



// add all the pins together of each roll
$ball = array ();
for($i = 0; $i < count($frame);$i++){
    $sql = "select * from Roll where Frame_ID = '$frame[$i]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while($row = mysqli_fetch_assoc($result)){
            $ball[$row['Roll_ID']] = $row['Ball_ID'];
        }
    }
}
$ball = array_values($ball);
for($i = 0; $i < count($ball);$i++){
    echo $ball[$i]. "<br>";
}
$mode = array_count_values($ball);
echo"<br><br>";
print_r($mode);

?>