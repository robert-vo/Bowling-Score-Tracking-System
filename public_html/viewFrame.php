<link rel="stylesheet" type="text/css" href="audit.css">

<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

echo '<h1><div text align="center">Frame Information</div></h1>';

function getRollInformationForFrame($frameID) {

}

getRollInformationForFrame($_GET['frameID']);
