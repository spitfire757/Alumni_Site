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

    // Assuming you have a function to accept the friend request based on request_id
    if (isset($_GET['request_id'])) {
        $requestId = $_GET['request_id'];

        // Update status to 'accepted' in the friend_requests table
        $updateSql = "UPDATE friend_requests SET status = 'accepted' WHERE request_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("i", $requestId);
        $updateStmt->execute();

        // Add logic here to handle the accepted friend request

        $updateStmt->close();
    } else {
        echo "Invalid request. No request_id specified.";
    }
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
header("Location: view_requests.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Friend Request</title>
</head>

<body>
    <!-- Your HTML content for accept_request.php goes here -->
</body>

</html>

