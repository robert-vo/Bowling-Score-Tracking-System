<link rel="stylesheet" type="text/css" href="audit.css">
<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

function isCurrentPlayerATeamLeader($player_id) {
    $query = "select leader, count(Leader) as count from Team where Leader = $player_id group by Leader";
    $conn = connectToDatabase();
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['count'] == 0) {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

function printAllOfYourTeams($player_id)
{
    $query = "select Team_ID, Name from Team where Team.Leader = $player_id";
    $conn = connectToDatabase();
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value=' . $row['Team_ID']. '>' . $row['Name'] . '</option>';
        }
    }
}

function printAllOptionsForTeamsNotIncludingYours($player_id)
{
    $query = "select Team_ID, Name from Team where Team.Leader <> $player_id";
    $conn = connectToDatabase();
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value=' . $row['Team_ID']. '>' . $row['Name'] . '</option>';
        }
    }
}

function printAllLocations()
{
    $query = "select * from Game_Location";
    $conn = connectToDatabase();
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value=' . $row['Game_Location_ID']. '>' . $row['Game_Location_Name'] . ' located at ' . $row['Game_Address'] . '</option>';
        }

    }

}

function printAllEventTypes()
{
    $query = "select distinct Event_Type from Game";
    $conn = connectToDatabase();
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<option value=' . $row['Event_Type']. '>' . $row['Event_Type'] . '</option>';
        }
    }
}


if(isCurrentPlayerATeamLeader($_SESSION['player_id'])) {
    
    echo '<form action = "runCreateGame.php" method="post">';
    echo '<p>
    Which one of your teams do you want to select?
    <select name="yourTeam">';

    echo printAllOfYourTeams($_SESSION['player_id']);

    echo '</select></p>';

    echo '<label for=\'formTeams[]\'>Select the teams that you want to play against. Click and hold the control button to select more than one team to play against.</label><br>If no teams are selected, this game will involve only your selected team.<br>';

    echo '<select multiple="multiple" name="formTeams[]" size=30>';

    echo printAllOptionsForTeamsNotIncludingYours($_SESSION['player_id']);

    echo '</select>';


    echo '<p>At which location?<select name="location">';

    echo printAllLocations();

    echo '</select></p>';

    //Form for Adding A New Location


    echo 'Location not there?';
    echo '<br><a href="createLocation.php">Click here to add a new location!</a></br>';

    echo 'Game Title? If this is left empty, the game will be titled \'Generic Game\':  <input type="text" name="game_title" /><br />';

    echo '<p>Event Type?<select name="eventType">';

    echo printAllEventTypes();
    
    echo '<br><input type="submit" value="Create Game"></form>';

}
else {
    echo '<br>You are not a team leader! To create a game, you need to be currently leading a team. Please visit the Team tab for more information.';
}