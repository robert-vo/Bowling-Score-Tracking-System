<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

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

function getTeamNameForTeamId($teamId) {
    $conn = connectToDatabase();
    $sql = "select Team_ID, Team.Name from Team where Team.Team_ID = '$teamId'";

    $result = $conn->query($sql);

    $teamName = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teamName = $row["Name"];
        }
    } else {
        $teamName = "0 results";
    }
    return $teamName;
}

function getInformationAboutGame($gameID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM GAME, Game_Location WHERE Game.Game_ID = $gameID and Game.Location_ID = Game_Location.Game_Location_ID";
    
    $result = $conn->query($sql);

    printInformationAboutTheGame($result);
}


function getAllInformationFromAPlayer($playerID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Players where Players.Player_ID = $playerID";
    $result = $conn->query($sql);
    return $result;
}

function printFrameInformationForPlayer($playerID, $teamID, $gameID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM Frame where Frame.Player_ID = $playerID and Frame.Team_ID = $teamID and Frame.Game_ID = $gameID";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $totalScore = 0;
        while($row = $result->fetch_assoc()) {
            $totalScore += $row["Score"];
            $preparedURL = 'viewFrame.php?frameID=' . $row["Frame_ID"];
            echo '<th><a href=' . $preparedURL . '>' . $row["Score"] . '</a></th>';
        }
        echo '<th>' . $totalScore . '</th>';

    }

}
function printGameInfoForEachPlayer($teamID) {
    $conn = connectToDatabase();
    $sql = "SELECT Leader, Player_1, Player_2, Player_3, Player_4, Player_5 FROM Team where Team.Team_ID = $teamID";
    $result = $conn->query($sql);
    $allPlayers = createPlayersArray();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Leader:' . $allPlayers[$row["Leader"]] . '</th>';
            printFrameInformationForPlayer($row["Leader"], $teamID, $_GET['gameID']);
            if(isset($row['Player_1'])) {
                echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Player 1:' . $allPlayers[$row["Player_1"]] . '</th>';
                printFrameInformationForPlayer($row['Player_1'], $teamID, $_GET['gameID']);
            }
            if(isset($row['Player_2'])) {
                echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Player 2:' . $allPlayers[$row["Player_2"]] . '</th>';
                printFrameInformationForPlayer($row['Player_2'], $teamID, $_GET['gameID']);
            }
            if(isset($row['Player_3'])) {
                echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Player 3:' . $allPlayers[$row["Player_3"]] . '</th>';
                printFrameInformationForPlayer($row['Player_3'], $teamID, $_GET['gameID']);
            }
            if(isset($row['Player_4'])) {
                echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Player 4:' . $allPlayers[$row["Player_4"]] . '</th>';
                printFrameInformationForPlayer($row['Player_4'], $teamID, $_GET['gameID']);
            }
            if(isset($row['Player_5'])) {
                echo '<tr><th>' . getTeamNameForTeamId($teamID) . '<br>Player 5:' . $allPlayers[$row["Player_5"]] . '</th>';
                printFrameInformationForPlayer($row['Player_5'], $teamID, $_GET['gameID']);
            }
            echo '</tr>';
            echo '<tr><th></th></tr>';
        }
    } else {
        die("ERROR");
    }
}
function printInformationAboutTheGame($result) {
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            echo '<table>';
            echo '<caption>For current game</caption>';
            echo '<tr><th>Team Name</th>';
            echo '<th>Frame 1</th>';
            echo '<th>Frame 2</th>';
            echo '<th>Frame 3</th>';
            echo '<th>Frame 4</th>';
            echo '<th>Frame 5</th>';
            echo '<th>Frame 6</th>';
            echo '<th>Frame 7</th>';
            echo '<th>Frame 8</th>';
            echo '<th>Frame 9</th>';
            echo '<th>Frame 10</th>';
            echo '<th>Total Score</th>';

            echo '</tr>';
            $allTeams = $row['Teams'];
            $separatedTeams = explode(",", $allTeams);
            foreach ($separatedTeams as $team) {
                echo '<tr>';
                if($_GET['gameID'] == $team) {
                    //echo '<u>' . getTeamNameForTeamId($team) . '</u>';
                }
                else {
                    //echo getTeamNameForTeamId($team);
                }
                printGameInfoForEachPlayer($team);

                echo '</tr>';
            }
        }

        echo '</table>';
    }
}

getInformationAboutGame($_GET['gameID']);