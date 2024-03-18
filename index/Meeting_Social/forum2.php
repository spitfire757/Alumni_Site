<?php

session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "SELECT * FROM Forum";
$result = mysqli_query($conn, $query);

// Display forum titles and descriptions
while ($row = mysqli_fetch_assoc($result)) {
    echo "<h2>{$row['title']}</h2>";
    echo "<p>{$row['description']}</p>";
    // Link to response.php with forum ID as parameter
    echo "<a href='response2.php?forumID={$row['forumID']}'>Respond</a><br><br>";
}

// Close connection
mysqli_close($conn);
