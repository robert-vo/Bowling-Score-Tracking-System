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
//Starts the session (logged in user)

//IS_ADMIN returns a 0 or 1, or also false or true, respectively.
//This if statement is equivalent to $_SESSION['user_role'] == 1
//To see how this session variable is accessible, check loginForm.php, line 62.
if (!$_SESSION['user_role']) {
    header("location:loginForm.php");
}
else
{?>

<?php
function displayMessage()
{
    $conn = connectToDatabase();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }
    $table = $_POST['table'];
    $id = $_POST['id'];
    $query = "DELETE FROM $table WHERE ".$_POST['id_column']." = $id";
    if (mysqli_query($conn, $query) == TRUE) {
        echo "<p>The ".$_POST['table']." with ID:".$id." has been deleted.</p>";
        echo "<form action='runAudit.php' method='post'>
                <input type='hidden' name='bowlingAudit' value='" . $_POST['table'] . "'>
                <input type='submit' value='Back to table'>
            </form>";
    } else {
        $error = "Unable to update.\n\nError: " . $conn->error;
        $error = json_encode($error);
        echo "
        <script type='text/javascript'>
            alert($error);
            history.go(-1);
        </script>";
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