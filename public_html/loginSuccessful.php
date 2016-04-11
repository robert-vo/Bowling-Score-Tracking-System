<?php
session_start();
if (!isset($_SESSION["sess_user"])) {

    header("location:loginForm.php");

} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Title</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <style>
            div#id {
                font-size: x-large;
                font-weight: bold;
                color: #4CAF50;
            }
        </style>
    </head>
    <body>
    <?php include 'menuBar.php';
    generateMenuBar(basename(__FILE__));
    ?>

    <div id="id">PROFILE:</div>
    <?php
    $user = $_SESSION['sess_user'];
    include 'databaseFunctions.php';
    $conn = connectToDatabase();
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
    echo "You are currently logged in as: $fname $lname";
    echo '<br><br><u>Here is the information you have on file with us:</u>';
    $query2 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query2);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $playerid = $row['Player_ID'];
            echo '<br>Gender: ' . $row['Gender'];
            echo '<br>Date Of Birth: ' . $row['Date_Of_Birth'];
            echo '<br>Street Address: ' . $row['Street_Address'];
            echo '<br>City: ' . $row['City'];
            echo '<br>State: ' . $row['State'];
            echo '<br>Zip Code: ' . $row['Zip_Code'];
            echo '<br>Email: ' . $row['Email'];
        }
    }

    //Displays Team Leader
    $query2 = "SELECT * FROM team WHERE Leader = '$playerid'";
    $result = $conn->query($query2);
    $numrows = $result->num_rows;
    if($numrows != 0){

        while ($row = mysqli_fetch_assoc($result)){
            $teamname = $row['Name'];
            echo "<br> You are the team leader of: ". $teamname;
            echo "\n";
        }
    }

    //Listing Player ID

    $query3 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 = '$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query3);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $teamname = $row['Name'];
        }
        echo "<br> Your Player ID is: ". $playerid;

    }

    //List all teams you are part of

    $query4 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 = '$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query4);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $partOfTeam = $row['Name'];
            echo "<br> Your are part of team: ". $partOfTeam;
        }

    }

    //Display Team Members ID


    $query4 = "SELECT * FROM team WHERE Player_1 = '$playerid' OR Player_2 = '$playerid' OR Player_3 = '$playerid' OR Player_4 = '$playerid' OR Player_5 = '$playerid'";
    $result = $conn->query($query4);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row = mysqli_fetch_assoc($result)){
            $teamMember1 = $row['Leader'];
            $teamMember2 = $row['Player_1'];
            $teamMember3 = $row['Player_2'];
            $teamMember4 = $row['Player_3'];
            $teamMember5 = $row['Player_4'];
            $teamMember6 = $row['Player_5'];
        }
        ;
//        echo "<br> Your team members id  are: ". $teamMember1;
//        echo "<br> Your team members id are: ". $teamMember2;
//        echo "<br> Your team members id are: ". $teamMember3;
//        echo "<br> Your team members id are: ". $teamMember4;
//        echo "<br> Your team members id are: ". $teamMember5;
//        echo "<br> Your team members id are: ". $teamMember6;

    }

    //Displays Team Member Name

//    $query5 = "SELECT * FROM players WHERE Player_ID = '$teamMember1' OR Player_ID = '$teamMember2' OR Player_ID = '$teamMember3' OR Player_ID = '$teamMember4' OR Player_ID = '$teamMember5' OR Player_ID = '$teamMember6'";
//    $result = $conn->query($query5);
//    $numrows = $result->num_rows;
//    if ($numrows != 0) {
//        while ($row = mysqli_fetch_assoc($result)) {
//            $memberName = $row['First_Name'];
//            $memberLastName = $row['Last_Name'];
//            echo "<br> Your team member is: ". $memberName, $memberLastName;
//        }
//
//    }





    ?>

    </body>
    </html>

    <?php
}
?>