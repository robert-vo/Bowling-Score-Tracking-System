<!DOCTYPE html>
<html>
<head>
    <style>
        div#box{
            background-color: white;
            border: 1px solid #4CAF50;
            width: 350px;
            margin:0 auto;
            box-shadow: 1px 0px 15px #4CAF50;
        }
        input{
            display: block;
            margin: 10px;
        }
        div#boxH{
            background-color: #4CAF50;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: white;
            padding: 20px;
        }
        input[type=text],input[type=password]{
            font-size: 15px;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #4CAF50;
        }
        input[type=submit]{
            background-color: #4CAF50;
            padding: 5px 10px 5px 10px;
            border-radius:3px ;
            border: 1px solid #4CAF50;
            color: white;
            font-weight: bold;
        }
        div#boxF{
            display: flex;
            justify-content: center;
        }
        div#centerT{
            text-align: center;
        }
    </style>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
<?php include 'menuBar.php';
generateMenuBar(basename(__FILE__));
?>



<br>
<div id="box">
    <div id="boxH">
        LOGIN
    </div>
    <div id="boxF">
        <form action ="loginF.php" method="POST">
            <input type="text" name="username" placeholder="Username" >
            <input type="password" name="password" placeholder="Password" >
            <input type="submit" name="valid" value="Login">
        </form>
    </div>

</div>
<br>
<div id="centerT"> <a href="Register.php">Create account</a></div>
<?php
include 'databaseFunctions.php';

if(isset($_POST["valid"])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connectToDatabase();
    $query = "SELECT * FROM players WHERE Email = '$username' AND Password = '$password'";
    $result = $conn->query($query);
    $numrows = $result->num_rows;
    if($numrows != 0){
        while ($row=mysqli_fetch_assoc($result)){
            $dbuser = $row['Email'];
            $dbpass = $row['Password'];
        }
        if($username == $dbuser and $password == $dbpass){
            session_start();
            $_SESSION['sess_user']=$username;
            
            header("location:loginSuccessful.php");
        }
    }
    else{
        echo "invalid username or password";
    }

}
?>

</body>
</html>
