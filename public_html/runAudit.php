<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>


<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<body>


<?php

include 'databaseFunctions.php';


function retrieveAndPrintAllFromTable($tableName)
{
    $conn = connectToDatabase(); //mysqli object

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);

    $queryToGetAllDataOfATable = "SELECT * FROM $tableName";
    $result = $conn->query($queryToGetAllDataOfATable);

    createTableOnWebpage($allColumns, $result, $tableName);

    $conn->close();
}


function createTableOnWebpage($allColumns, $result, $tableName)
{
    $allColumnsAsArray = array();

    echo "<div id=\"display\">";
    echo "<div id='asdf'></div>";

    echo "<table style =\"width:100%\">";
    echo "<tr>";

    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
            echo "<th><b>" . $row["Column_name"] . "</b></th>";
        }
        echo "<th> Perform Action </th>";
        echo "</tr>";
    } else {
        echo "0 results";
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rowid = -1;
            $id_column = "";
            echo "<tr>";
            foreach ($allColumnsAsArray as $column) {
                if($column == $allColumnsAsArray[0]) {  // Checks to see if the column is the id-column in in the table.
                    $columnName = $column;
                    $rowid = $row[$column];
                }
                echo "<td align='center'>" . $row[$column] . "</td>";
            }
            //<button type=button>Delete</button></td>";
            //$string = $tableName . "," . $id_column . "," . $rowid;
            //$table = json_encode($tableName);
            //$rowId = json_encode($rowid);
            //$columnName = json_encode($id_column);

            /*echo "<td align='center'>
                <button type='button' onclick='showTable(" . $table . "," . $column_name . "," . $row_id . ")'>Update</button>
                <button type='button'>Delete</button>";*/

            echo    "<td align='center'>
                        <form action='updateRow.php' method='get'>
                            <input type='hidden' name='table' value='$tableName'>
                            <input type='hidden' name='column' value='$columnName'>
                            <input type='hidden' name='rowid' value='$rowid'>
                            <input type='submit' value='Update'>
                        </form>
                    </td>";

            echo "</tr>";
        }
    } else {
        echo "0 results";
    }

    echo "</table>";
    
    echo "</div>";
}


if($_POST["bowlingAudit"] == "") {
    echo "
        <script type='text/javascript'>
            alert('You forgot to select a table!');
            history.go(-1);
        </script>
    ";
} else {
    echo "<br>";
    retrieveAndPrintAllFromTable($_POST["bowlingAudit"]);
}
?>

</body>

</html>
