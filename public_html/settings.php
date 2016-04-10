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
    echo "$fname $lname";

    $query2 = "SELECT * FROM players WHERE Email = '$user'";
    $result = $conn->query($query2);
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
    }

    $query3 = "SELECT * FROM team WHERE Name = '$teamname'";
    $result = $conn->query($query2);
    $numrows = $result->num_rows;
    if($numrows != 0){

        while ($row = mysqli_fetch_assoc($result)){
            $teamname = $row['Name'];
            $gamecount = $row['Game_Count'];
            $teamwin = $row['Win_Count'];
            $percentage =  ($teamwin / $gamecount) * 100;
            echo "<br> You are the team leader of: ". $teamname;
            echo "<br> The team you manage has played a total of: ". $gamecount, ' games';
            echo "<br> The team you manage has a total win of: ". $teamwin;
            echo "<br> The team you manage has a win percentage of: ". $percentage, '%', "<br>";

        }
    }

    //write statement for players who are not team leaders, currently displays error







    ?>

    </body>
    </html>

    <?php
}
?>