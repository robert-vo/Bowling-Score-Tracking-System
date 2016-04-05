<link rel="stylesheet" type="text/css" href="index.css">

<?php
function generateMenuBar($currentPage) {
    
    echo '<ul>';
    if($currentPage == "index.php") {
        echo '<li><a class="active" href="index.php">Home</a></li>';
    }
    else {
        echo '<li><a href="index.php">Home</a></li>';
    }
    
    if($currentPage == "scores.php") {
        echo '<li><a class="active" href="scores.php">Scores</a></li>';
    }
    else {
        echo '<li><a href="scores.php">Scores</a></li>';
    }
    
    if($currentPage == "about.php") {
        echo '<li><a class="active" href="about.php">About</a></li>';
    }
    else {
        echo '<li><a href="about.php">About</a></li>';
    }




    if(isset($_SESSION['sess_user'])) {
        if($currentPage == "loginSuccessful.php" or "team.php" or "about.php" or "settings.php"){
            echo '<li style="float:right"><a class = "active" href="loginSuccessful.php.php">login</a></li>';
            echo '<li style="float:right"><a class = "active" href="settings.php">Settings</a></li>';
            echo '<li style="float:right"><a class = "active" href="team.php">Team</a></li>';
            echo '<li style="float:right"><a class = "active" href="loginSuccessful.php.php">Profile</a></li>';

        }
        else {
            echo '<li style="float:right"><a class = "active" href="loginForm.php">Login</a></li>';
        }


    }
    else {
        echo '<li style="float:right"><a href="loginForm.php">Login</a></li>';
    }
    
    if($currentPage == "audit.php" or $currentPage == "runAudit.php") {
        echo '<li style="float:right"><a class="active" href="audit.php">Audit</a></li>';
    }



    echo '</ul>';
}
?>