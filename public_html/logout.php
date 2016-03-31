<?php
session_start();
unset($_session['sess_user']);
session_destroy();
header("location:loginForm.php");
?>