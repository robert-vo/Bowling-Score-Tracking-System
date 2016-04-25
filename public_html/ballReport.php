<?php
include 'databaseFunctions.php';


function printBallPopularity($orderBy, $showTop) {
    $conn = connectToDatabase();

    $query = "SELECT roll.Ball_ID, Count(roll.Ball_ID) as numOfRolls, ball.Color
                FROM roll, ball
                WHERE roll.Ball_ID = ball.Ball_ID
                GROUP by Ball_ID
                ORDER BY COUNT(Ball_ID) $orderBy LIMIT $showTop";

    $result = $conn->query($query);
    printTable($result);

    $conn->close();
}


function printTable($result) {
    if($result->num_rows > 0) {
        $reportHeader = "Number of Rolls";
        echo "<table class='report alternate'>";
        echo "<tr class='table_header'><th>Place</th><th>Ball ID</th><th>$reportHeader</th><th>Color</th></tr>";
        $place = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>$place</td>";
            echo "<td>" . $row['Ball_ID'] . "</td>";
            echo "<td>" . $row['numOfRolls'] . "</td>";
            echo "<td>" . $row['Color'] . "</td>";
            echo "</tr>";

            $place++;
        }
        echo "</table>";
    } else {
        echo "Fatal Error! No bowling balls exist.";
    }
}


$category = $_POST['category'];
$reportType = $_POST[ $category . 'ReportType'] ;
$orderBy = $_POST[ $category . 'OrderBy' ];
$showTop = $_POST[ $category . 'ShowTop' ];

if($reportType == "ball_pop") {
    if ($orderBy == "ASC")
        $order = 'least';
    else
        $order = 'most';
    echo "<h5>Here are the top $showTop bowling balls that are the $order popular.</h5>";
    printBallPopularity($orderBy, $showTop);

}
?>