<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: http://54.204.96.13/Alumni_Site/index/Authentication_Login/login.php");
exit;
?>

