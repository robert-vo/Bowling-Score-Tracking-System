<?php
include 'databaseFunctions.php';
$conn = connectToDatabase();
$sql = "select * from roll where Hit_Pin_1 = 1 and Hit_Pin_2 = 1 and Hit_Pin_3 = 1 and Hit_Pin_4 = 1 and Hit_Pin_5 = 1 and Hit_Pin_6 = 1 and Hit_Pin_7 = 0 and Hit_Pin_8 = 1 and Hit_Pin_9 = 1 and Hit_Pin_10 = 0";
$result = $conn->query($sql);
$numrows = $result->num_rows;
$rollid = array();

if($numrows != 0){
    while($row = mysqli_fetch_assoc($result)){
        $rollid[$row['Roll_ID']] = $row['Roll_ID'];

    }
}
$rollid = array_values($rollid);
for($i = 0; $i < count($rollid);$i++) {
    $rollid[$i] = $rollid[$i] + 1;
}

$numsplit = 0;
for($i = 0; $i < count($rollid);$i++){
    $sql = "select * from roll where Roll_ID = '$rollid[$i]'";
    $result = $conn->query($sql);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while($row = mysqli_fetch_assoc($result)){
            if($row['Hit_Pin_7'] = 1 and $row['Hit_Pin_10'] = 1){
                $numsplit++;
            }
        }
    }
}
echo $numsplit;
?>