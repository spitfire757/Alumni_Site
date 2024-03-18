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
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
}

// Display forum title and description
echo "<h2>".$forum_Title."<h2><br>";
echo $forum_Description;

echo "<input type='text' name='userID' placeholder='userID' maxlength='64'><br>
      <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
      <button type = 'submit' name = 'submit' formaction='forum.php' required>Reply</button><br>";

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
