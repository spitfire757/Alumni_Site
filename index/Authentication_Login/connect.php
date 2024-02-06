<?php
session_start();
    if (isset($_SESSION['username'])) {
    // Replace these with your actual database credentials
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Current User : ",  $_SESSION['username'];
    echo "<br> This is a test script for allowing the current unique user (stored in DB as userID) 	to stay signed in across webpages";
    echo "<br> This page will only show up if a registred user is signed in";
    }
    else{
	    echo "No user signed in, unable to connect to DB, go to sign in page or register";
    }
?>
