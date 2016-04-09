<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

<body>


<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<p>
    Which table do you want to edit?
    <form action="runAudit.php" method="post">
    <select name="bowlingAudit">
        <option value="">Select...</option>
        <?php
        include 'databaseFunctions.php';

        $connection = connectToDatabase();

        $result = $connection->query("select table_name from information_schema.tables where table_schema = 'bowling';");
        $rows = [];
        while($row = $result->fetch_assoc())
        {
            echo "<option value =\"" . $row["table_name"] . "\">" . $row["table_name"] . "</option>";
        }
        ?>
    </select>
    <input type="submit" value="Submit">
</form>
</p>




</body>
</html>
