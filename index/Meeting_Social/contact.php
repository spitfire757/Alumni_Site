<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<form action="send_request.php" method="post">
    <table>
        <tr>
            <td><label for="accountName">Account Name:</label></td>
            <td><input type="text" id="accountName" name="accountName" required></td>
        </tr>
    </table>
    <button type="submit">Submit</button>
</form>
<?php

session_start();

if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the sender's username and user ID from session
    $senderUsername = $_SESSION['username'];
    // Get receiver's name and ID from the form submission
    // Retrieve UserID and other fields based on the email (username)
    $sql = "SELECT UserID, email, Fname, LName FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);
   
