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

    echo 'got id' . $_POST['teamID'];
//    include 'sendEmail.php';
//    echo "<br> You have succesfully requested to join the team!";
//    echo "<br> The team leader has received your request and will get back to you soon!";
//    sendEmailTo("wnguyen23@yahoo.com","William","Nguyen");

?>














