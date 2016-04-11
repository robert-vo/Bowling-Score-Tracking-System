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

    printResult($result);

    $conn->close();
}

function printResultOf2($result) {
    if ($result->num_rows > 0) {

        $gameNumber = 1;

        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<table style = "width:100%"';
            echo '<caption>Game Number ' . $gameNumber . '</caption>';
            echo '<tr><th>First</th><th>Second</th>';
            $gameNumber++;
            $allTeams = $row['Teams'];
            $separatedTeams = explode(",", $allTeams);
            foreach ($separatedTeams as $team) {
                echo $team;
                getTeamNameForTeamId($team);
            }
//    <tr>
//        <th>Month</th>
//        <th>Savings</th>
//    </tr>
//    <tr>
//        <td>January</td>
//        <td>$100</td>
//    </tr>
//    <tr>
//        <td>February</td>
//        <td>$50</td>
//    </tr>
//</table>


            //echo "<br>" . $row['Teams'] . "<br>" . $row['Title'];
            echo "<br>";
        }
    } else {
        echo "0 results";
    }
}


function findAllGamesAPlayerIsAPartOf($playerID, $gameStatus) {
    $query = "select * from game where 
                game.Game_Finished = $gameStatus and (
                  game.Teams like '$playerID,%'
                    or game.Teams like '%,$playerID'
                    or game.Teams like '%,$playerID,%')";

    $conn = connectToDatabase();

    $result = $conn->query($query);

    printResultOf2($result);

}
echo '<p><font size="6"><b><u>Here are the incompleted games that you are participating in!</u></b></font></p>';
findAllGamesAPlayerIsAPartOf($_SESSION['player_id'], 0);
echo '<p><font size="6"><b><u>Here are the completed games that you participated in!</u></b></font></p>';
findAllGamesAPlayerIsAPartOf($_SESSION['player_id'], 1);


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



