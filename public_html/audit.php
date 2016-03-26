<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

<body>
<?php
function connectToDatabase()
{
    $servername = "localhost:3306";
    $username = "root";
    $password = "password";
    $dbname = "bowling";
// Create connection
    return new mysqli($servername, $username, $password, $dbname);
}

function retrieveAndPrintAllFromTable($tableName)
{
    $conn = connectToDatabase();

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Column_name FROM Information_schema.columns WHERE Table_name LIKE 'Ball';";
    $allColumns = $conn->query($sql);

    $sql1 = "SELECT * FROM $tableName";
    $result = $conn->query($sql1);


    createTable($allColumns, $result);

    $conn->close();
}

function createTable($allColumns, $result)
{
    $allColumnsAsArray = array();

    echo "<table style =\"width:100%\">";
    echo "<tr>";

    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
            echo "<th>" . $row["Column_name"] . "</th>";
        }
        echo "<th> Perform Action </th>";
        echo "</tr>";
    } else {
        echo "0 results";
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";

            foreach ($allColumnsAsArray as $column) {
                echo "<th>" . $row[$column] . "</th>";
            }
            echo "<th> <button type=button>Update</button><button type=button>Delete</button></th>" .
                "</tr>";
        }
    } else {
        echo "0 results";
    }

    echo "</table>";
}

?>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a class="active" href="audit.php">Audit</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a href="loginF.php">Login</a></li>
</ul>

<p>
    Which table do you want to edit?
    <select name="bowlingAudit">
        <option value="">Select...</option>
        <option value="Ball">Ball</option>
        <option value="Events">Events</option>
        <option value="Frame">Frame</option>
        <option value="Game">Game</option>
        <option value="Players">Players</option>
        <option value="Roll">Roll</option>
        <option value="Statistics">Statistics</option>
        <option value="Team">Team</option>
    </select>
</p>


<?php retrieveAndPrintAllFromTable('Ball') ?>


</body>
</html>
