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
include 'menuBar.php';
include 'databaseFunctions.php';

generateMenuBar(basename(__FILE__));
echo "<br>";


function retrieveAndPrintAllFromTable($table)
{
    $conn = connectToDatabase();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $queryAllColumns = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE '$table';";
    $allColumns = $conn->query($queryAllColumns);


    createTableOnWebpage($allColumns);

    $conn->close();
}


function createTableOnWebpage($allColumns)
{
    $allColumnsAsArray = array();
    echo    "<div>
            <form action='created.php' method='post' onsubmit=\"return confirm('Are you sure you want to submit this form?');\">
                <fieldset><legend>Add " . $_POST['table'] . "</legend>
                <input type='hidden' name='table' value='" . $_POST['table'] . "'>
                    <table align='center'>";

    if ($allColumns->num_rows > 0) {
        while ($row = $allColumns->fetch_assoc()) {
            array_push($allColumnsAsArray, $row["Column_name"]);
        }
        for($i = 1; $i < count($allColumnsAsArray); $i++) {
            echo "<tr>";
            echo "<td><b>" . $allColumnsAsArray[$i] . "</b></td>";
            echo "<td><input type='text' name='" . $allColumnsAsArray[$i] . "' value=''> </td>";
            echo "</tr>";
        }

    } else {
        echo "0 results";
    }


    echo "</table></fieldset</div>";
    echo "<div id='center'><input type='submit' value='Add entry'></form></div>";
}

$table = $_POST['table'];
retrieveAndPrintAllFromTable($table);

?>







</body>


</html>
