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

<br>

<?php

include 'databaseFunctions.php';


$table = $_GET['table'];
$column = $_GET['column'];
$rowid = $_GET['rowid'];


function retrieveAndPrintAllFromTable($tableName, $id_column, $rowid)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);

    $queryToGetAllDataOfATable = "SELECT * FROM $tableName WHERE $id_column = $rowid";
    $result = $conn->query($queryToGetAllDataOfATable);

    createTableOnWebpage($allColumns, $result);

    $conn->close();
}

function createTableOnWebpage($allColumns, $result)
{
    $allColumnsAsArray = array();
    echo    "<div>
            <form action='updated.php' method='post' onsubmit=\"return confirm('Are you sure you want to submit this form?');\">
                <fieldset><legend>Update " . $_GET['table'] . "</legend>
                <input type='hidden' name='id' value='" . $_GET['rowid'] . "'>
                <input type='hidden' name='table' value='" . $_GET['table'] . "'>
                <input type='hidden' name='id_column' value='" . $_GET['column'] . "'>
                    <table align='center'>";

    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
        }
    } else {
        echo "0 results";
    }

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            if(count($allColumnsAsArray) == count($row)) {
                for($i = 0; $i < count($row); $i++) {
                    echo "<tr>";
                    echo "<td><b>" . $allColumnsAsArray[$i] . "</b></td>";
                    echo "<td><input type='text' name='" . $allColumnsAsArray[$i] . "' value='" . $row[$allColumnsAsArray[$i]] . "'> </td>";
                    echo "</tr>";
                }
            }
        }
    } else {
        echo "0 results";
    }

    echo "</table></fieldset</div>";
    echo "<div id='center'><input type='submit' value='Submit Changes'></form></div>";
}

retrieveAndPrintAllFromTable($table, $column, $rowid);

?>


</body>

</html>


