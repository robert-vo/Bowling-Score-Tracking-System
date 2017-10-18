<?php
include 'databaseFunctions.php';
function createTeamLeaderArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT Player_ID, Email from Players";
    $result = $conn->query($sql);
    $teamLeader = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teamLeader[$row['Player_ID']] = $row['Email'];
        }
    } else {
        echo "0 results";
    }
    return $teamLeader;

}
?>


<?php
function nameArray()
{
    $conn = connectToDatabase();
    $sql = "SELECT Player_ID, First_Name, Last_Name from Players";
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
function popupMessageAndRedirectBrowser($message) {
    echo "<script type='text/javascript'>alert('$message');history.go(-1);document.location = 'joinTeam.php';</script>";
}
    $Players = createPlayerEmailArray();
    $name = nameArray();

//    echo 'got id' . $_POST['teamID'];
//    echo '<br> emailing...' . $players[$_POST['teamID']];
    include 'sendEmail.php';
//    echo "<br> You have succesfully requested to join the team!";
    $message = "The team leader has received your request and will get back to you soon!";
    sendEmailTo($players[$_POST['teamID']],$name[$_SESSION['player_id']], $players[$_SESSION['player_id']], $_POST['teamName']);
    popupMessageAndRedirectBrowser($message);



?>














