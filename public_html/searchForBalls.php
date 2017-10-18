<?php 

include 'databaseFunctions.php';

function getAllBallsForColor($colorOfBall)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $query = "SELECT * FROM Ball WHERE Ball.Color = '$colorOfBall'";
    
    $result = $conn->query($query);
    
    if (!$result) {
        die('Invalid query' . mysql_error());
    }
    else {
        echo "You searched for the color $colorOfBall and got $result->num_rows rows!";
        printAll($result);
    }
    $conn->close();
}

function printAll($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<br> Ball_ID: " . $row["Ball_ID"] . " Color: " . $row["Color"] . " Weight: " . $row["Weight"] . " Size: " . $row["Size"] . "</br>";
        }
    }
}


?>

<?php getAllBallsForColor($_POST["color"]); ?>