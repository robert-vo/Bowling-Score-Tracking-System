<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration</title>
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

$firstNameError = '';
$lastNameError = $genderError = $phoneNumberError = '';
$dateOfBirthError = $streetAddressError = $cityError = $zipCodeError = '';
$stateError = '';
$emailError = $passwordError = $verifyPasswordError = '';

function postReturnsValidData() {

    $formIsValid = true;

    if(isset($_POST['valid'])) {
        if(!preg_match("/^[a-zA-Z ]*$/",$_POST["firstName"])) {
            $GLOBALS['firstNameError'] = 'First Name cannot contain any numbers.';
            $formIsValid = false;
        }
        else if(empty($_POST["firstName"])) {
            $GLOBALS['firstNameError'] = 'First Name is required.';
            $formIsValid = false;
        }

        if(empty($_POST['lastName'])) {
            $GLOBALS['lastNameError'] = 'Last Name is required.';
            $formIsValid = false;
        }

        if(empty($_POST['gender'])) {
            $GLOBALS['genderError'] = 'Please select either M or F.';
            $formIsValid = false;
        }

        if(!is_numeric($_POST["phone"]) and !empty($_POST["phone"])) {
            $GLOBALS['phoneNumberError'] = 'Please only input numbers the phone number field.';
            $formIsValid = false;
        }
        else if(strlen($_POST["phone"]) != 10 and !empty($_POST["phone"])) {
            $GLOBALS['phoneNumberError'] = 'Phone number can only contain 10 numbers.';
            $formIsValid = false;
        }
        else if(empty($_POST["phone"])) {
            $GLOBALS['phoneNumberError'] = 'Phone Number is required.';
            $formIsValid = false;
        }

        if(empty($_POST['year']) or empty($_POST['day']) or empty($_POST['month'])) {
            $GLOBALS['dateOfBirthError'] = 'Date of Birth is required.';
            $formIsValid = false;
        }

        if(empty($_POST['streeta'])) {
            $GLOBALS['streetAddressError'] = 'Street Address is required.';
            $formIsValid = false;
        }

        if(!preg_match("/^[a-zA-Z ]*$/",$_POST["city"])) {
            $GLOBALS['cityError'] = 'City cannot contain any numbers.';
            $formIsValid = false;
        }
        else if(empty($_POST['city'])) {
            $GLOBALS['cityError'] = 'City is required.';
            $formIsValid = false;
        }

        if(!is_numeric($_POST["zipcode"]) and !empty($_POST["zipcode"])) {
            $GLOBALS['zipCodeError'] = 'Please only input numbers the zip code field.';
            $formIsValid = false;
        }
        else if(strlen($_POST["zipcode"]) != 5 and !empty($_POST["zipcode"])) {
            $GLOBALS['zipCodeError'] = 'Zip code can only contain 5 numbers.';
            $formIsValid = false;
        }
        else if(empty($_POST['zipcode'])) {
            $GLOBALS['zipCodeError'] = 'Zip Code is required.';
            $formIsValid = false;
        }

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $GLOBALS['emailError'] = 'A valid email address is required.';
            $formIsValid = false;
        }

        if(strlen($_POST["password"]) < 8 and !empty($_POST["password"])) {
            $GLOBALS['passwordError'] = 'Password must be at least 8 characters of length.';
            $formIsValid = false;
        }
        else if(empty($_POST['password'])) {
            $GLOBALS['passwordError'] = 'A password of character length with at least 8 characters is required.';
            $formIsValid = false;
        }

        if(strcmp($_POST['vpassword'], $_POST['password']) != 0) {
            $GLOBALS['verifyPasswordError'] = '*Passwords do not match!';
            $formIsValid = false;
        }

    }
    else {
        $formIsValid = false;
    }

    return $formIsValid;
}

if (postReturnsValidData()) {
    $firstName = ucfirst($_POST['firstName']);
    $lastName = ucfirst($_POST['lastName']);
    $middle = $_POST['middle'];
    $street = $_POST['streeta'];
    $city = ucfirst($_POST['city']);
    $state = $_POST['state'];
    $zip = $_POST['zipcode'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $doby = $_POST['year'];
    $dobm = $_POST['month'];
    $dobd = $_POST['day'];
    $birth = "$doby-$dobm-$dobd";
    $email = $_POST['email'];
    $conn = connectToDatabase();
    $sql = "INSERT INTO players (Gender, Phone_Number, Date_Of_Birth, Street_Address, City, State, Zip_Code, First_Name, Last_Name, Middle_Initial, Email, Password, Is_Admin)
                                 VALUES ('$gender', '$phone', '$birth', '$street', '$city', '$state', '$zip', '$firstName', '$lastName', '$middle', '$email', '$password', 0) ";
    if (mysqli_query($conn, $sql) == TRUE) {
        echo "Insertion successful";
    } else {
        echo "<div id=\"error\">Sorry, $conn->error,  please try registering again. </div> <br>Click <a href=\"register.php\">here</a> to go back to the registration page.</div>";
    }
    $conn->close();
    }
else {
    echo '<div id="box"><div id="boxH">REGISTER</div>
            <span style="margin:auto" class = "error">* Denotes a required field.</span>
            <div id="boxF">
            <form action="register.php" method="POST">
            <input type="text" name="firstName" placeholder="First Name">';

    echo '<span class="error">*' . $firstNameError . '</span>';

    echo '<input type="text" name="lastName" placeholder="Last Name" >';

    echo '<span class="error">*' . $lastNameError . '</span>';

    echo '<input type="text" name="middle" placeholder="Middle Initial" >';

    echo '<select name="gender">
	<option>Gender</option>
	<option value="F">Female</option>
	<option value="M">Male</option></select>';
    echo '<span class="error">*' . $genderError . '</span>';


    echo '<input type="text" name="phone" placeholder="Phone Number." >';
    echo '<span class="error">*' . $phoneNumberError . '</span><br>';

    echo '<select name="month">
	<option>Month</option>
	<option value="01">January</option>
	<option value="02">Febuary</option>
	<option value="03">March</option>
	<option value="04">April</option>
	<option value="05">May</option>
	<option value="06">June</option>
	<option value="07">July</option>
	<option value="08">August</option>
	<option value="09">September</option>
	<option value="10">October</option>
	<option value="11">November</option>
	<option value="12">December</option>
	    </select>
<select name="day">
	<option>Day</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
</select>
<select name="year">
	<option >Year</option>
	<option value="1993">1993</option>
	<option value="1992">1992</option>
	<option value="1991">1991</option>
	<option value="1990">1990</option>
	<option value="1989">1989</option>
	<option value="1988">1988</option>
	<option value="1987">1987</option>
	<option value="1986">1986</option>
	<option value="1985">1985</option>
	<option value="1984">1984</option>
	<option value="1983">1983</option>
	<option value="1982">1982</option>
	<option value="1981">1981</option>
	<option value="1980">1980</option>
	<option value="1979">1979</option>
	<option value="1978">1978</option>
	<option value="1977">1977</option>
	<option value="1976">1976</option>
	<option value="1975">1975</option>
	<option value="1974">1974</option>
	<option value="1973">1973</option>
	<option value="1972">1972</option>
	<option value="1971">1971</option>
	<option value="1970">1970</option>
	<option value="1969">1969</option>
	<option value="1968">1968</option>
	<option value="1967">1967</option>
	<option value="1966">1966</option>
	<option value="1965">1965</option>
	<option value="1964">1964</option>
	<option value="1963">1963</option>
	<option value="1962">1962</option>
	<option value="1961">1961</option>
	<option value="1960">1960</option>
	<option value="1959">1959</option>
	<option value="1958">1958</option>
	<option value="1957">1957</option>
	<option value="1956">1956</option>
	<option value="1955">1955</option>
	<option value="1954">1954</option>
	<option value="1953">1953</option>
	<option value="1952">1952</option>
	<option value="1951">1951</option>
	<option value="1950">1950</option>
	<option value="1949">1949</option>
	<option value="1948">1948</option>
	<option value="1947">1947</option>
	</select>';

    echo '<span class="error">*' . $dateOfBirthError . '</span>';

    echo '<input type="text" name="streeta" placeholder="Street Address">';
    echo '<span class="error">*' . $streetAddressError . '</span>';

    echo '<input type="text" name="city" placeholder="City">';
    echo '<span class="error">*' . $cityError . '</span>';


    echo '<br><select name="state">
    <option value="AL">AL</option>
    <option value="AK">AK</option>
    <option value="AZ">AZ</option>
    <option value="AR">AR</option>
    <option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
	</select>';

    echo '<input type="text" name="zipcode" placeholder="Zip Code" >';

    echo '<span class="error">*' . $zipCodeError . '</span>';

    echo '<input type="text" name="email" placeholder="Email" >';

    echo '<span class="error">*' . $emailError . '</span>';

    echo '<input type="password" name="password" placeholder="Password">';

    echo '<span class="error">*' . $passwordError . '</span>';

    echo '<input type="password" name="vpassword" placeholder="Verify Password">';

    echo '<span class="error">' . $verifyPasswordError . '</span>';

    echo '<input type="submit" name="valid" value="Submit" ></form></div></div>';
}
?>

<br>
<div id="centerT"><a href="loginForm.php">Login</a></div>

</body>
</html>