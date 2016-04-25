<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';
include '../src/game.php';

function printResult($result) {
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<br>" . $row['Team_ID'] . "<br>" . $row['Name'];
    }
    } else {
        echo "0 results";
    }
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

function getLocationForId($location_id) {
    $conn = connectToDatabase();
    $sql = "select Game_Location_Name from Game_Location where Game_Location_ID = '$location_id'";
    $result = $conn->query($sql);

    $location = '';
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $location = $row['Game_Location_Name'];
        }
    } else {
        $location = "N/A";
    }
    return $location;
}

function printGames($result, $teamID) {
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            echo '<table>';
            echo '<caption>';
            echo 'Game Title: ' . $row['Title'] . '<br>Type of game: ' . $row['Event_Type'];
            echo '<br>Game Location: ' . getLocationForId($row['Location_ID']);
            echo "<br>The game occurred on: " . date("D, M d, Y @h:ia", (strtotime($row['Game_Start_Time'])));
            echo '<br><a href=viewGame.php?gameID=' . $row['Game_ID'];
            echo '>View the game here!</a>';
            echo '</caption>';
            echo '<tr><th>Team Name</th><th>Average Score Per Player</th><th>Winner</th></tr>';
            $allTeams = $row['Teams'];
            $separatedTeams = explode(",", $allTeams);

            foreach ($separatedTeams as $team) {
                echo '<tr><th>';
                if($teamID == $team) {
                    echo '<u>' . getTeamNameForTeamId($team) . '</u>';
                }
                else {
                    echo getTeamNameForTeamId($team);
                }
                echo '</th>';

                echo '<th>' . calculateAverageScoreFor($row['Game_ID'], $team) . '</th>';

                echo '<th>';

                if($row['Winner_Team_ID'] == $team) {
                    echo '🔥✓🔥';
                }
                else {
                    echo '✖';
                }

                echo '</th>';

                echo '</tr>';
            }
            echo '</table>';
            echo "<br>";
            echo "<br>";
            echo "<br>";
        }
    } else {

    }
}

function calculateAverageScoreFor($gameID, $teamID) {
    $sql = "SELECT group_concat(DISTINCT player_id) as 'ids' from Frame where Team_ID = $teamID and Game_ID = $gameID";
    $conn = connectToDatabase();
    $result = $conn->query($sql);

    $totalScore = 0;

    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allPlayers = explode(',', $row['ids']);
            foreach ($allPlayers as $player) {
                $game = new \bowling\game();
                $getAllFrames = "SELECT Frame_Number, Roll_One_ID, Roll_Two_ID, Roll_Three_ID From Frame where Team_ID = $teamID and Game_ID = $gameID and Frame.Player_ID = $player";
                $resultOfPlayers = $conn->query($getAllFrames);

                if($resultOfPlayers) {
                    while ($rowOfPlayers = $resultOfPlayers->fetch_assoc()) {

                        if ($rowOfPlayers['Frame_Number'] == 10) {
                            if (isset($rowOfPlayers['Roll_Three_ID'])) {
                                $game->frame(getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_One_ID']), getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_Two_ID']), getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_Three_ID']));
                            } else if (isset($rowOfPlayers['Roll_Two_ID'])) {
                                $game->frame(getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_One_ID']), getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_Two_ID']));
                            } else {
                                $game->frame(getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_One_ID']));
                            }
                        } else {
                            if (isset($rowOfPlayers['Roll_Two_ID'])) {
                                $game->frame(getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_One_ID']), getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_Two_ID']));
                            } else {
                                $game->frame(getIntegerNumberOfPinsHitForRollID($rowOfPlayers['Roll_One_ID']));
                            }
                        }
                    }
                    $totalScore += $game->score();
                }

            }
        }
    }
    else {
        return 0;
    }
    return round($totalScore/count($allPlayers), 3);
}

function findAllTeamsAPlayerIsAPartOf($playerID, $gameStatus) {
    $findAllTeamsQuery = "select TEAM_ID from Team where Leader = $playerID or Player_1 = $playerID or Player_2 = $playerID or Player_3 = $playerID or Player_4 = $playerID or Player_5 = $playerID";
    $conn = connectToDatabase();
    $result = $conn->query($findAllTeamsQuery);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            findAllGamesATeamIsAPartOf($row['TEAM_ID'], $gameStatus);
        }
    } else {
        echo "Not a part of a team! Join a team today!";
    }
}

function findAllGamesATeamIsAPartOf($teamID, $gameStatus) {
    $query = "select * from game where 
                game.Game_Finished = $gameStatus and (
                  game.Teams like '$teamID,%'
                    or game.Teams like '%,$teamID'
                    or game.Teams like '%,$teamID,%')";

    $conn = connectToDatabase();
    $result = $conn->query($query);
    printGames($result, $teamID);
}

echo '<a href="createGame.php">Click here to start a new game!</a></b>';
echo '<h3>Here are the incompleted games that you are participating in!</h3>';
findAllTeamsAPlayerIsAPartOf($_SESSION['player_id'], 0);
echo '<h3>Here are the completed games that you participated in!</h3>';
findAllTeamsAPlayerIsAPartOf($_SESSION['player_id'], 1);

?>



