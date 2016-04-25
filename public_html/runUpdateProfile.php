<?php
session_start();


if (!isset($_SESSION["sess_user"])) {

    header("location:loginForm.php");

} else { ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update Profile</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="update.css">
    </head>

    <body>

    <?php
    include 'menuBar.php';
    include 'databaseFunctions.php';
    generateMenuBar(basename(__FILE__));


    function getColumnNames($tablename)
    {
        $conn = connectToDatabase();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $queryAllColumns = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE '$tablename';";
        $allColumns = $conn->query($queryAllColumns);

        $conn->close();

        $columnNames = array();
        if ($allColumns->num_rows > 0) {
            while ($row = $allColumns->fetch_assoc()) {
                array_push($columnNames, $row["Column_name"]);
            }
        } else {
            echo "0 results";
        }
        return $columnNames;
    }


    function generateUpdateQuery() {
        $username = $_SESSION['sess_user'];
        $columnNames = getColumnNames("Players");

        $updatedFields = array();
        $updatedFieldColumns = array();
        for($i = 0; $i < count($columnNames); $i++) {
            if (isset($_POST[$columnNames[$i]]) && ($_POST[$columnNames[$i]] != "")) {
                //echo $_POST[$columnNames[$i]] . ' ';
                array_push($updatedFields, $_POST[$columnNames[$i]]);
                array_push($updatedFieldColumns, $columnNames[$i]);
            }
        }

        for($i = 0; $i < count($updatedFields); $i++) {
            //echo $updatedFieldColumns[$i] . ': ' . $updatedFields[$i] . "<br>";
        }

        //Update..
        $query = "UPDATE players SET ";
        for($i = 0; $i < count($updatedFields); $i++) {
            $query .= "$updatedFieldColumns[$i] = " . "'" . $updatedFields[$i] . "'";
            if ($i + 1 < count($updatedFields)) {
                $query .= ", ";
            }
        }
        $query .= " WHERE Email = '$username'";
        //echo $query;
        return $query;
    }


    $conn = connectToDatabase();

    $query = generateUpdateQuery();


    // Success message
    if((mysqli_query($conn, $query) == TRUE)) {
        $username = $_SESSION['sess_user'];
        $query = "SELECT * FROM players WHERE Email = '$username';";
        $result = $conn->query($query);

        echo "<br> Profile has been successfully updated to the following values:<br><br>";

        echo "<table class='updated alternate'>";

        if ($result->num_rows != 0) {
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td><b>First Name</b></td><td>" . $row['First_Name'] . "</td></tr>";
                echo "<tr><td><b>Middle Initial</b></td><td>" . $row['Middle_Initial'] . "</td></tr>";
                echo "<tr><td><b>Last Name</b></td><td>" . $row['Last_Name'] . "</td></tr>";
                echo "<tr><td><b>Gender</b></td><td>" . $row['Gender'] . "</td>";
                echo "<tr><td><b>Phone number</b></td><td>" . $row['Phone_Number'] . "</td></tr>";
                echo "<tr><td><b>Date of Birth</b></td><td>" . $row['Date_Of_Birth'] . "</td></tr>";
                echo "<tr><td><b>Street Address</b></td><td>" . $row['Street_Address'] . "</td></tr>";
                echo "<tr><td><b>City</b></td><td>" . $row['City'] . "</td></tr>";
                echo "<tr><td><b>State</b></td><td>" . $row['State'] . "</td></tr>";
                echo "<tr><td><b>Zip code</b></td><td>" . $row['Zip_Code'] . "</td></tr>";
            }
        }
        echo "</table>";
        echo "<br>";
        echo "<form action='loginSuccessful.php' method='post'>
                <input type='submit' value='Back to profile'>
            </form>";

    }
    else {
        $error = "Unable to update.\n\nError: " . $conn->error;
        $error = json_encode($error);
        echo "<script type='text/javascript'>alert($error); history.go(-1);</script>";
    }

    $conn->close();

    ?>


    </body>

    </html>



    <?php
}
?>