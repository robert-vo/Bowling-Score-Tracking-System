<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title> Registration</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="loginAndRegistrationForm.css">
</head>

<body>

<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>

<br>

<?php
include 'databaseFunctions.php';

if (isset($_POST['valid'])) {
    $pass1 = $_POST['password'];
    $pas2 = $_POST['vpassword'];
    if ($pass1 == $pas2) {

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $middle = $_POST['middle'];
        $street = $_POST['streeta'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zipcode'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $birth = $_POST['birth'];
        $email = $_POST['email'];


        $conn = connectToDatabase();

        $sql = "INSERT INTO players (Gender, Phone_Number, Date_Joined, Date_Of_Birth, Street_Address, City, State, Zip_Code, First_Name, Last_Name, Middle_Initial, Email, Password, Is_Admin)
                                     VALUES ('$gender', '$phone', null, '$birth', '$street', '$city', '$state', '$zip', '$fname', '$lname', '$middle', '$email', '$password', 0) ";


        if (mysqli_query($conn, $sql) == TRUE) {
            echo "insertion successful";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Sorry, passwords do not match.";
    }
} else {
    $form = <<<EOT
    <div id="box">
    <div id="boxH">
        REGISTER
    </div>
    <div id="boxF">
        <form action="register.php" method="POST">
            <input type="text" name="fname" placeholder="First Name" >
            <input type="text" name="lname" placeholder="Last Name" >
            <input type="text" name="middle" placeholder="Middle Initial" >
             <input type="text" name="phone" placeholder="Phone Number" >
              <input type="text" name="birth" placeholder="YYYY-MM-DD" >
             <input type="text" name="gender" placeholder="Gender: F or M" >
            <input type="text" name="streeta" placeholder="Street Address" >
            <input type="text" name="city" placeholder="City" >
            <input type="text" name="state" placeholder="State" >
            <input type="text" name="zipcode" placeholder="Zip Code" >
            <input type="text" name="email" placeholder="Email" >
            <input type="password" name="password" placeholder="Password" >
            <input type="password" name="vpassword" placeholder="Verify Password" >
            <input type="submit" name="valid" value="Submit" >

        </form>
    </div>

</div>
EOT;
    echo $form;
}
?>

<br>
<div id="centerT"><a href="loginForm.php">Login</a></div>

</body>
</html>