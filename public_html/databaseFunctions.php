<?php

//Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    echo getenv('databaseUsername');
    echo getenv('databaseConnection');
    echo getenv('databasePassword');
    echo getenv('databaseName');
    echo getenv('typeOfConnection');
//    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = "mydbinstance2.cnotb9fanxgq.us-west-2.rds.amazonaws.com:3306/bowling";
        $username = "bowlingdb";
        $password = "bowlingdb";
        $dbname = "bowling";
//    } else {
//        $servername = "localhost:3306";
//        $username = "root";
//        $password = "password";
//        $dbname = "bowling";
//    }
    return new mysqli($servername, $username, $password, $dbname);
}

?>