<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<?php

function connectToDatabase($destination) {
    if($destination == 'Local') {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    else { //Remote
        $servername = "us-cdbr-azure-central-a.cloudapp.net";
        $username = "ba27b2787a498a";
        $password = "e24ebaaa";
        $dbname = "bowling";
    }
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}



?>
<?php

if(isset($_POST['formSubmit']) )
{
    $varMovie = $_POST['formMovie'];
    $varName = $_POST['formName'];
    $varGender = $_POST['formGender'];
    $errorMessage = "";

    // - - - snip - - -
}

?>
<?php

if(!isset($_POST['formGender']))
{
    $errorMessage .= "<li>You forgot to select your Gender!</li>";
}

?>


<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a class = "active"href="audit.php">Audit</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a href="loginF.php">Login</a></li>
</ul>

<p>
    Which table do you want to edit?
    <select name="bowlingAudit">
        <option value="">Select...</option>
        <option value="Ball">Ball</option>
        <option value="Events">Events</option>
        <option value="Frame">Frame</option>
        <option value="Game">Game</option>
        <option value="Players">Players</option>
        <option value="Roll">Roll</option>
        <option value="Statistics">Statistics</option>
        <option value="Team">Team</option>
    </select>
</p>




</body>
</html>
