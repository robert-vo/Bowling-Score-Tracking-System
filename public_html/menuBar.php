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

        if ($currentPage == "about.php") {
            echo '<li><a class="active" href="about.php">About</a></li>';
        } else {
            echo '<li><a href="about.php">About</a></li>';
        }

        if ($currentPage == "reports.php") {
            echo '<li><a class="active" href="reports.php">Reports</a></li>';
        } else {
            echo '<li><a href="reports.php">Reports</a></li>';
        }

        if ($currentPage == "logout.php") {
            echo '<li style="float:right"><a class="active" href="logout.php">Logout</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
        }

        if ($_SESSION['user_role']) {
            $auditPages = array();
            $auditPages[] = "audit.php";
            $auditPages[] = "runAudit.php";
            $auditPages[] = "updateRow.php";
            $auditPages[] = "updated.php";
            $auditPages[] = "createRow.php";
            $auditPages[] = "created.php";

            if (in_array($currentPage, $auditPages)) {
                echo '<li style="float:right"><a class="active" href="audit.php">Audit</a></li>';
            } else {
                echo '<li style="float:right"><a href="audit.php">Audit</a></li>';
            }
        }
        else { //not admin
            if ($currentPage == "team.php" or $currentPage == "leaveTeam.php") {
                echo '<li style="float:right"><a class="active" href="team.php">Team</a></li>';
            } else {
                echo '<li style="float:right"><a href="team.php">Team</a></li>';
            }

            if ($currentPage == "manager.php") {
                echo '<li style="float:right"><a class="active" href="manager.php">Manage Team</a></li>';
            } else {
                echo '<li style="float:right"><a href="manager.php">Manage Team</a></li>';
            }

            if ($currentPage == "games.php" or $currentPage == "createGame.php" or $currentPage == "runCreateGame.php" or $currentPage == "viewGame.php" or $currentPage == "viewFrame.php") {
                echo '<li style="float:right"><a class="active" href="games.php">Games</a></li>';
            } else {
                echo '<li style="float:right"><a href="games.php">Games</a></li>';
            }

            if ($currentPage == "statistics.php") {
                echo '<li style="float:right"><a class="active" href="statistics.php">Player Stats</a></li>';
            } else {
                echo '<li style="float:right"><a href="statistics.php">Player Stats</a></li>';
            }

            
        }

        if ($currentPage == "loginSuccessful.php" || $currentPage == "updateProfile.php" || $currentPage == "runUpdateProfile.php") {
            echo '<li style="float:right"><a class="active" href="loginSuccessful.php">Profile</a></li>';
        } else {
            echo '<li style="float:right"><a href="loginSuccessful.php">Profile</a></li>';
        }


        echo '</ul>';
    }
}
else {
    function generateMenuBar($currentPage)
    {
        echo '<ul>';
        if ($currentPage == "index.php") {
            echo '<li><a class="active" href="index.php">Home</a></li>';
        } else {
            echo '<li><a href="index.php">Home</a></li>';
        }

        if ($currentPage == "reports.php") {
            echo '<li><a class="active" href="reports.php">Reports</a></li>';
        } else {
            echo '<li><a href="reports.php">Reports</a></li>';
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