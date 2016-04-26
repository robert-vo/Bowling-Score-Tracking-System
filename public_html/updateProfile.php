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
        <link rel="stylesheet" type="text/css" href="updateProfile.css">

    </head>

    <body>
    <?php
    include 'menuBar.php';
    include 'databaseFunctions.php';
    generateMenuBar(basename(__FILE__));
    echo "<br>";
    $username = $_SESSION['sess_user'];

    $conn = connectToDatabase();

    $columnQuery = "SELECT distinct Column_name FROM Information_schema.columns WHERE Table_name LIKE 'players';";

    $resultColumns = $conn->query($columnQuery);
    $columnNames = array();

    if($resultColumns->num_rows > 0) {
        while ($row = $resultColumns->fetch_assoc()) {
            array_push($columnNames, $row['Column_name']);
        }
    } else {
        echo "0 results";
    }
    
    $query = "SELECT * FROM players WHERE Email = '$username'";
    $result = $conn->query($query);
    
    echo "<table>";
    echo "<tr>";
    echo "<td class='pad'><a class='edit update' href='changeEmail.php'>Change email</a></td>";
    echo "<td class='pad'><a class='edit update' href='changePassword.php'>Change password</a></td>";
    echo "</tr>";
    echo "</table>";


    echo "<br><br>";
    echo "<fieldset><legend>Edit my profile</legend>";
    echo "<form action='runUpdateProfile.php' method='post' onsubmit=\"return confirm('Are you sure you want to submit this form?');\">";
    echo "<table class='fieldset'>";
    
    if($result->num_rows != 0) {
        while($row = $result->fetch_assoc()) {

            echo "<tr><td><b>First Name</b></td><td><input type='text' name='First_Name' value='" . $row['First_Name'] . "'></td></tr>";
            echo "<tr><td><b>Last Name</b></td><td><input type='text' name='Middle_Initial' value='" . $row['Middle_Initial'] . "'></td></tr>";
            echo "<tr><td><b>Last Name</b></td><td><input type='text' name='Last_Name' value='" . $row['Last_Name'] . "'></td></tr>";
            echo "<tr><td><b>Gender</b></td>";

            echo "<td>";
            echo "<select name='Gender'>";

            if($row['Gender'] == 'M') { // Sets the default value of the gender field
                echo "<option value='M' selected='selected'>Male</option>
                      <option value='F'>Female</option>";
            } else {
                echo "<option value='M'>Male</option>
                      <option value='F' selected='selected'>Female</option>";
            }
            echo "</select>";
            echo "</td></tr>";

            echo "<tr><td><b>Phone number</b></td><td><input type='text' name='Phone_Number' value='" . $row['Phone_Number'] . "'></td></tr>";
            echo "<tr><td><b>Date of Birth</b></td><td><input type='date' name='Date_Of_Birth'></td></tr>";
            echo "<tr><td><b>Street Address</b></td><td><input type='text' name='Street_Address' value='" . $row['Street_Address'] . "'></td></tr>";
            echo "<tr><td><b>City</b></td><td><input type='text' name='City' value='" . $row['City'] . "'></td></tr>";
            echo "<tr><td><b>State</b></td><td><input type='text' name='State' value='" . $row['State'] . "'></td></tr>";
            echo "<tr><td><b>Zip code</b></td><td><input type='text' name='Zip_Code' value='" . $row['Zip_Code'] . "'></td></tr>";
        }
    }
    echo "</table>";
    echo "<div class='center'><input type='submit' value='Update Profile'></div>";
    echo "</form></fieldset>";
    

    $conn->close();

    ?>


    </body>

    </html>



<?php
}
?>