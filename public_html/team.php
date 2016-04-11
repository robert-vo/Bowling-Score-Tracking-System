<?php
function createPlayersArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT First_Name, Last_Name, Player_ID from Players";
    $result = $conn->query($sql);
    $teams = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teams[$row['Player_ID']] = $row['First_Name'] . ' ' . $row['Last_Name'];
        }
    } else {
        echo "0 results";
    }
    return $teams;
}
?>

<?php
function createPlayerEmailArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT Email, Player_ID from Players";
    $result = $conn->query($sql);
    $teams = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $teams[$row['Player_ID']] = $row['Email'];
        }
    } else {
        echo "0 results";
    }
    return $teams;
}
?>

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
    <br>Would you like to create a team today? <a href="createTeam.php">Click here to do so.</a>
    <div id="id"><br>Team Members:</div>

    </body>
    </html>

    <?php
    $user = $_SESSION['sess_user'];
    $query1 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query1);
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fname = $row['First_Name'];
            $lname = $row['Last_Name'];
        }
    }
    $fname = ucfirst($fname);
    $lname = ucfirst($lname);


    $query1 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query1);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $playerid = $row['Player_ID'];
        }
    }


    $query1 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR
Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 =
'$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query1);
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
            $teamID = $row['Team_ID'];

            $teams = createPlayersArray();
            $allEmails = createPlayerEmailArray();

            echo "<br> You are part of team: ". $teamname;
            if($teamMember1 and $teamMember1 != $playerid) {
                if($teamMember1 == $playerid) {
                    $yourPlayerID = 'Leader';
                }
                else {
                    echo "<br> Your team leader is: " . $teams[$teamMember1];
                    echo "<a href='mailto:".$allEmails[$teamMember1]."'> Email Team Member</a></br>";
                }
            }

            if($teamMember2) {
                if($teamMember2 == $playerid) {
                    $yourPlayerID = 'Player_1';
                }
                else {
                    echo "<br> Your team member is: " . $teams[$teamMember2];
                    echo "<a href='mailto:".$allEmails[$teamMember2]."'> Email Team Member</a></br>";

                }
            }

            if($teamMember3) {
                if($teamMember3 == $playerid) {
                    $yourPlayerID = 'Player_2';
                }
                else {
                    echo "<br> Your team member is: " . $teams[$teamMember3];
                    echo "<a href='mailto:".$allEmails[$teamMember3]."'> Email Team Member</a></br>";

                }
            }
            if($teamMember4) {
                if($teamMember4 == $playerid) {
                    $yourPlayerID = 'Player_3';
                }
                else {
                    echo "<br> Your team member is: " . $teams[$teamMember4];
                    echo "<a href='mailto:".$allEmails[$teamMember4]."'> Email Team Member</a></br>";

                }
            }
            if($teamMember5) {
                if($teamMember5 == $playerid) {
                    $yourPlayerID = 'Player_4';
                }
                else {
                    echo "<br> Your team member is: " . $teams[$teamMember5];
                    echo "<a href='mailto:".$allEmails[$teamMember5]."'> Email Team Member</a></br>";

                }
            }
            if($teamMember6) {
                if($teamMember6 == $playerid) {
                    $yourPlayerID = 'Player_5';
                }
                else {
                    echo "<br> Your team member is: " . $teams[$teamMember6];
                    echo "<a href='mailto:".$allEmails[$teamMember6]."'> Email Team Member</a></br>";

                }
            }
            echo "<br>";

            echo 'Would you like to leave the team, ' . $teamname . '? ';
            $preparedGetQuery = '?teamID=' . $teamID . '&player=' . $yourPlayerID;
            echo '<a href=leaveTeam.php' . $preparedGetQuery . '>';

            echo 'Click here</a><br>';
        }
    }

    //display stats

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
//    echo "$fname $lname";

    $query1 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query1);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $playerid = $row['Player_ID'];
        }
    }

    //Displays Team Leader

    $query2 = "SELECT * FROM team WHERE Leader = '$playerid'";
    $result = $conn->query($query2);
    $numrows = $result->num_rows;
    if($numrows != 0){

        while ($row = mysqli_fetch_assoc($result)){
            $teamname = $row['Name'];

        }

        $query3 = "SELECT * FROM team WHERE Name = '$teamname'";
        $result = $conn->query($query2);
        $numrows = $result->num_rows;
        if($numrows != 0){

            while ($row = mysqli_fetch_assoc($result)){
                $teamname = $row['Name'];
                $gamecount = $row['Game_Count'];
                $teamwin = $row['Win_Count'];
                if($gamecount == 0) {
                    $percentage = 0;
                }
                else {
                    $percentage =  ($teamwin / $gamecount) * 100;
                }
                echo "<br> Stats of Team: ". $teamname;
                echo "<br> The team you manage has played a total of: ". $gamecount, ' games';
                echo "<br> The team you manage has a total win of: ". $teamwin;
                echo "<br> The team you manage has a win percentage of: ". $percentage, '%', "<br>";

            }
        }
    }
    else{
        echo "<br>Not a team leader, no access is given to team stats";
    }






}



?>
