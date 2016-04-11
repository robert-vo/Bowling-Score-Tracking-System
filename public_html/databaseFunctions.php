<?php

//Change to Remote to test deployment on
$typeOfConnection = getenv('typeOfConnection');

function connectToDatabase()
{
    if ($GLOBALS['typeOfConnection'] == 'Remote') {
        $servername = "mydbinstance2.cnotb9fanxgq.us-west-2.rds.amazonaws.com:3306/bowling";
        $username = "bowlingdb";
        $password = "bowlingdb";
        $dbname = "bowling";
    } else {
        $servername = "localhost:3306";
        $username = "root";
        $password = "password";
        $dbname = "bowling";
    }
    return new mysqli($servername, $username, $password, $dbname);
}

function returnResultForQuery($query) {
    $connection = connectToDatabase();
    return $connection->query($query);
}

function getAllTeamsForAPlayerID($playerID) {
    $query = "SELECT * FROM team 
              WHERE Leader = '$playerID' 
                OR Player_1 = '$playerID' 
                OR Player_2 = '$playerID' 
                OR Player_3 = '$playerID' 
                OR Player_4 = '$playerID' 
                OR Player_5 = '$playerID'";

    return returnResultForQuery($query);
}

?>