<!doctype html>
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
    </style>
    <meta charset="utf-8">
    <title> Registration</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
<ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="scores.php">Scores</a></li>
    <li style="float:right"><a href="about.php">About</a></li>
    <li style="float:right"><a class = "active" href="loginF.php">Login</a></li>
</ul>
<br>

<div id="box">
    <div id="boxH">
        REGISTER
    </div>
    <div id="boxF">
        <form method="post">
            <input type="text" name="fname" placeholder="First Name" >
            <input type="text" name="lname" placeholder="Last Name" >
            <input type="text" name="middle" placeholder="Middle Initial" >
            <input type="text" name="streeta" placeholder="Street Address" >
            <input type="text" name="city" placeholder="City" >
            <input type="text" name="state" placeholder="State" >
            <input type="text" name="zipcode" placeholder="Zip Code" >
            <input type="text" name="email" placeholder="Email" >
            <input type="password" name="password" placeholder="Password" >
            <input type="text" name="vpassword" placeholder="Verify Password" >
            <input type="submit" name="valid" value="Submit">
        </form>
    </div>
    Already have an about?  <a href="loginF.php">Login!</a>
</div>

</body>
</html>


