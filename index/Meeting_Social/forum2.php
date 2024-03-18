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

// Display forum titles and descriptions
while ($row = mysqli_fetch_assoc($result)) {
    // Link to response.php with forum ID as parameter
    echo "<a href='response2.php?name={$row['ForumID']}'>{$row['Title']}</a><br>";
    echo "<p>{$row['Description']}</p>";
}

// Close connection
mysqli_close($conn);
