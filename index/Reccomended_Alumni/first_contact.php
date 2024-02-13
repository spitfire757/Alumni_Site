<!DOCTYPE html>
<html>
<head>
    <title>Testing</title>
</head>
<body>
    <div>
        <nav>
            <table>
                <a href="../help.php">Help</a>
                <a href="../message.php">Message</a>
                <a href="../forum.php">Forum</a>
                <a href="../calendar.php">Calendar</a>
                <a href="../profile.php">Profile</a>
            </table>
        </nav>
    </div>
    <div>
        <img src="images/christopher-newport-university-jerry-gammon.jpeg">
    </div>
    <div>
        <h1>First Contact</h1>
    </div>
    <div>
        <div>
            <form action="request.php" method="post">
                <table>
                    <tr>
                        <td><label for="accountName">Account Name:</label></td>
                        <td><input type="text" id="accountName" name="accountName" required></td>
                    </tr>
                    <tr>
                        <td><label for="accountID">Account ID:</label></td>
                        <td><input type="text" id="accountID" name="accountID" required></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>



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
    echo "Here you can request to message certain accounts";
      


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
