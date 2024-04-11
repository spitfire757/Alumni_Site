
<link rel='stylesheet' type='text/css' href='../style/global_style.css'>
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

<style>
        /* Button styles */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Table styles */
        table {
            margin: auto;
            width: 80%;
        }

        td {
            padding: 10px;
            text-align: center;
        }
    </style>
<body style="text-align: center; font-family: Trajan Pro, sans-serif;">

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
</body>
<?php
// Display forum titles and descriptions
    // PHP Logic for Handling Search
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_criteria = $_GET['search_criteria'];

    // SQL query to retrieve forums based on search criteria
    $sql = "SELECT * FROM Forum WHERE $search_criteria LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching forums
        while ($row = $result->fetch_assoc()) {
            // Display forum details
            echo "<div class='forum-item'>";
            echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']} • {$row['userID']}</a>";
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
            echo "<a href='response2.php?forumID={$row['ForumID']}&forumTitle={$row['Title']}&forumDescription={$row['Description']}' class='forum-title'>{$row['Title']} • {$row['userID']}</a>";
            echo "<p class='forum-description'>{$row['Description']}</p>";
            echo "<hr>";
            echo "</div>";
        }
    } else {
        echo "No forums available.";
    }
}
?>