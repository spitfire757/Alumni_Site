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

$forum_ID = $_SESSION["forumID"];
$forum_Title = $_SESSION["forumTitle"];
$forum_Description = $_SESSION["forumDescription"];

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Forum_Response WHERE ForumID = 'qwerty';";
echo "1";
$stmt = $conn->prepare($query);
echo "2";
$stmt->bind_param("i", $forum_ID);
echo "3";
$stmt->execute();
echo "4";
$result = $stmt->get_result();
echo "5";

if (!$result) {
    echo "Error: " . $conn->error;
}

// Display forum title and description
echo "<h2>".$forum_Title."<h2><br>";
echo "<p>".$forum_Description."</p><br><br>";

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
