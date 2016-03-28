<?php //Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = "us-cdbr-azure-central-a.cloudapp.net";
        $username = "ba27b2787a498a";
        $password = "e24ebaaa";
        $dbname = "bowling";
    } else {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    return new mysqli($servername, $username, $password, $dbname);
}

function getAllBallsForcolor($colorOfBall)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $query = "SELECT * FROM BALL WHERE Ball.Color = '$colorOfBall'";
    
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