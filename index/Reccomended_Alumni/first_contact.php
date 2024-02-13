<!DOCTYPE html>
<html>
    <head>
        testing
    </head>
    <body>
        <div>
            <nav>
                <table>
                    <a href = "../help.php">Help</a>
                    <a href = "../message.php">Message</a>
                    <a href = "../forum.php">Forum</a>
                    <a href = "../calendar.php">Calendar</a>
                    <a href = "../profile.php">Profile</a>
                </table>
            </nav>
        </div>
        <div>
            <img src = "images/christopher-newport-university-jerry-gammon.jpeg">
        </div>
        <div>
            <h1>First Contact</h1>
        </div>
        <div>
            <div>
                <table>
                    <tr>
                        <p>Account Name<p>
                        <input></input>
                    </tr>
                    <tr>
                        <p>Account ID<p>
                        <input></input>
                    </tr>
                </table>
                <table>
                    <tr>
                        <p>Enter the account name and ID of the who you would like to request to talk to</p>
                        <button>Submit</button>
                    </tr>
                </table>
            </div>
        </div>
    </body>
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
    return $conn;
?>
</html>
