<!DOCTYPE html>
<html>
<head>
    <title>Scores</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">

    <script>
        function showTopTen(select) {
            if(select == "") {
                document.getElementById("topten").innerHTML = "Select the report you want..";
            }
            else {
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("topten").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "getTopTen.php?report=" + select, true);
                xmlhttp.send();
            }
        }
    </script>
</head>

<body>

<?php
session_start();
include 'menuBar.php';
include 'databaseFunctions.php';
generateMenuBar(basename(__FILE__));
?>


<br>
<form>
    <select name="report" onchange="showTopTen(this.value)">
        <option value="">Select a report..</option>
        <option value="teams_win_count">Top teams by win count</option>
        <option value="teams_win_perc">Top teams by percentage</option>
        <option value="teams_most_games">Teams with most games</option>
        <option value="players_perfect_game">Players with perfect games</option>
    </select>
</form>

<br> <div id="topten">Select the report you want..</div>


</body>
</html>
