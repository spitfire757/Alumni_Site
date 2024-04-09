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
    <a href="Alumni_Site/index/Meeting_Social/create_forum.php">
        <button type = "button">Create a Forum</button>
    </a>
<hr>
    <form action="forum2.php" method="GET">
        <input type="text" name="search_query" placeholder="Search">
        <select name="search_criteria">
            <option value="title">Title</option>
            <option value="description">Description</option>
            <option value="author">Author</option>
        </select>
        <button type="submit">Search</button>
    </form>
</hr>

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
    if(isset($_GET['search_query']) && isset($_GET['search_criteria'])) {
        // Retrieve Search Query and Criteria
        $search_query = $_GET['search_query'];
        $search_criteria = $_GET['search_criteria'];

        // Construct SQL Query
        $sql = "SELECT * FROM forums WHERE ";

        // Add WHERE clause based on selected criteria
        if ($search_criteria === 'title') {
            $sql .= "title LIKE '%$search_query%'";
        } elseif ($search_criteria === 'description') {
            $sql .= "description LIKE '%$search_query%'";
        } elseif ($search_criteria === 'author') {
            $sql .= "author LIKE '%$search_query%'";
        }

        // Execute SQL Query
        $result = $conn->query($sql);

        // Display Search Results
        if ($result->num_rows > 0) {
            echo "<h2>Search Results:</h2>";
            while ($row = $result->fetch_assoc()) {
                // Display search results here
                echo "<p>Title: {$row['title']}</p>";
                echo "<p>Description: {$row['description']}</p>";
                echo "<p>Author: {$row['author']}</p>";
            }
        } else {
            echo "No results found.";
        }
    }
?>


