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
    while ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['First_Name'];
        $lname = $row['Last_Name'];
        $playerID = $row['Player_ID'];
        if ($result->num_rows > 0)
        {
            echo 'You are trying to add the e-mail ' . $_POST['myinput'], ' to your team';
            echo "<br>Their player ID is: $playerID";
            echo "<br>Congratulations! $fname $lname is now part of your team!";

            if(!isset($row['Player_1']))
            {
                $sql = "UPDATE team SET Player_1 = $playerID where team.Team_ID = $teamID";
                echo "<script type='text/javascript'>
                alert('Player has been added to Player_1!');
                history.go(-1);
                document.location = 'manager.php';
                </script>";
            }
            elseif(!isset($row['Player_2']))
            {
                $sql = "UPDATE team SET Player_2 = $playerID where team.Team_ID = $teamID";
                echo "<script type='text/javascript'>
                alert('Player has been added to Player_2!');
                history.go(-1);
                document.location = 'manager.php';
                </script>";
            }
            elseif(!isset($row['Player_3']))
            {
                $sql = "UPDATE team SET Player_3 = $playerID where team.Team_ID = $teamID";
                echo "<script type='text/javascript'>
                alert('Player has been added to Player_3!');
                history.go(-1);
                document.location = 'manager.php';
                </script>";
            }
            elseif(!isset($row['Player_4']))
            {
                $sql = "UPDATE team SET Player_4 = $playerID where team.Team_ID = $teamID";
                echo "<script type='text/javascript'>
                alert('Player has been added to Player_4!');
                history.go(-1);
                document.location = 'manager.php';
                </script>";
            }
            elseif(!isset($row['Player_5']))
            {
                $sql = "UPDATE team SET Player_5 = $playerID where team.Team_ID = $teamID";
                echo "<script type='text/javascript'>
                alert('Player has been added to Player_5!');
                history.go(-1);
                document.location = 'manager.php';
                </script>";
            }
            else
            {
                echo 'Team is full, cannot add anymore players!';
            }
        }
        else
        {
            echo "Player is not in the database";
        }

    }
    if (attemptDataManipulationLanguageQuery($sql)) {
        echo '<br>Player Added';
    } else {
        echo 'Could not add player!';
    }

}
?>

