<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">


<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';


function createEmailToPlayerIDList() {
    $conn = connectToDatabase();
    $sql = "SELECT Player_ID, Email from Players";

    $result = $conn->query($sql);

    $emailToID = array();

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $emailToID[$row['Email']] = $row['Player_ID'];
        }
    }

    return $emailToID;
}

function allPlayersEmailsAreValid(...$Players) {
    $isValid = true;
    $emailToID = createEmailToPlayerIDList();
    foreach ($Players as $player) {
        if(isset($emailToID[$player])) {
            $isValid = true;
        }
        else {
            $isValid = false;
        }
    }
    return $isValid;
}

function constructPlayers($numberOfPlayers) {
    $sql = "INSERT INTO TEAM(Leader, Name,";
    $teamName = $_POST['name'];
    $emailToID = createEmailToPlayerIDList();

    if(isset($_POST['name1'])) {
        $name1 = $emailToID[$_POST['name1']];
    }
    if(isset($_POST['name2'])) {
        $name2 = $emailToID[$_POST['name2']];
    }
    if(isset($_POST['name3'])) {
        $name3 = $emailToID[$_POST['name3']];
    }
    if(isset($_POST['name4'])) {
        $name4 = $emailToID[$_POST['name4']];
    }
    if(isset($_POST['name5'])) {
        $name5 = $emailToID[$_POST['name5']];
    }
    $leaderID = $_SESSION['player_id'];
    switch($numberOfPlayers) {
        case 1:
            $sql = $sql . "Player_1) Values($leaderID, '$teamName', $name1)";
            break;
        case 2:
            $sql = $sql . "Player_1, Player_2) Values($leaderID, '$teamName', $name1, $name2)";
            break;
        case 3:
            $sql = $sql . "Player_1, Player_2, Player_3) Values($leaderID, '$teamName', $name1, $name2, $name3)";
            break;
        case 4:
            $sql = $sql . "Player_1, Player_2, Player_3, Player_4) Values($leaderID, '$teamName', $name1, $name2, $name3, $name4)";
            break;
        case 5:
            $sql = $sql . "Player_1, Player_2, Player_3, Player_4, Player_5) Values($leaderID, '$teamName', $name1, $name2, $name3, $name4, $name5)";
            break;
        default:
            return '';
            break;
    }
    echo $sql;
    return $sql;
}
$triggered = true;
for($i = 1; $i <= $_POST['number']; $i++) {
    $postBuilder = 'name' . $i;
    if(allPlayersEmailsAreValid($_POST[$postBuilder])) {
        echo 'The email for player ' . $i . ', ' . $_POST[$postBuilder] . ', is a valid, existing email.<br>';
    }
    else {
        echo 'The email for player ' . $i . ', ' . $_POST[$postBuilder] . ', is NOT a valid, existing email.<br>';
        $triggered = false;
    }
}
if($triggered == TRUE) {
    echo '<br>All of the emails entered are valid!';

    $conn = connectToDatabase();
    $query = constructPlayers($_POST['number']);

    if(mysqli_query($conn, $query) == TRUE) {
        echo '<br>Created a team of size ' . $_POST['number'] . ' with you as the team leader with the name ' . $_POST['name'] . '.';
        echo "<br>Start playing a game today!<form action='team.php'><input type='submit' value='Go back'></form><br>";

    }
    else {
        echo $conn->error;
    }

}
else {
    echo "One or more of the email addresses you have entered are not valid.";
    echo "<br>Please go back and try again.<form action='createTeam.php'><input type='submit' value='Go back'></form><br>";
}