<?php
session_start();
include 'databaseFunctions.php';
$playerid = $_SESSION['player_id'];
$conn = connectToDatabase();
$sql = "SELECT * FROM Team WHERE Leader = '$playerid' or Player_1 = '$playerid' or Player_2 = '$playerid' or Player_3 = '$playerid' or Player_4 = '$playerid' or Player_5 = '$playerid'";
$result = $conn->query($sql);
$numrows = $result->num_rows;
$team = array();
if($numrows != 0){
    while($row = mysqli_fetch_assoc($result)){
        $team[$row['Team_ID']] = $row['Team_ID'];
    }
}
$team = array_values($team);

print_r($team);
echo "<br> teams: " . count($team)."<br>";


$game = array();

$int2 = 0;
for($int = 0; $int  < count($team);$int++){
    
    $sql = "SELECT * FROM Game WHERE Teams LIKE '$team[$int],%' OR Teams LIKE '%,$team[$int],%' OR Teams LIKE '%,$team[$int]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;

    if($numrows != 0){
        while($row = mysqli_fetch_assoc($result)){
            $gameID = $row['Game_ID'];
            $game[$int2] = $row['Game_ID'];
            $int2++;
        }
    }
}
echo "<br>";
print_r($game);
echo "<br> games: ". count($game)."<br>";



$frame = array();

for($int = 0; $int < count($game);$int++){
    $sql = "SELECT * FROM Frame WHERE Game_ID = '$game[$int]' AND Player_ID = $playerid";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){

             $frame[$row['Frame_ID']] = $row['Frame_ID'];
        }
    }

}


$frame = array_values($frame);

print_r($frame);
echo "<br> frames: " . count($frame)."<br>";



for($int = 0; $int < count($frame);$int++){
    $sql = "SELECT * FROM Roll WHERE Frame_ID = '$frame[$int]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){

            $roll[$row['Roll_ID']] = $row['Roll_ID'];
        }
    }

}


$roll = array_values($roll);
print_r($roll);
echo "<br> rolls: " . count($roll)."<br>";

//check for sprike and spare for each for then add
for($int = 0; $int < count($roll);$int++){
    $sql = "SELECT * FROM Roll WHERE Roll_ID = '$roll[$int]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){

            $pins_hit[$row['Roll_ID']] = $row['Hit_Pin_1'] + $row['Hit_Pin_2'] + $row['Hit_Pin_3'] + $row['Hit_Pin_4'] + $row['Hit_Pin_5'] + $row['Hit_Pin_6'] + $row['Hit_Pin_7'] + $row['Hit_Pin_8'] + $row['Hit_Pin_9'] + $row['Hit_Pin_10'];
            if($row['Is_Spare'] == 1){
                $spares[$row['Roll_ID']] = $row['Roll_ID'];
            }
            if($row['Is_Strike'] == 1){
                $strike[$row['Roll_ID']] = $row['Roll_ID'];
            }
        }
    }

}
echo "<br> Strike: ";
print_r($strike);
echo "<br>";

echo "<br> Spare: ";
print_r($spares);
echo "<br><br>";
//$pins_hit = array_values($pins_hit);

print_r($pins_hit);
echo "<br> pins hit: " . count($pins_hit)."<br>";



//for($i = 1; $i < count($pins_hit);$i++){
//    if($pins_hit[$i] == 10){
//        $pins_hit[$i]+$pins_hit[$i+1]+$pins_hit[$i+2];
//    }
//    else if ($pins_hit[$i] + $pins_hit[$i+1] == 10){
//
//    }
//    echo "(".$pins_hit[$i];
//    if($i+1 <count($pins_hit)){
//        echo ",". $pins_hit[$i+1];
//    }
//    echo ")<br>";
//    $i++;
//}
$pins_hit = array_values($pins_hit);
for($i = 0; $i < count($pins_hit);$i++){
    echo $pins_hit[$i]."<br>";
}

?>