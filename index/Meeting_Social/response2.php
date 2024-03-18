<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Get forumID from session
$forumID = $_SESSION["ForumID"];

echo $forumID;

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Response WHERE ForumID = '.$forumID.'";
$result = mysqli_query($conn, $query);

echo "testing if response 2 works";

// Display forum title and description
$query_forum = "SELECT * FROM Forum WHERE ForumID = '$forumID'";
$result_forum = mysqli_query($conn, $query_forum);
$row_forum = mysqli_fetch_assoc($result_forum);
echo "<h2>{$row_forum['title']}</h2>";
echo "<p>{$row_forum['description']}</p>";

// Display forum responses
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['response_content']}</p>";
    echo "<p>UserID: {$row['userID']}</p>";
    echo "<hr>";
}

// Link to return to forum.php
echo "<a href='forum.html'>Back to Forum</a>";

// Close connection
mysqli_close($conn);
