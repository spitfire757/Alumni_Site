<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0; url=http://54.204.96.13/Alumni_Site/index/Authentication_Login/login.php">
    <title>Signing Out...</title>
</head>
<body>
    <p>Signing out...</p>
    <p>If you are not redirected automatically, <a href="http://54.204.96.13/Alumni_Site/index/Authentication_Login/login.php">click here</a>.</p>
</body>
</html>

