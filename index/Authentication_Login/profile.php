<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        
        <div>
            <nav>
                <table>
                    <tr>
                        <td>
                            <a href = "../help.php">Help</a>
                        </td>
                        <td>
                            <a href = "../message.php">Message</a>
                        </td>
                        <td>
                            <a href = "../forum.php">Forum</a>
                        </td>
                        <td>
                            <a href = "../calendar.php">Calendar</a>
                        </td>
                        <td>
                            <a href = "../profile.php">Profile</a>
                        </td>
                    </tr>
                </table>
            </nav>
        </div>
<img src="avatar.png" alt="Avatar" class="avatar">
<br>
<form action="edit_profile.php" method="get">
<button type="submit">Edit Profile</button>
</form>
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
	$currentUser = $_SESSION['username'];
        echo "<br> Username $currentUser <br>";
        echo "Password ( Needs to stay hidden) <br>";
        echo "Major<br>";
        echo "Minor <br>";
        echo "About <br>";
        echo "Experience <br>";
        echo "Resume <br>";
}
?>

</body>
</html>

