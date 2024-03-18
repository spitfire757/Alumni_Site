<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get forumID from session
if(isset($_GET['forumID']) && isset($_GET['forumTitle']) && isset($_GET['forumDescription'])) {
    $_SESSION["forumID"] = $_GET['forumID'];
    $_SESSION["forumTitle"] = $_GET['forumTitle'];
    $_SESSION["forumDescription"] = $_GET['forumDescription'];
}

$forum_ID =  $_SESSION["forumID"];
$forum_Title = $_SESSION["forumTitle"];
$forum_Title = $_SESSION["forumDescription"];

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Forum_Response WHERE ForumID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $forum_ID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error: " . $conn->error;
}

// Display forum title and description
$query_forum = "SELECT * FROM Forum WHERE ForumID = ?";
$stmt_forum = $conn->prepare($query_forum);
$stmt_forum->bind_param("i", $forum_ID);
$stmt_forum->execute();
$result_forum = $stmt_forum->get_result();
$row_forum = $result_forum->fetch_assoc();

echo "<h2>{$row_forum['title']}</h2>";
echo "<p>{$row_forum['description']}</p>";

// Display forum responses
while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['response_content']}</p>";
    echo "<p>UserID: {$row['userID']}</p>";
    echo "<hr>";
}

// Link to return to forum.php
echo "<a href='forum2.php'>Back to Forum</a>";

// Close statements
$stmt->close();
$stmt_forum->close();

// Close connection
$conn->close();
?>
