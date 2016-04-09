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



<?php

include 'menuBar.php';
generateMenuBar(basename(__FILE__));



include 'databaseFunctions.php';


function getColumnNames($tableName)
{
    $conn = connectToDatabase();
    if($conn->connect_error) {
        die("Connction failed: " . $conn->connect_error);
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
    $conn = connectToDatabase();
    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }
    $table = $_POST['table'];
    $id = $_POST['id'];
    // Send the update query, check to see if the update was successful.

    $columnNames = getColumnNames($table);

    $query = "UPDATE $table SET ";
    for($i = 0; $i < count($columnNames); $i++) {
        if($_POST[$columnNames[$i]] == "") {
            echo "Skipping " . $columnNames[$i] . ". ";
            continue;
        }

        $query .= "$columnNames[$i] = " . "'" . $_POST[$columnNames[$i]] . "'";
        if($i + 1 < count($columnNames)) {
            $query .= ", ";
        }
    }
    $query .= " WHERE " . $_POST['id_column'] . " = " . $_POST['id'];
    //echo $query;

    if(mysqli_query($conn, $query) == TRUE) {
        $result = retrieveRow($table, $id);

        echo "<p>The " . $_POST['table'] . " has been updated to</p>";
        echo "<table>";

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
    } else {
        echo "Error: " . $conn->error;
    }

    echo    "<form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_POST['table'] . "'>
                <input type='submit' value='Back to table'>
            </form>";

    $conn->close();
}



displayMessage();

?>




</body>

</html>
