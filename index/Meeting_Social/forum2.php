<link rel='stylesheet' type='text/css' href='Alumni_Site/index/style/global_style.css'>
<?php
// Connect to SQL Database
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
// Select All Forums in Forum Table
$query = "SELECT * FROM Forum";
$result = mysqli_query($conn, $query);
?>

<a href="Alumni_Site/index/Meeting_Social/create_forum.php">
    <button type = "button">Create a Forum</button>
</a>

<?php
// Display forum titles and descriptions
while ($row = mysqli_fetch_assoc($result)) {
    // Link to response.php with Forum Contents in Link for each forum
    echo "<div class='forum-item'>";
    echo "<a href='response3.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']}</a><br>";
    echo "<p class='forum-description'>{$row['Description']}</p>";
    echo "</div>";
}
?>


