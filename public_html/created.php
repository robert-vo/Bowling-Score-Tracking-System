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
include 'databaseFunctions.php';
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
//Starts the session (logged in user)
//IS_ADMIN returns a 0 or 1, or also false or true, respectively. 
//This if statement is equivalent to $_SESSION['user_role'] == 1
//To see how this session variable is accessible, check loginForm.php, line 62. 
if (!$_SESSION['user_role']) {
    header("location:loginForm.php");
} else {
?>
<?php
function getColumnNames($tableName)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
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

function retrieveRow($table, $id, $column)
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT * FROM $table WHERE $column = $id";
    $result = $conn->query($query);
    $conn->close();
    return $result;
}

function displayMessage()
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $table = $_POST['table'];
    $columnNames = getColumnNames($table);
    $query = "INSERT INTO bowling.$table (";
    $columns = array(); // Array that holds column names of the values to be inserted
    $values = array(); // Array that holds values to be inserted
    for ($i = 1; $i < count($columnNames); $i++) {
        if($columnNames[$i] == "Date_Added" || $columnNames[$i] == "Last_Date_Modified" || $columnNames[$i] == "Date_Joined" || $columnNames[$i] == "Date_Deleted") {
            continue;
        }
        else if ($_POST[$columnNames[$i]] == "") {
            continue;
        }
        else {
            array_push($columns, $columnNames[$i]);
            array_push($values, $_POST[$columnNames[$i]]);
        }
    }

    for ($i = 0; $i < count($columns); $i++) {
        $query .= "$columns[$i]";
        if ($i + 1 < count($columns)) {
            $query .= ", ";
        }
    }
    $query .= ") VALUES (";
    for ($i = 0; $i < count($values); $i++) {
        $query .= "'" . $values[$i] . "'";
        if ($i + 1 < count($values)) {
            $query .= ", ";
        }
    }
    $query .= ");";

    if (mysqli_query($conn, $query) == TRUE) {
        $id = $conn->insert_id;
        $result = retrieveRow($table, $id, $columnNames[0]);
        echo "<p>A new  " . $_POST['table'] . " has been added with the following values </p>";
        echo "<table>";
        if ((count($columnNames) > 0) and ($result->num_rows > 0)) {
            while ($row = $result->fetch_assoc()) {
                if (count($row) == count($columnNames)) {
                    for ($i = 0; $i < count($row); $i++) {
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
        echo "<form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_POST['table'] . "'>
                <input type='submit' value='Back to table'>
            </form>";
    } else {
        $error = "<br>Unable to update. Error: " . $conn->error;
        echo $error . "<br><br>";
        echo "<form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_POST['table'] . "'>
                <input type='submit' value='Back to table'>
            </form>";
    }
    $conn->close();
}
displayMessage();
?>
</body>
</html>
<?php
}
?>