<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

function printColumnLegend() {
    echo '<tr>';
    echo '<th colspan=12>Team and Player Name</th>';
    foreach (range(1, 10) as $item) {
        echo "<th colspan=6>Frame $item</th>";
    }
    echo "<th colspan=6>Score</th>";
    echo '</tr>';
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

function getPlayerNameForPlayerId($playerId)
{
    $conn = connectToDatabase();
    $sql = "SELECT First_Name, Last_Name, Player_ID from Players where Player_ID = $playerId";
    $result = $conn->query($sql);

    $playerName = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $playerName = $row['First_Name'] . ' ' . $row['Last_Name'];
        }
    } else {
        echo "0 results";
    }
    return $playerName;
}


function printRollsInformation($playerID, $gameID, $teamID) {
    $sql = "select Frame_Number, Roll_One_ID, Roll_Two_ID, Roll_Three_ID 
            from frame 
            where Game_ID = $gameID 
              and Team_ID = $teamID 
              and Player_ID = $playerID";

    $conn = connectToDatabase();

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['Frame_Number'] != 10) {
                $preparedURL = 'editRoll.php?rollID='.$row["Roll_One_ID"];
                echo "<td colspan='3'>
                    <a href='$preparedURL'>" . getNumberOfPinsHitForRollID($row['Roll_One_ID']) . "</a></td>";

                if(isset($row['Roll_Two_ID'])) {
                    $preparedURL = 'editRoll.php?rollID='.$row["Roll_Two_ID"];
                    echo "<td colspan='3'>
                        <a href='$preparedURL'>" . getNumberOfPinsHitForRollID($row['Roll_Two_ID']) . "</a></td>";
                }
                else {
                    echo "<td colspan=3>&nbsp;</td>";
                }
            }
            else {
                $preparedURL = 'editRoll.php?rollID='.$row["Roll_One_ID"];
                echo "<td colspan='2'>
                    <a href='$preparedURL'>" . getNumberOfPinsHitForRollID($row['Roll_One_ID']) . "</a></td>";
                if(isset($row['Roll_Two_ID'])) {
                    $preparedURL = 'editRoll.php?rollID='.$row["Roll_Two_ID"];
                    echo "<td colspan='2'>
                        <a href='$preparedURL'>" . getNumberOfPinsHitForRollID($row['Roll_Two_ID']) . "</a></td>";
                }
                else {
                    echo "<td colspan=2>&nbsp;</td>";
                }

                if(isset($row['Roll_Three_ID'])) {
                    $preparedURL = 'editRoll.php?rollID='.$row["Roll_Three_ID"];
                    echo "<td colspan='2'>
                        <a href='$preparedURL'>" . getNumberOfPinsHitForRollID($row['Roll_Three_ID']) . "</a></td>";
                }
                else {
                    echo "<td colspan=2>&nbsp;</td>";
                }
            }
        }
    }
    else { // no rolls yet
        foreach(range(0, 17) as $item) {
            echo "<td colspan = 3>&nbsp;</td>";
        }
        echo "<td colspan = 2>&nbsp;</td>";
        echo "<td colspan = 2>&nbsp;</td>";
        echo "<td colspan = 2>&nbsp;</td>";

    }
}
function printOutPlayerInfoOnTeam($playerID, $gameID, $teamID, $playerTitle) {
    $teamName = getTeamNameForTeamId($teamID);
    $playerName = getPlayerNameForPlayerId($playerID);
    echo '<tr>';
    echo "<th colspan=12 rowspan=2>$teamName<br>$playerTitle: $playerName</th>";
    printRollsInformation($playerID, $gameID, $teamID);
    echo calculateTotalScore();
    echo '</tr>';
}

function getInformationAboutGame($gameID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM GAME, Game_Location WHERE Game.Game_ID = $gameID and Game.Location_ID = Game_Location.Game_Location_ID";

    $result = $conn->query($sql);

    return $result;
}


function calculateTotalScore() {
    $totalScore = 300; // TODO - Calculate Total Score. Right now it'll return 300.
    $total = "<th colspan='6' rowspan=2>$totalScore</th>";
    return $total;
}

function printOutFrameTotals($playerID, $gameID, $teamID) {
    echo '<tr>';

    $conn = connectToDatabase();
    $sql = "SELECT Frame_ID, Frame_Number, Score FROM Frame where Frame.Player_ID = $playerID and Frame.Team_ID = $teamID and Frame.Game_ID = $gameID";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $preparedURL = 'viewFrame.php?frameID=' . $row["Frame_ID"] . '&frameNumber=' . $row['Frame_Number'];
            echo '<td colspan=6><a href=' . $preparedURL . '>' . $row["Score"] . '</a></td colspan=6>';
        }
    }
    echo '</tr>';
}

function getNumberOfPinsHitForRollID($rollID) {
    $sql = "select Hit_Pin_1, Hit_Pin_2, Hit_Pin_3, Hit_Pin_4, Hit_Pin_5, Hit_Pin_6, Hit_Pin_7, Hit_Pin_8, Hit_Pin_9, Hit_Pin_10, Is_Foul, Is_Spare, Is_Strike from roll where roll_id = $rollID;";
    $conn = connectToDatabase();

    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['Is_Foul']) {
                return 'F';
            }
            else if ($row['Is_Spare']) {
                return '/';
            }
            else if($row['Is_Strike']) {
                return 'X';
            }
            else {
                return calculateNumberOfPinsHit($row['Hit_Pin_1'],
                    $row['Hit_Pin_2'], $row['Hit_Pin_3'], $row['Hit_Pin_4'],
                    $row['Hit_Pin_5'], $row['Hit_Pin_6'], $row['Hit_Pin_7'],
                    $row['Hit_Pin_8'], $row['Hit_Pin_9'], $row['Hit_Pin_10']
                );
            }
        }
    }
    return '&nbsp';
}

function calculateNumberOfPinsHit(...$pins) {
    return array_sum($pins) == 0 ? '-' : array_sum($pins);
}

function printInformationAboutGame($result, $gameID) {
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $allTeams = $row['Teams'];
            $separatedTeams = explode(",", $allTeams);
            foreach ($separatedTeams as $team) {
                printGameInfoForEachPlayer($team, $gameID);
                echo '<tr><td></td></tr>';

            }
        }
    }
}

function printGameInfoForEachPlayer($teamID, $gameID) {
    $conn = connectToDatabase();
    $sql = "SELECT Leader, Player_1, Player_2, Player_3, Player_4, Player_5 FROM Team where Team.Team_ID = $teamID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if(isset($row['Leader'])) {
                printOutPlayerInfoOnTeam($row['Leader'], $gameID, $teamID, 'Leader');
                printOutFrameTotals($row['Leader'], $gameID, $teamID);
            }
            if(isset($row['Player_1'])) {
                printOutPlayerInfoOnTeam($row['Player_1'], $gameID, $teamID, 'Player 1');
                printOutFrameTotals($row['Player_1'], $gameID, $teamID);
            }
            if(isset($row['Player_2'])) {
                printOutPlayerInfoOnTeam($row['Player_2'], $gameID, $teamID, 'Player 2');
                printOutFrameTotals($row['Player_2'], $gameID, $teamID);
            }
            if(isset($row['Player_3'])) {
                printOutPlayerInfoOnTeam($row['Player_3'], $gameID, $teamID, 'Player 3');
                printOutFrameTotals($row['Player_3'], $gameID, $teamID);
            }
            if(isset($row['Player_4'])) {
                printOutPlayerInfoOnTeam($row['Player_4'], $gameID, $teamID, 'Player 4');
                printOutFrameTotals($row['Player_4'], $gameID, $teamID);
            }
            if(isset($row['Player_5'])) {
                printOutPlayerInfoOnTeam($row['Player_5'], $gameID, $teamID, 'Player 5');
                printOutFrameTotals($row['Player_5'], $gameID, $teamID);
            }
        }
    } else {
        die("ERROR");
    }
}

?>


<br>
<?php echo getNumberOfPinsHitForRollID(300); ?>

<div id='scoresheet'>
    <table id='scoresheetTable' class='scoresheet' cellpadding='1' cellspacing='0'>
        <?php
        $gameID = $_GET['gameID'];
        $result = getInformationAboutGame($gameID);
        printColumnLegend();
        printInformationAboutGame($result, $gameID);
        ?>
    </table>
</div>


<style type="text/css">
    table.scoresheet {margin: 0 auto; width:80%; font-size:12px; border:1px solid; text-align: center; table-layout: fixed; margin-bottom: 40px;}
    table.scoresheet th, tr, td {padding: 0; vertical-align: middle; font-family: Arial, Helvetica, sans-serif; font-weight: bold;}
    table.scoresheet th {border-bottom:1px solid; background-color: #fff6f9; height:30px;}
    table.scoresheet th:not(:last-child) {border-right:1px solid;}
    table.scoresheet td {height:30px; background: rgba(255, 255, 255, 0.5);}
    table.scoresheet tr td:not(:last-child) {border-right:1px solid;}
    table.scoresheet tr:nth-child(2) td:nth-child(even) {border-bottom:1px solid;}
    table.scoresheet tr:nth-child(2) td:last-child {border-bottom:1px solid;}

    table {
        border-spacing: 0;
    }

    table tr td {
        border: 1px solid black;

    }
</style>

