<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));

echo "<br> You have succesfully requested to join the team!";
echo "<br> The team leader has received your request and will get back to you soon!"

?>