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
    return $connection->query($query);
}
    
function getAllTeamsForAPlayerID($playerID) {
    $query = "SELECT * FROM team 
              WHERE Leader = '$playerID' 
                OR Player_1 = '$playerID' 
                OR Player_2 = '$playerID' 
                OR Player_3 = '$playerID' 
                OR Player_4 = '$playerID' 
                OR Player_5 = '$playerID'";

    return returnResultForQuery($query);
}

function getAllBalls() {
    $query = "SELECT * FROM BALL";
    return returnResultForQuery($query);
}

function getAllBallsFiltered($orderByColumn) {
    $query = "SELECT * FROM BALL ORDER BY $orderByColumn";
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
    echo "<th><input type=radio name=color value=$ballID></th>";
    echo '<th><svg height = 50 width = 50>';
    echo "<circle cx=25 cy=25 r=20 stroke=black stroke-width=2 fill='$color'/>";
    echo '</svg></th>';
}

function attemptToInsertIntoBalls($color, $weight, $size) {
    $query = "INSERT INTO Ball(Color, Weight, Size) VALUES ('$color', $weight, $size)";

    $result = attemptDataManipulationLanguageQuery($query);

    if($result == TRUE) {
        echo '<br>Ball successfully created! You can go back to the previous page to use your new ball!';
    }
    else {
        echo $result;
    }
}

?>