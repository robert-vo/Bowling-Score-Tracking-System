<?php
session_start();
include 'menuBar.php';
include 'databaseFunctions.php';
if(!isset($_GET['category']))
    generateMenuBar(basename(__FILE__));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="reports.css">
    <script src="jquery.js"></script>
    <script type="text/javascript" src="submitReport.js"></script>
</head>

<body>

<div id="reportPage"><!-- div that holds all of the page's content when page is refreshed -->
<br><br>

<form>
    Select a category to get reports from: <select onchange="showSelection(this.value)">
        <option value="">Choose a category..</option>
        <?php
        $category = "";
        if(isset($_GET['category'])) {      // Selects the default option when the page is reloaded.
            $category = $_GET['category'];
            if($category == "players") {
                echo "<option value=\"players\" selected>Players</option>";
                echo "<option value=\"teams\">Teams</option>";
            } else if ($category == "teams") {
                echo "<option value=\"players\">Players</option>";
                echo "<option value=\"teams\" selected>Teams</option>";
            }
        } else {
            echo "<option value=\"players\">Players</option>";
            echo "<option value=\"teams\">Teams</option>";
        }
        ?>
    </select>
</form>

    <?php
        $displayPlayers = "style=\"display: none;\"";
        $displayTeams = "style=\"display: none;\"";
        if(isset($_GET['category'])) {
            if($_GET['category'] == "players") {
                $displayPlayers = "";
            }
            else if ($_GET['category'] == "teams") {
                $displayTeams = "";
            }
        }
    ?>
    
<br><div id="empty"></div>
    
    <table class="report" <?php echo $displayTeams; ?>>
        <tr>
            <form>
                <td>Report Type:
                    <select id="teamsReportType" name="teamsReportType">
                        <option value="win_count">Win Count</option>
                        <option value="win_percentage">Win Percentage</option>
                        <option value="games_played">Games Played</option>
                    </select>
                </td>

                <td>Order by:
                    <select id="teamsOrderBy" name="teamsOrderBy">
                        <option value="DESC">High to low</option>
                        <option value="ASC">Low to high</option>
                    </select>
                </td>

                <td>Show top:
                    <select id="teamsShowTop" name="teamsShowTop">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </td>
                <input type="hidden" id="category" value="<?php echo $category;?>">
                <td><input id="submit_teams" type="submit" value="<?php echo $category;?>"></td>

            </form>
        </tr>
    </table>

    <table class="report" <?php echo $displayPlayers; ?>>
        <tr>
            <form>
                <td>Report Type:
                    <select id="playersReportType" name="playersReportType">
                        <option value="Strikes">Strikes</option>
                        <option value="Spares">Spares</option>
                        <option value="Best_Score">Best Score</option>
                        <option value="Perfect_Games">Perfect Games</option>
                        <option value="Average_Pin_Left">Average Pins Left</option>
                    </select>
                </td>

                <td>Order by:
                    <select id="playersOrderBy" name="playersOrderBy">
                        <option value="DESC">High to low</option>
                        <option value="ASC">Low to high</option>
                    </select>
                </td>

                <td>Show top:
                    <select id="playersShowTop" name="playersShowTop">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </td>
                <input type="hidden" id="category" value="<?php echo $category;?>">
                <td><input id="submit_players" type="submit" value="<?php echo $category;?>"></td>

            </form>
        </tr>
    </table>
    <div id="reports"></div>

    
</div>
</body>
</html>
