<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="update.css">
</head>
<body>
<?php
session_start();
include 'menuBar.php';
include 'databaseFunctions.php';
generateMenuBar(basename(__FILE__));
echo "<br>";
//Starts the session (logged in user)
//IS_ADMIN returns a 0 or 1, or also false or true, respectively.
//This if statement is equivalent to $_SESSION['user_role'] == 1
//To see how this session variable is accessible, check loginForm.php, line 62.
if (!$_SESSION['user_role']) {
    header("location:loginForm.php");
} else {
?>
<?php
$table = $_GET['table'];
$column = $_GET['column'];
$rowid = $_GET['rowid'];
//$auditValue = $_GET[''];
function retrieveAndPrintRow($tableName, $id_column, $rowid)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $queryAllColumns = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);
    $queryToGetAllDataOfARow = "SELECT * FROM $tableName WHERE $id_column = $rowid";
    $result = $conn->query($queryToGetAllDataOfARow);
    createTableOnWebpage($allColumns, $result);
    $conn->close();
}

function createTableOnWebpage($allColumns, $result)
{
    $allColumnsAsArray = array();
    echo "<div>
        <div>
            Are you sure you want to delete this row?    
            <form action='archived.php' method='post' onsubmit=\"return confirm('THIS DATA WILL BE DELETED.');\">
                <input type='hidden' name='id' value='" . $_GET['rowid'] . "'>
                <input type='hidden' name='table' value='" . $_GET['table'] . "'>
                <input type='hidden' name='id_column' value='" . $_GET['column'] . "'>
                <input type='submit' value='Yes'>
            </form>
            <form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_GET['table'] . "'>
                <input type='submit' value='No'>
            </form>
        </div>
        
        <div id=\"display\">
            <table style =\"width:100%\">
                <tr id='tableheader'>";

    //---COLUMN HEADERS---//
    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
            echo "<th><b>" . $row["Column_name"] . "</b></th>";
        }
    } else {
        echo "0 results";
    }
    //---ROW INFO---//
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rowid = -1;
            $id_column = "";
            echo "<tr>";
            foreach ($allColumnsAsArray as $column) {
                if ($column == $allColumnsAsArray[0]) {  // Checks to see if the column is the id-column in in the table.
                    $columnName = $column;
                    $rowid = $row[$column];
                }
                echo "<td align='center'>" . $row[$column] . "</td>";
            }
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
    echo "</tr></table></div>";
    echo "</div>";
}
retrieveAndPrintRow($table, $column, $rowid);
?>
</body>
</html>
<?php
}
?>