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
        echo '<li style="float:right"><a class="active" href="about.php">About</a></li>';
    }
    else {
        echo '<li style="float:right"><a href="about.php">About</a></li>';
    }

    if($currentPage == "loginForm.php" or $currentPage == "loginSuccessful.php" or $currentPage == "register.php") {
        if($currentPage == "loginSuccessful.php"){
            echo '<li style="float:right"><a class = "active" href="logout.php">Logout</a></li>';
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