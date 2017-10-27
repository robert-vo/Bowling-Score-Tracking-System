<?php

//Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = "mydbinstance2.cnotb9fanxgq.us-west-2.rds.amazonaws.com:3306/bowling";
        $username = "bowlingdb";
        $password = "bowlingdb";
        $dbname = "bowling";
    } else {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    return new mysqli($servername, $username, $password, $dbname);
}

function attemptDataManipulationLanguageQuery($query) {
    $connection = connectToDatabase();

    if(mysqli_query($connection, $query) == TRUE) {
        return true;
    }
    else {
        return $connection->error;
    }
}

function returnResultForQuery($query) {
    $connection = connectToDatabase();
    $result = $connection->query($query);
    $connection->close();
    return $result;
}
    
function getAllTeamsForAPlayerID($playerID) {
    $query = "SELECT * FROM Team 
              WHERE Leader = '$playerID' 
                OR Player_1 = '$playerID' 
                OR Player_2 = '$playerID' 
                OR Player_3 = '$playerID' 
                OR Player_4 = '$playerID' 
                OR Player_5 = '$playerID'";

    return returnResultForQuery($query);
}

function getAllBalls() {
    $query = "SELECT * FROM Ball";
    return returnResultForQuery($query);
}

function getAllBallsFiltered($orderByColumn) {
    $query = "SELECT * FROM Ball ORDER BY $orderByColumn";
    return returnResultForQuery($query);
}

function printColorSizeWeightFromBall($toPrint) {
    if($toPrint->num_rows > 0) {
        echo "<table style =\"width:25%\">";
            echo '<tr>';
            echo '<th>Select</th>';
            echo '<th><a href="addRoll.php?orderBy=Color">Ball Color</a></th>';
            echo '<th><a href="addRoll.php?orderBy=Weight">Weight</a></th>';
            echo '<th><a href="addRoll.php?orderBy=Size">Size</a></th>';
            echo '</tr>';
        while($row = $toPrint->fetch_assoc()) {
            echo '<tr>';
            printSvgCircles($row['Ball_ID'], $row['Color']);
            echo "<th>". $row['Weight'] . "</th>";
            echo "<th>". $row['Size'] . "</th>";
            echo '</tr>';
        }
        echo '</table>';
    }
}

function printSvgCircles($ballID, $color) {
    echo "<th><input type=radio name=ballID value=$ballID></th>";
    echo '<th><svg height = 50 width = 50>';
    echo "<circle cx=25 cy=25 r=20 stroke=black stroke-width=2 fill='$color'/>";
    echo '</svg></th>';
}

function attemptToInsertIntoBalls($color, $weight, $size) {
    $query = "INSERT INTO Ball (Color, Weight, Size) VALUES ('$color', $weight, $size)";

    $result = attemptDataManipulationLanguageQuery($query);

    if($result == TRUE) {
        echo '<br>Ball successfully created! You can go back to the previous page to use your new ball!';
    }
    else {
        echo $result;
    }
}

function getIntegerNumberOfPinsHitForRollID($rollID) {
    $sql = "select Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Foul, Is_Spare, Is_Strike from Roll where Roll_ID = $rollID;";

    $result = returnResultForQuery($sql);

    if($result) {
        while($row = $result->fetch_assoc()) {
            return calculateIntegerNumberOfPinsHit($row['Hit_Pin_1'],
                $row['Hit_Pin_2'], $row['Hit_Pin_3'], $row['Hit_Pin_4'],
                $row['Hit_Pin_5'], $row['Hit_Pin_6'], $row['Hit_Pin_7'],
                $row['Hit_Pin_8'], $row['Hit_Pin_9'], $row['Hit_Pin_10']);
        }
    }
    else {
        return 0;
    }
    return 0;
}

function calculateIntegerNumberOfPinsHit($pins) {
    return array_sum($pins);
}


?>