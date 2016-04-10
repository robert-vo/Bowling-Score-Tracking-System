<?php
session_start();
if (!isset($_SESSION["sess_user"]))
{
    header("location:loginForm.php");
}
else
{
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
    ?>
    <div id="id">Team Members:</div>

    </body>
    </html>

    <?php
    $user = $_SESSION['sess_user'];
    $query = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query);
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fname = $row['First_Name'];
            $lname = $row['Last_Name'];
        }
    }
    $fname = ucfirst($fname);
    $lname = ucfirst($lname);

    $query2 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query2);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $playerid = $row['Player_ID'];
        }
    }

    $query3 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR
Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 =
'$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query3);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $teamname = $row['Name'];
//            echo "<br> TEAM: ". $teamname;
        }

    }

    $query4 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR
Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 =
'$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query3);
    $numrows = $result->num_rows;
    if($numrows != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teamname = $row['Name'];
            $teamMember1 = $row['Leader'];
            $teamMember2 = $row['Player_1'];
            $teamMember3 = $row['Player_2'];
            $teamMember4 = $row['Player_3'];
            $teamMember5 = $row['Player_4'];
            $teamMember6 = $row['Player_5'];

        }
    }

    $query5 = "SELECT * FROM players WHERE Player_ID = '$teamMember1'
OR Player_ID = '$teamMember2' OR Player_ID = '$teamMember3' OR
Player_ID = '$teamMember4' OR Player_ID = '$teamMember5' OR Player_ID
= '$teamMember6'";
    $result = $conn->query($query4);
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $teamname = $row['Name'];
            $teamMember1 = $row['Leader'];
            $teamMember2 = $row['Player_1'];
            $teamMember3 = $row['Player_2'];
            $teamMember4 = $row['Player_3'];
            $teamMember5 = $row['Player_4'];
            $teamMember6 = $row['Player_5'];

            echo "<br> You are part of team: ". $teamname;
            if($teamMember1 and $teamMember1 != $playerid) {
                echo "<br> Your team member is: " . $teamMember1;
            }
            if($teamMember2 and $teamMember2 != $playerid) {
                echo "<br> Your team member is: " . $teamMember2;
            }
            if($teamMember3 and $teamMember3 != $playerid) {
                echo "<br> Your team member is: " . $teamMember3;
            }
            if($teamMember4 and $teamMember4 != $playerid) {
                echo "<br> Your team member is: " . $teamMember4;
            }
            if($teamMember5 and $teamMember5 != $playerid) {
                echo "<br> Your team member is: " . $teamMember5;
            }
            if($teamMember6 and $teamMember6 != $playerid) {
                echo "<br> Your team member is: " . $teamMember6;
            }
        }



    }



}

?>
