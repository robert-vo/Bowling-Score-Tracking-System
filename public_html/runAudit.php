<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

</html>

<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<?php

include 'databaseFunctions.php';


function retrieveAndPrintAllFromTable($tableName)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);

    $queryToGetAllDataOfATable = "SELECT * FROM $tableName";
    $result = $conn->query($queryToGetAllDataOfATable);

    createTableOnWebpage($allColumns, $result);

    $conn->close();
}

function createTableOnWebpage($allColumns, $result)
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


echo $_POST["bowlingAudit"];


if($_POST["bowlingAudit"] == "") {
    //echo "if";
    echo "
        <script type='text/javascript'>
            alert('You forgot to select a table!');
            history.go(-1);
        </script>
    ";
} else {
    //echo "else";
    echo $_POST["bowlingAudit"];
    retrieveAndPrintAllFromTable($_POST["bowlingAudit"]);
}

?>