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
<hr>
<a href="create_forum.php">
    <button type="button">Create a Forum</button>
</a>
<hr>
<form action="forum2.php" method="get">
    <input type="text" name="search_query" placeholder="Search...">
    <select name="search_criteria">
        <option value="title">Title</option>
        <option value="Description">Description</option>
        <option value="userID">Author</option>
    </select>
    <button type="submit">Search</button>
    <button type="submit" name="clear_search">Clear Search</button>
</form>
<hr>
<?php
// Display forum titles and descriptions
/*
while ($row = mysqli_fetch_assoc($result)) {
    // Link to response.php with Forum Contents in Link for each forum
    echo "<div class='forum-item'>";
    echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']}</a><br>";
    echo "<p class='forum-description'>{$row['Description']}</p>";
    echo "</div>";
}
*/
    // PHP Logic for Handling Search
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_criteria = $_GET['search_criteria'];

    // SQL query to retrieve forums based on search criteria
    $sql = "SELECT * FROM Forum WHERE $search_criteria LIKE '%$search_query%'";
    echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching forums
        while ($row = $result->fetch_assoc()) {
            // Display forum details
            echo "<div class='forum-item'>";
            echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']}</a><br>";
            echo "<p class='forum-description'>{$row['Description']}</p>";
            echo "</div>";
        }
    } else {
        echo "No forums found.";
    }
} elseif (isset($_GET['clear_search'])) {
    // Clear the search
    header("Location: forum2.php");
    exit();
} else {
    // Default display: All forums
    $sql = "SELECT * FROM Forum";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display all forums
        while ($row = $result->fetch_assoc()) {
            // Display forum details
            echo "<div class='forum-item'>";
            echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']}</a><br>";
            echo "<p class='forum-description'>{$row['Description']}</p>";
            echo "</div>";
        }
    } else {
        echo "No forums available.";
    }
}
?>