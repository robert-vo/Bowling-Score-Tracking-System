<!DOCTYPE html>
<html>
<head>
    <title>Bowling Score Tracking System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="audit.css">
</head>

<body>


<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a class="active" href="audit.php">Audit</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a href="loginF.php">Login</a></li>
</ul>

<p>
    Which table do you want to edit?
    <form action="runAudit.php" method="post">
    <select name="bowlingAudit">
        <option value="">Select...</option>
        <option value="Ball">Ball</option>
        <option value="Bowling_Events">Bowling Events</option>
        <option value="Frame">Frame</option>
        <option value="Game">Game</option>
        <option value="Players">Players</option>
        <option value="Roll">Roll</option>
        <option value="Player_Stats">Player Stats</option>
        <option value="Team">Team</option>
    </select>
    <input type="submit" value="Submit">
</form>
</p>




</body>
</html>
