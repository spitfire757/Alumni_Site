<?php

session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "SELECT * FROM Forum";
$result = mysqli_query($conn, $query);

// Include the CSS file
echo "<link rel='stylesheet' type='text/css' href='Alumni_Site/index/style/global_style.css'>";

// Display forum titles and descriptions
while ($row = mysqli_fetch_assoc($result)) {
    // Link to response.php with forum ID as parameter
    echo "<div class='forum-item'>";
    echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']}</a><br>";
    echo "<p class='forum-description'>{$row['Description']}</p>";
    echo "</div>";
}


