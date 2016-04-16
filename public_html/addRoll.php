<?php
session_start();
include 'menuBar.php';
generateMenuBar(basename(__FILE__));
include 'databaseFunctions.php';

if(isset($_POST['submit'])) {
    if(!isset($_POST['pins'])) {
        echo 'no pins hit!';
    }
    else {
        foreach($_POST['pins'] as $pin) {
            echo 'You have hit pin ' . $pin . '<br>';
        }
    }
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="roll.css">
    <title>Roll</title>
</head>
<body>

<p>
<form action="addRoll.php" method="POST">
    <span class = "pin1">
        <input type='checkbox' name='pins[]' value='1' id = 'pin1'/><label for ='pin1'>1</label>
    </span>

    <span class = "pin2">
        <input type='checkbox' name='pins[]' value='2' id = 'pin2'/><label for ='pin2'>2</label>
    </span>

    <span class = "pin3">
        <input type='checkbox' name='pins[]' value='3' id = 'pin3'/><label for ='pin3'>3</label>
    </span>

    <span class = "pin4">
        <input type='checkbox' name='pins[]' value='4' id = 'pin4'/><label for ='pin4'>4</label>
    </span>

    <span class = "pin5">
        <input type='checkbox' name='pins[]' value='5' id = 'pin5'/><label for ='pin5'>5</label>
    </span>

    <span class = "pin6">
        <input type='checkbox' name='pins[]' value='6' id = 'pin6'/><label for ='pin6'>6</label>
    </span>

    <span class = "pin7">
        <input type='checkbox' name='pins[]' value='7' id = 'pin7'/><label for ='pin7'>7</label>
    </span>

    <span class = "pin8">
        <input type='checkbox' name='pins[]' value='8' id = 'pin8'/><label for ='pin8'>8</label>
    </span>
    
    <span class = "pin9">
        <input type='checkbox' name='pins[]' value='9' id = 'pin9'/><label for ='pin9'>9</label>
    </span>

    <span class = "pin10">
        <input type='checkbox' name='pins[]' value='10' id = 'pin10'/><label for ='pin10'>10</label>
    </span>

    <br>
    <input type="submit" value="Submit Roll" name="submit">
</form>
</body>
</html>