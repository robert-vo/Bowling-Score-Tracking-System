<?php

//Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    echo 'in function';
    echo getenv('databaseUsername');
    echo getenv('databaseConnection');
    echo getenv('databasePassword');
    echo getenv('databaseName');
    echo getenv('typeOfConnection');
//    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = getenv('databaseConnection');
        $username = getenv('databaseUsername');
        $password = getenv('databasePassword');
        $dbname = getenv('databaseName');
//    } else {
//        $servername = "localhost:3306";
//        $username = "root";
//        $password = "password";
//        $dbname = "bowling";
//    }
    return new mysqli($servername, $username, $password, $dbname);
}

echo 'hello';
$test = connectToDatabase();

?>