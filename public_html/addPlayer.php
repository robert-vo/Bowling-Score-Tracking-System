<?php
session_start();
if (!isset($_SESSION["sess_user"]))
{
    header("location:loginForm.php");
}
else {
?>
    <!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Team Members </title>

    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css"
          href="loginAndRegistrationForm.css">
    <link rel="stylesheet" type="text/css" href="team.css">

    <style>
        div#error {
            color: red;
        }
    </style>
</head>

<body>
<?php
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';
$conn = connectToDatabase();

function emailPlayer($playerID) {
    echo 'Emailing....' . $playerID;
}

function popupMessageAndRedirectBrowser($message) {
    echo "<script type='text/javascript'>alert('$message');history.go(-1);document.location = 'manager.php';</script>";
}
}
?>
</body>
</html>

<?php

//do a sql query that will attempt to see if the email exists
//if the sql query returns 0 rows, tell the user unable to find....
//if the sql query returns >0 rows, attempt to add user
//make sure user is not part of the team already
//add user to last available spot
//checks if the value is null or not

$inputEmail = $_POST['myinput'];
$teamID = $_POST['team'];
$query ="SELECT Player_ID, First_Name, Last_Name, Email from players where Email = '$inputEmail'";
$result = $conn->query($query);

$numrows = $result->num_rows;
if ($numrows != 0)
{
    $isFull = false;
    while ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['First_Name'];
        $lname = $row['Last_Name'];
        $playerID = $row['Player_ID'];
        if ($result->num_rows > 0)
        {

            $query2 = "SELECT Leader,Player_1, Player_2, Player_3, Player_4, Player_5 from Team where Team_ID = $teamID";
            $result2 = $conn->query($query2);
            $numrows = $result2->num_rows;
            $message = '';
            while ($row2 = $result2->fetch_assoc()) {
                if($row2['Leader'] == $playerID or $row2['Player_1'] == $playerID or $row2['Player_2'] == $playerID or $row2['Player_3'] == $playerID or $row2['Player_4'] == $playerID or $row2['Player_5'] == $playerID ) {
                    echo '<br> The email you entered is already on this team!<br>';
                }
                else{

                    if (!isset($row2['Player_1'])) {
                        echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
                        echo "<br>Their player ID is: $playerID";
                        echo "<br>Congratulations! $fname $lname is now part of your team!";
                        echo '<br>Player has been set as #1';
                        $message = 'Player has been added to 1st player slot! Remember that there is a maximum of 5 other players on a team!';
                        $sql = "UPDATE team SET Player_1 = $playerID where team.Team_ID = $teamID";
                    } elseif (!isset($row2['Player_2'])) {
                        echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
                        echo "<br>Their player ID is: $playerID";
                        echo "<br>Congratulations! $fname $lname is now part of your team!";
                        echo '<br>Player has been set as #2';
                        $sql = "UPDATE team SET Player_2 = $playerID where team.Team_ID = $teamID";
                        $message = 'Player has been added to 2nd player slot! Remember that there is a maximum of 5 other players on a team!';
                    } elseif (!isset($row2['Player_3'])) {
                        echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
                        echo "<br>Their player ID is: $playerID";
                        echo "<br>Congratulations! $fname $lname is now part of your team!";
                        echo '<br>Player has been set as #3';
                        $sql = "UPDATE team SET Player_3 = $playerID where team.Team_ID = $teamID";
                        $message = 'Player has been added to 3rd player slot! Remember that there is a maximum of 5 other players on a team!';
                    } elseif (!isset($row2['Player_4'])) {
                        echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
                        echo "<br>Their player ID is: $playerID";
                        echo "<br>Congratulations! $fname $lname is now part of your team!";
                        echo '<br>Player has been set as #4';
                        $sql = "UPDATE team SET Player_4 = $playerID where team.Team_ID = $teamID";
                        $message = 'Player has been added to 4th player slot! You can only add one more person to your team!';
                    } elseif (!isset($row2['Player_5'])) {
                        echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
                        echo "<br>Their player ID is: $playerID";
                        echo "<br>Congratulations! $fname $lname is now part of your team!";
                        echo '<br>Player has been set as #5';
                        $sql = "UPDATE team SET Player_5 = $playerID where team.Team_ID = $teamID";
                        $message = 'Player has been added to 5th player slot! You are currently maxed out on other team members!';
                    } else {
                        $message = 'Your team is full, therefore you are unable to add any more players. Please remove some members off of your team if you want room to add other players.';
                        $isFull = true;
                    }
                }
            }
        }
    }
    if (!$isFull and attemptDataManipulationLanguageQuery($sql)) {
        emailPlayer($playerID);
        echo '<br>Player Added';
    } else {
        $message = 'Unable to add the player! It seems that the player already exists on the team!';
    }
    popupMessageAndRedirectBrowser($message);

}
else
{
    popupMessageAndRedirectBrowser('Player does not exist! Please ensure that what you have entered is correct and valid.   ');
}
?>
