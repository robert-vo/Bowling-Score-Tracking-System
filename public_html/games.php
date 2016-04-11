<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();

include 'menuBar.php';

generateMenuBar(basename(__FILE__));


//Reuse for frame stuff
//echo '<form action="">
//<input type="checkbox" name="vehicle" value="Bike">Pin 1<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 2<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 3<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 4<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 5<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 6<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 7<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 8<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 9<br>
//<input type="checkbox" name="vehicle" value="Car">Pin 10<br>
//</form>';
//getFramesForLoggedInPlayer();
//function getFramesForLoggedInPlayer() {
//    $result = getAllTeamsForAPlayerID($_SESSION['player_id']);
//    printResult($result);
//}


include 'databaseFunctions.php';


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
            echo '</caption>';
            echo '<tr><th>Team Name</th><th>Total Score</th><th>Winner</th></tr>';
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

                //TODO somehow calculate score :(
                echo '<th>123</th>';

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



//echo $pieces[0]; // piece1
//echo $pieces[1]; // piece2

//$mystring = '1,2,3,4,5';
//$findme   = 'as';
//$pos = strpos($mystring, $findme);
//
//// Note our use of ===.  Simply == would not work as expected
//// because the position of 'a' was the 0th (first) character.
//if ($pos === false) {
//    echo "The string '$findme' was not found in the string '$mystring'";
//} else {
//    echo "The string '$findme' was found in the string '$mystring'";
//    echo " and exists at position $pos";
//}






?>



