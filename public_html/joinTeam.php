<?php
function createTeamLeaderArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT First_Name, Last_Name, Player_ID from Players";
    $result = $conn->query($sql);
    $teamLeader = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teamLeader[$row['Player_ID']] = $row['First_Name'] . ' ' . $row['Last_Name'];
        }
    } else {
        echo "0 results";
    }
    return $teamLeader;
}
?>

<?php
function createPlayerEmailArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT Email, Player_ID from Players";
    $result = $conn->query($sql);
    $emails = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $emails[$row['Player_ID']] = $row['Email'];
        }
    } else {
        echo "0 results";
    }
    return $emails;
}
?>



<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';
$conn = connectToDatabase();

$user = $_SESSION['sess_user'];
$query1 = "SELECT * FROM players WHERE Email = '$user'";
$result = $conn->query($query1);
$numrows = $result->num_rows;
if ($numrows != 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $playerID = $row['Player_ID'];
//        echo "$playerID";
////This will display the logged in users Player ID
    }
}



$query2 = "SELECT Name,Leader from team";
$result = $conn->query($query2);
$numrows = $result->num_rows;

echo "<br> Here is a list of all the teams you can join: <br>";
if($numrows != 0){
    while ($row = mysqli_fetch_assoc($result)) {
        $teamName = $row['Name'];
        $leaderID = $row['Leader'];
        $teamLeader = createTeamLeaderArray();
        $allEmails = createPlayerEmailArray();
        if ($playerID == $leaderID) {
            //Player logged in is the leader of the team, so can't email themselves
            //The team will not be displayed on the list
        }
        else {
            echo "<br> $teamName and the team leader is $teamLeader[$leaderID]";
            echo "<br> Got a question? Send the team leader a question here! =>";
            echo "<a href='mailto:" . $allEmails[$leaderID] . "'> Email Team Leader</a></br>";
            echo "<form action=sendEmailToTeamLeader.php method='post'>";
            echo "<input type =hidden value=$leaderID name=teamID>";
            echo "<input type = hidden value='$teamName' name = teamName>";
            echo '<input type="submit" value = "Request to Join Team" onclick="return confirm(\'Are you sure you want to join the team?\');"></input>';
            echo '</form>';
            //place button that calls a function

        }

    }
}
?>










