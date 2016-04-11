<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">


<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';


if(!isset($_POST['name']) or $_POST['name'] == null) {
    echo "Empty Team Name. Please go back and try again.<form action='createTeam.php'><input type='submit' value='Go back'></form><br>";
}
else {
    if($_POST['numberOfPlayers'] == 0) {
        $conn = connectToDatabase();
        $playerID = $_SESSION['player_id'];
        $nameTeam = $_POST['name'];
        $sql = "insert into Team(Leader, Name) VALUES ('$playerID', '$nameTeam')";
        if(mysqli_query($conn, $sql) == TRUE) {
        echo '<br>Created a team with you as the team leader and the only player.';
            echo '<br>Why won\'t you <a href="games.php">start</a> a game today?';
        }
        else {
            echo 'Unable to create a team for you. ';
            echo "Please go back and try again.<form action='createTeam.php'><input type='submit' value='Go back'></form><br>";

        }
    }
    else {
        echo 'Please enter in the email addresses for each player you want to create a team for.<br>';

        echo '<form action="runCreateTeam.php" method="post">';
        for($i = 1; $i <= $_POST['numberOfPlayers']; $i++) {
            echo "<input type=text name=name$i placeholder=" . "Player$i" . "><br>";
        }
        $num = $_POST['numberOfPlayers'];
        echo "<input type=hidden value=$num name = number>";
        $name = $_POST['name'];
        echo "<input type=hidden value=$name name = name>";
        echo '<input type="submit" value="Submit" name="submit"><form>';
    }
}
