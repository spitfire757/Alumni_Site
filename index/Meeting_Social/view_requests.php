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

    $receiverUsername = $_SESSION['username'];

    // Query pending friend requests
    $sql = "SELECT * FROM friend_requests WHERE receiver_name = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receiverUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Pending Friend Requests</h2>";
    echo "<ul>";

    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['sender_username']} wants to connect. <a href='accept_request.php?request_id={$row['request_id']}'>Accept</a></li>";
    }

    echo "</ul>";

    $stmt->close();

    // Close the database connection
    $conn->close();
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>

