<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:loginForm.php");

} else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <title> Registration</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
        <style>

        </style>
    </head>
    <body>
    <?php
    include 'menuBar.php';
    generateMenuBar(basename(__FILE__));
    include 'databaseFunctions.php';

    $user = $_SESSION['sess_user'];
if (isset($_POST['create'])) {
    $teamname = $_POST['name'];
    $conn = connectToDatabase();
    if ($teamname != NULL) {

        $query = "SELECT * FROM players WHERE Email = '$user'";
        $result = $conn->query($query);
        $numrows = $result->num_rows;
        if($numrows != 0){
            while ($row = mysqli_fetch_assoc($result)){
                $playerid = $row['Player_ID'];
            }
        }
        echo $playerid;
        echo $user;
        $sql ="INSERT INTO team "

    } else {
        echo "Please enter a team name. Click <a href=\"createTeam.php\">here</a> to try again";
    }
} else {
    ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Team Name">
        <input type="submit" value="Create" name="create">
    </form>
    <?php
}
?>
    </body>
    </html>
    <?php
}
?>