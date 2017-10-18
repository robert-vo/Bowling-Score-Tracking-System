<?php
include 'databaseFunctions.php';


function printBallPopularity($orderBy, $showTop) {
    $conn = connectToDatabase();

    $query = "SELECT Roll.Ball_ID, Count(Roll.Ball_ID) as numOfRolls, Ball.Color, Ball.Weight, Ball.Size
                FROM Roll, Ball
                WHERE Roll.Ball_ID = Ball.Ball_ID
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
        echo "<tr class='table_header'><th>Place</th><th>Weight</th><th>Size</th><th>Color</th><th>$reportHeader</th></tr>";
        $place = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>$place</td>";
            echo "<td>" . $row['Weight'] . "</td>";
            echo "<td>" . $row['Size'] . "</td>";
            //echo "<td>" . $row['Color'] . "</td>";
            echo    "<td>
                <svg height='50' width='50'><circle cx='25' cy='25' r='20' stroke='black' stroke-width='2' fill='" . $row['Color'] . "'/></svg>
                    </td>";
            echo "<td>" . $row['numOfRolls'] . "</td>";
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