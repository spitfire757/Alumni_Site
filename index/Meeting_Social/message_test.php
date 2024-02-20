<?php
session_start();
    if (isset($_SESSION['username'])) {
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
    echo "<br> Check connection : return a valid connection function:";


    }
    // Between here and the else statement will be executed if a user is signed in
    //
    //
    //
    //
    // Dont edit anything below for now
    else{
	    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
    }
?>
