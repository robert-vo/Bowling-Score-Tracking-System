<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';
$conn = connectToDatabase();
$query = "SELECT * FROM player_stats "
?>



</body>
</html>
