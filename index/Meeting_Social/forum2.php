<?php

session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "SELECT * FROM Forum";
$result = mysqli_query($conn, $query);

if(isset($_GET['name'])) {
    // If a forum is selected, save its information in session
    $forumID = $_GET['name'];
    $_SESSION["ForumID"] = $forumID;
    // Redirect to response2.php
}

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

// Close connection
mysqli_close($conn);

