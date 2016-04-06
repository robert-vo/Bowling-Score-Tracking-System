<?php
session_start();
if (!isset($_SESSION["sess_user"])) {
    header("location:loginForm.php");

} else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title> Team Members </title>

        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
        <link rel="stylesheet" type="text/css" href="team.css">

        <style>
            div#error {
                color: red;
            }
        </style>
    </head>

    <body>


    <?php include 'menuBar.php';
    generateMenuBar(basename(__FILE__));

    ?>


    <div id="id">Team Members:</div>
    <?php
    include 'databaseFunctions.php';
    $conn = connectToDatabase();


    ?>

    </body>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:700&subset=latin,latin-ext'
          rel='stylesheet' type='text/css'>
    <ul class="responsive_grid">
        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>
        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>

        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>
        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>

        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>
        <li>
            <div class="team_member">
                <div class="info">
                    <img src="http://www.placecage.com/g/300/300" alt=""/>
                    <h5>Stanley Goodspeed</h5>
                    <h6>Director of Chemical Weaponry</h6>
                </div>
                <div class="info_reveal">
                    <h6>Contact<br/>Stanley Goodspeed</h6>
                    <p><a href="mailto:address@addresss.com">s.goodman@fbi.gov</a></p>
                    <p>(123) 555-1234 x1100</p>
                </div>
            </div>
        </li>


    </html>
    <?php
}
?>