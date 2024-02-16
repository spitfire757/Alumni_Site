<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<form action="send_request.php" method="post">
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
    echo "Current User :",  $_SESSION['username'];
    $senderUsername = $_SESSION['username'];
    $receiverName = $_POST['accountName'];
    $receiverID = $_POST['accountID'];

    // Insert the request into the database
    $sql = "INSERT INTO friend_requests (sender_username, receiver_name, receiver_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $senderUsername, $receiverName, $receiverID);
    $stmt->execute();
    $stmt->close();

    echo "Request sent successfully!";
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>


