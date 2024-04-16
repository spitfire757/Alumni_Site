<?php
// Connect to SQL Database
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

// Initialize forum content variable
$forumContent = '';

// Fetch forum data
$query = "SELECT * FROM Forum";
$result = mysqli_query($conn, $query);

// Check if there are forums available
if (mysqli_num_rows($result) > 0) {
    // Construct HTML for forum content
    while ($row = mysqli_fetch_assoc($result)) {
        $forumContent .= "<div class='forum-item'>";
        $forumContent .= "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title-smaller'>{$row['Title']} • {$row['userID']}</a>";
        $forumContent .= "<p class='forum-description'>{$row['Description']}</p>";
        $forumContent .= "<hr>";
        $forumContent .= "</div>";
    }
} else {
    // No forums found
    $forumContent = "No forums available.";
}

// Return forum content as HTML
echo $forumContent;

// Close database connection
$conn->close();
?>
