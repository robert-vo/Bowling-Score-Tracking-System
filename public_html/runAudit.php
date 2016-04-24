<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
    <style>
        tr:nth-child(odd) {
            background-color: #e6e6e6;
        }

        .center {
            text-align:center;
        }

        #tableheader {
            background: #4CAF50;
            color: #FFFFFF;
        }
    </style>
</head>


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
}
else
{
?>

<body>


<?php



function retrieveAndPrintAllFromTable($tableName)
{
    $conn = connectToDatabase(); //mysqli object

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tableName';";
    $allColumns = $conn->query($queryAllColumns);

    $queryToGetAllDataOfATable = "SELECT * FROM $tableName";
    $result = $conn->query($queryToGetAllDataOfATable);

    createTableOnWebpage($allColumns, $result, $tableName);

    $conn->close();
}


function createTableOnWebpage($allColumns, $result, $tableName)
{
    $allColumnsAsArray = array();

    echo "<h1 class='center'>$tableName Table</h1>";

    echo "<form action='audit.php'><input type='submit' value='Go back'></form><br>";
    echo "<div id=\"display\">";

    echo "<table style =\"width:100%\">";

    echo "<tr id='tableheader'>";

    if ($allColumns->num_rows > 0) { //Prints the column names as the table header
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
            echo "<th><b>" . $row["Column_name"] . "</b></th>";
        }
        echo "<th> Perform Action </th>";
        echo "</tr>";
    } else {
        echo "0 results";
    }

    //Creates an empty row for the add entry button
    echo "<tr>";
    for ($i = 0; $i < count($allColumnsAsArray); $i++) {
        echo "<td></td>";
    }
    echo "<td align='center'>
                        <form action='createRow.php' method='post'>
                            <input type='hidden' name='table' value='$tableName'>
                            <input type='submit' value='Add Entry'>
                        </form>
                    </td>";
    echo "</tr>";

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

            echo "<td align='center'>
                        <form action='updateRow.php' method='get'>
                            <input type='hidden' name='table' value='$tableName'>
                            <input type='hidden' name='column' value='$columnName'>
                            <input type='hidden' name='rowid' value='$rowid'>
                            <input type='submit' value='Update'>
                        </form>
                        <form action='archiveRow.php' method='get'>
                            <input type='hidden' name='table' value='$tableName'>
                            <input type='hidden' name='column' value='$columnName'>
                            <input type='hidden' name='rowid' value='$rowid'>
                            <input type='submit' value='Delete'>
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


if ($_POST["bowlingAudit"] == "") {
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

<?php
}
?>