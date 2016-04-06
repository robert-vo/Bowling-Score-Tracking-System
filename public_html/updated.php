<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <style>
        table {
            width: 35%;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        th, td {
            padding: 5px;
        }
        div#center {
            justify-content: center;
            text-align: center;
        }
        fieldset {
            display: inline;
            margin: auto;
        }
    </style>
</head>

<body>

<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a class="active" href="audit.php">Audit</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a href="loginF.php">Login</a></li>
</ul>

<?php

include 'databaseFunctions.php';


function getColumnNames($tableName)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);

    $conn->close();

    $columnNames = array();
    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($columnNames, $row["Column_name"]);
        }
    } else {
        echo "0 results";
    }
    return $columnNames;
}


function retrieveRow($table, $id)
{
    $column = $_POST['id_column'];
    $conn = connectToDatabase();

    if($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT * FROM $table WHERE $column = $id";
    $result = $conn->query($query);
    $conn->close();

    return $result;
}


function updateDB() {
    $columnNames = getColumnNames($_POST['table']);
}


function displayMessage()
{
    echo "<p>The " . $_POST['table'] . " has been updated to</p>";
    echo "<table>";

    $columnNames = getColumnNames($_POST['table']);
    $result = retrieveRow($_POST['table'], $_POST['id']);

    if((count($columnNames) > 0) and ($result->num_rows > 0)) {
        while($row = $result->fetch_assoc()) {
            if(count($row) == count($columnNames)) {
                for($i = 0; $i < count($row); $i++) {
                    echo "<tr>";
                    echo "<td><b>" . $columnNames[$i] . "</b></td>";
                    echo "<td>" . $row[$columnNames[$i]] . "</td>";

                    echo "</tr>";
                }
             }
        }
    } else {
        echo "0 results";
    }

    echo "</table>";
    echo    "<form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_POST['table'] . "'>
                <input type='submit' value='Back to table'>
            </form>";
}



displayMessage();

?>




</body>

</html>
