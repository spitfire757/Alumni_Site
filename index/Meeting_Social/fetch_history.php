<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<li>User is not logged in.</li>";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<li>Connection failed: " . $conn->connect_error . "</li>");
}

if (isset($_POST['connectionId'])) {
    $connectionId = $_POST['connectionId'];
    $sql = "SELECT message_text FROM messages WHERE id = ? ORDER BY message_text";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $connectionId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($row['message_text']) . "</li>";
        }
    } else {
        echo "<li>No messages found.</li>";
    }
} else {
    echo "<li>No connection selected.</li>";
}

$conn->close();
?>

