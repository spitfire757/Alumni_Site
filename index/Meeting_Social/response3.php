<?php
session_start();

// Check if forum ID is set
if(!isset($_SESSION["forumID"]) || !isset($_SESSION["forumTitle"]) || !isset($_SESSION["forumDescription"])) {
    // Redirect to a page where forum information is expected to be set
    header("Location: forum2.php");
    exit();
}

$forum_ID = $_SESSION["forumID"];
$forum_Title = $_SESSION["forumTitle"];
$forum_Description = $_SESSION["forumDescription"];

// Include database connection
include 'db_connection.php';

// Default sorting
$sort_by = "Datetime DESC";

// Check if sorting option is selected
if (isset($_GET['sort_by'])) {
    switch ($_GET['sort_by']) {
        case 'datetime_desc':
            $sort_by = "Datetime DESC";
            break;
        case 'datetime_asc':
            $sort_by = "Datetime ASC";
            break;
        case 'popularity_desc':
            $sort_by = "votes DESC";
            break;
        case 'popularity_asc':
            $sort_by = "votes ASC";
            break;
        default:
            // Default sorting if invalid option is selected
            $sort_by = "Datetime DESC";
            break;
    }
}

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Forum_Response WHERE ForumID = '$forum_ID' ORDER BY $sort_by";
$result = $conn->query($query);

// Check if the result is valid
if (!$result) {
    echo "Error: " . $conn->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Response Page</title>
<style>
    .fixed-header {
        position: sticky;
        top: 0;
        background-color: white;
        padding: 10px;
        z-index: 1000; /* Ensure it's above the iframe content */
    }
    .scrollable-content {
        overflow-y: scroll;
        max-height: calc(100vh - 80px); /* Adjust according to header height */
    }
</style>
</head>
<body>

<div class="fixed-header">
    <h2><?php echo $forum_Title; ?></h2>
    <p><?php echo $forum_Description; ?></p>
    <br><a href='forum2.php'>Back to Forum</a>
    <hr>
    <!-- Reply Form -->
    <form action='response2.php' method='post'>
        <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
        <button type='submit' name='submit'>Reply</button>
    </form>
    <hr>
    <!-- Sorting Methods-->
    <form action="response2.php" method="get">
        <select name="sort_by">
            <option value="datetime_desc">Datetime Added (Newest to Oldest)</option>
            <option value="datetime_asc">Datetime Added (Oldest to Newest)</option>
            <option value="popularity_desc">Popularity (Most Upvotes)</option>
            <option value="popularity_asc">Popularity (Least Upvotes)</option>
        </select>
        <button type="submit">Sort</button>
    </form>
    <hr>
</div>

<div class="scrollable-content">
    <?php
    // Display forum responses
    while ($row = $result->fetch_assoc()) {
        echo "<div style='display: flex; align-items: center;'>";
        echo "<div style='margin-right: 10px;'>"; // Left column for voting system
        echo "<form method='post'>";
        // Each button has a unique name attribute containing the response ID and vote direction
        echo "<button type='submit' name='vote[{$row['ResponseID']}_up]' value='up'>A</button>";
        echo $row['votes'];
        echo "<button type='submit' name='vote[{$row['ResponseID']}_down]' value='down'>V</button>";
        echo "</form>";
        echo "</div>";
        echo "<div>"; // Right column for response content
        echo "<h3>{$row['UserID']} • {$row['Datetime']}</h3>";
        echo "<p>{$row['Response']}</p>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

<?php
// If the form is submitted, add the content to the Forum_Response table
if(isset($_POST['submit'])) {
    // Handle form submission
}

// Handle vote increment and decrement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
    // Handle vote increment and decrement
}
?>
</body>
</html>

   
