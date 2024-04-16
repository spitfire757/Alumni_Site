<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_POST['connectionId'])) {
    echo "<li>Invalid access or no data provided.</li>";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$connectionId = $_POST['connectionId'];
// Query to fetch messages ordered by sent_time in descending order
$sql = "SELECT message_text FROM messages WHERE id = ? ORDER BY sent_time DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . htmlspecialchars($conn->error);
    exit;
}
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

$stmt->close();
$conn->close();
?>

