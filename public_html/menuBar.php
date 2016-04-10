<link rel="stylesheet" type="text/css" href="index.css">

<?php
if(isset($_SESSION['sess_user'])){
    function generateMenuBar($currentPage)
    {
        echo '<ul>';
        if ($currentPage == "index.php") {
            echo '<li><a class="active" href="index.php">Home</a></li>';
        } else {
            echo '<li><a href="index.php">Home</a></li>';
        }


        if ($currentPage == "scores.php") {
            echo '<li><a class="active" href="scores.php">Score</a></li>';
        } else {
            echo '<li><a href="scores.php">Score</a></li>';
        }

        if ($currentPage == "games.php") {
            echo '<li><a class="active" href="games.php">Games</a></li>';
        } else {
            echo '<li><a href="games.php">Games</a></li>';
        }

        if ($currentPage == "about.php") {
            echo '<li><a class="active" href="about.php">About</a></li>';
        } else {
            echo '<li><a href="about.php">About</a></li>';
        }


        if ($currentPage == "logout.php") {
            echo '<li style="float:right"><a class="active" href="logout.php">Logout</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
        }


        if ($currentPage == "settings.php") {
            echo '<li style="float:right"><a class="active" href="settings.php">Settings</a></li>';
        } else {
            echo '<li style="float:right"><a href="settings.php">Settings</a></li>';
        }

        if ($currentPage == "team.php") {
            echo '<li style="float:right"><a class="active" href="team.php">Team</a></li>';
         } else {
            echo '<li style="float:right"><a href="team.php">Team</a></li>';
       }

        if ($currentPage == "loginSuccessful.php") {
            echo '<li style="float:right"><a class="active" href="loginSuccessful.php">Profile</a></li>';
        } else {
            echo '<li style="float:right"><a href="loginSuccessful.php">Profile</a></li>';
        }
        echo '</ul>';
    }
}
else{
    function generateMenuBar($currentPage)
    {
        echo '<ul>';
        if ($currentPage == "index.php") {
            echo '<li><a class="active" href="index.php">Home</a></li>';
        } else {
            echo '<li><a href="index.php">Home</a></li>';
        }


        if ($currentPage == "scores.php") {
            echo '<li><a class="active" href="scores.php">Score</a></li>';
        } else {
            echo '<li><a href="scores.php">Score</a></li>';
        }

        if ($currentPage == "games.php") {
            echo '<li><a class="active" href="games.php">Games</a></li>';
        } else {
            echo '<li><a href="games.php">Games</a></li>';
        }

        if ($currentPage == "about.php") {
            echo '<li><a class="active" href="about.php">About</a></li>';
        } else {
            echo '<li><a href="about.php">About</a></li>';
        }


        if ($currentPage == "loginForm.php") {
            echo '<li style="float:right"><a class="active" href="loginForm.php">Login</a></li>';
        } else {
            echo '<li style="float:right"><a href="loginForm.php">Login</a></li>';
        }
        echo '</ul>';
    }

}
?>
