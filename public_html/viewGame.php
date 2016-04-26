<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';
error_reporting(0);
include 'src/game.php';
include '../src/game.php';
error_reporting(E_ALL);


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
            if($row['Frame_Number'] != 10) {//not tenth frame

                linkToEditRoll($row["Roll_One_ID"],$playerID,3);
                if(isset($row['Roll_Two_ID'])) {
                    linkToEditRoll($row["Roll_Two_ID"],$playerID,3);
                }
                else {
                    echo "<td colspan=3>&nbsp;</td>";
                }
            }
            else {//tenth frame
                linkToEditRoll($row["Roll_One_ID"],$playerID,2);
                if(isset($row['Roll_Two_ID'])) {
                    linkToEditRoll($row["Roll_Two_ID"],$playerID,2);
                }
                else {
                    echo "<td colspan=2>&nbsp;</td>";
                }
                if(isset($row['Roll_Three_ID'])) {
                    linkToEditRoll($row["Roll_Three_ID"],$playerID,2);
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

function linkToEditRoll($rollID, $playerID,$width){
    //check user id, allow or reject edit access
    if($_SESSION['player_id'] == $playerID) {
//        $preparedURL = 'editRoll.php?rollID=' . $rollID . '&gameID=' . $_GET['gameID'];
        $preparedURL = 'editRoll.php?rollID=' . $rollID;

        echo "<td colspan='$width'>" . getNumberOfPinsHitForRollID($rollID) . "</td>";
    }
    else{
        echo "<td colspan='$width'>".getNumberOfPinsHitForRollID($rollID)."</td>";
    }

}

function printOutPlayerInfoOnTeam($playerID, $gameID, $teamID, $playerTitle) {
    $teamName = getTeamNameForTeamId($teamID);
    $playerName = getPlayerNameForPlayerId($playerID);
    echo '<tr>';
    if($_SESSION['player_id'] == $playerID){
        $conn = connectToDatabase();
        //get number of last frame
        $frameNumber = 1;
        $query = "SELECT max(Frame_Number) as 'max' FROM Frame WHERE player_ID = $playerID AND Game_ID = $gameID AND Team_ID = $teamID";
        $allFrames = $conn->query($query);
        $temp = $allFrames->fetch_assoc();
        $maxFrame = $temp['max'];
        $gameIsDone = 0;

        //set current frame number and roll ID
        $rollID='';
        if($maxFrame == 10) {//on the tenth frame
            //see if game is done, in case of tenth frame
            $query = "SELECT * FROM Frame WHERE player_ID = $playerID AND Game_ID = $gameID AND Team_ID = $teamID AND Frame_Number = $maxFrame";
            $result = $conn->query($query);
            if ($result) {//frame exists
                $row = $result->fetch_assoc();

                $rollOneID = $row['Roll_One_ID'];
                $query = "SELECT * FROM Roll WHERE Roll_ID = $rollOneID";
                $result2 = $conn->query($query);
                if($result2){//roll one exists
                    $pinsDown1 = getNumberOfPinsHitForRollID($rollOneID);
                    if($pinsDown1 > 0) {//roll one is full
                        //look for roll 2
                        $rollTwoID = $row['Roll_Two_ID'];
                        $query = "SELECT * FROM Roll WHERE Roll_ID = $rollTwoID";
                        $result2 = $conn->query($query);
                        if ($result2) {//roll two exists
                            $pinsDown2 = getNumberOfPinsHitForRollID($rollTwoID);
                            if($pinsDown2 > 0) {//roll two is full
                                //check if roll three should be set
                                $pinsDown1 = getNumberOfPinsHitForRollID($row['Roll_One_ID']);
                                $pinsDown2 = getNumberOfPinsHitForRollID($row['Roll_Two_ID']);
                                $total = $pinsDown1 + $pinsDown2;
                                if ($total >= 10) {//roll three needed
                                    //check if roll three is set
                                    $rollThreeID = $row['Roll_Three_ID'];
                                    $query = "SELECT * FROM Roll WHERE Roll_ID = $rollThreeID";
                                    $result2 = $conn->query($query);
                                    if ($result2) {//roll three exists
                                        $gameIsDone = 1;
                                    } else {//roll three does not exist
                                        $gameIsDone = 0;
                                    }

                                }else {//roll three should be null, game is done
                                    $gameIsDone = 1;
                                }
                            }else{//roll two is empty
                                $rollID = $rollTwoID;
                                $frameNumber = $maxFrame;
                            }
                        }else{//roll two doesn't exist
                            $rollID = $rollTwoID;
                            $frameNumber = $maxFrame;
                        }
                    }else{//row one is empty
                        $rollID = $rollOneID;
                        $frameNumber = $maxFrame;
                    }
                }
            }
        }
        else if($maxFrame > 0){//max is less than 10
            //see if game is done, in case of normal frame
            $query = "SELECT * FROM Frame WHERE player_ID = $playerID AND Game_ID = $gameID AND Team_ID = $teamID AND Frame_Number = $maxFrame";
            $result = $conn->query($query);
            if ($result) {//frame exists
                $row = $result->fetch_assoc();

                $rollOneID = $row['Roll_One_ID'];
                $query = "SELECT * FROM Roll WHERE Roll_ID = $rollOneID";
                $result2 = $conn->query($query);
                if ($result2) {//roll one exists
                    $pinsDown1 = getNumberOfPinsHitForRollID($rollOneID);
                    if($pinsDown1 > 0){//roll one is full
                        if($pinsDown1==10){// roll one is a strike
                            //look to next frame
                            $frameNumber = $maxFrame+1;
                        }
                        else{//roll one is not a strike
                            //look for roll 2
                            $rollTwoID = $row['Roll_Two_ID'];
                            $query = "SELECT * FROM Roll WHERE Roll_ID = $rollTwoID";
                            $result2 = $conn->query($query);
                            if ($result2) {//roll two exists
                                $pinsDown2 = getNumberOfPinsHitForRollID($rollTwoID);
                                if($pinsDown2 > 0){//roll two is full
                                    //look to next frame
                                    $frameNumber = $maxFrame+1;
                                }
                                else{//roll two is empty
                                    $rollID = $rollTwoID;
                                    $frameNumber = $maxFrame;
                                }
                            } else{//frame two doesn't exist
                                $rollID = $rollTwoID;
                                $frameNumber = $maxFrame;
                            }
                        }
                    }
                    else{//row one is empty
                        $rollID = $rollOneID;
                        $frameNumber = $maxFrame;
                    }
                } else{//frame one doesn't exist
                    $rollID = $rollOneID;
                    $frameNumber = $maxFrame;
                }
            }
        }
        //if maxFrames is 0, then frame number stays as 1


        //check if button shows
        if(!$gameIsDone) {//show button

//            echo "current frame = $frameNumber";
//            echo "roll ID = $rollID";
            echo "<th colspan=6 rowspan=2><form action='addRoll.php' method='post'>
                <input type='hidden' name='gameID' value='$gameID'>
                <input type='hidden' name='teamID' value='$teamID'>
                <input type='hidden' name='playerID' value='$playerID'>
                <input type='hidden' name='frameNumber' value='$frameNumber'>
                <input type='hidden' name='rollID' value='$rollID'>
                <input type='submit' value='Add Roll'>";
            echo "</form></th>";
            echo "<th colspan=6 rowspan=2>$teamName<br>$playerTitle: $playerName</th>";
        }
        else{//show normal box
            
            echo "<th colspan=12 rowspan=2>$teamName<br>$playerTitle: $playerName</th>";
        }
    }else{//not the logged in player
        echo "<th colspan=12 rowspan=2>$teamName<br>$playerTitle: $playerName</th>";
    }
    printRollsInformation($playerID, $gameID, $teamID);
    $game = calculateTotalScore($playerID, $gameID, $teamID);

    $score = $game->score();
    echo "<th colspan='6' rowspan=2>$score</th>";
    printOutFrameTotals($playerID, $gameID, $teamID, $game->score_by_frame());
    echo '</tr>';
}

function getInformationAboutGame($gameID) {
    $conn = connectToDatabase();
    $sql = "SELECT * FROM GAME, Game_Location WHERE Game.Game_ID = $gameID and Game.Location_ID = Game_Location.Game_Location_ID";

    $result = $conn->query($sql);

    return $result;
}


function calculateTotalScore($playerID, $gameID, $teamID) {
    $game = new \bowling\game();
    $conn = connectToDatabase();
    $getAllFrames = "SELECT Frame_Number, Roll_One_ID, Roll_Two_ID, Roll_Three_ID From Frame where Team_ID = $teamID and Game_ID = $gameID and Frame.Player_ID = $playerID";
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
    }

    return $game;
}

function printOutFrameTotals($playerID, $gameID, $teamID, $game) {
    echo '<tr>';

    $sql = "SELECT * FROM FRAME WHERE FRAME.Game_ID = $gameID and FRAME.Team_ID = $teamID and Frame.Player_ID = $playerID";
    $conn = connectToDatabase();
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $preparedURL = 'viewFrame.php?frameID=' . $row["Frame_ID"] . '&frameNumber=' . $row['Frame_Number'];
            echo '<td colspan=6><a href=' . $preparedURL . '>' . $game[$row['Frame_Number']] . '</a></td colspan=6>';
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
//                printOutFrameTotals($row['Leader'], $gameID, $teamID);
            }
            if(isset($row['Player_1'])) {
                printOutPlayerInfoOnTeam($row['Player_1'], $gameID, $teamID, 'Player 1');
//                printOutFrameTotals($row['Player_1'], $gameID, $teamID);
            }
            if(isset($row['Player_2'])) {
                printOutPlayerInfoOnTeam($row['Player_2'], $gameID, $teamID, 'Player 2');
//                printOutFrameTotals($row['Player_2'], $gameID, $teamID);
            }
            if(isset($row['Player_3'])) {
                printOutPlayerInfoOnTeam($row['Player_3'], $gameID, $teamID, 'Player 3');
//                printOutFrameTotals($row['Player_3'], $gameID, $teamID);
            }
            if(isset($row['Player_4'])) {
                printOutPlayerInfoOnTeam($row['Player_4'], $gameID, $teamID, 'Player 4');
//                printOutFrameTotals($row['Player_4'], $gameID, $teamID);
            }
            if(isset($row['Player_5'])) {
                printOutPlayerInfoOnTeam($row['Player_5'], $gameID, $teamID, 'Player 5');
//                printOutFrameTotals($row['Player_5'], $gameID, $teamID);
            }
        }
    } else {
        die("ERROR");
    }
}

?>


<br>

<div id='scoresheet'>
    <table id='scoresheetTable' class='scoresheet' cellpadding='1' cellspacing='0'>
        <?php
        if(isset($_GET['gameID'])) {
            $gameID = $_GET['gameID'];
            $result = getInformationAboutGame($gameID);
            printColumnLegend();
            printInformationAboutGame($result, $gameID);
        }
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

