<?php

//Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = getenv('databaseConnection');
        $username = getenv('databaseUsername');
        $password = getenv('databasePassword');
        $dbname = getenv('databaseName');
    } else {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    return new mysqli($servername, $username, $password, $dbname);
}

?>