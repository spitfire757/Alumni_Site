<!-- signout.php -->
<?php
session_start();

$_SESSION = array();

session_destroy();

// Redirect to the sign-in or home page
header("Location: /Alumni_Site/index/Authentication_Login/login.php");
exit();
?>

