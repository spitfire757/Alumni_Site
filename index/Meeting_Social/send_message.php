<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "User is not logged in.";
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

$currentUserEmail = $_SESSION['username'];





if (!isset($_SESSION['username']) || !isset($_POST['message']) || !isset($_POST['connectionId'])) {
    echo "Invalid access.";
    exit;
}

$currentUserEmail = $_SESSION['username'];
$connectionId = $_POST['connectionId'];
$message = $_POST['message'];

$sql = "INSERT INTO messages (id, message_text) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $connectionId, $message);
if ($stmt->execute()) {
    echo "Message sent successfully!";
} else {
    echo "Error sending message: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>

