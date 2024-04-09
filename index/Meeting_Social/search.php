<?php

#if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";
    
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    ?>
    <hr>
    <form action="search.php" method="get">
        <input type="text" name="search_query" placeholder="Search...">
        <select name="search_criteria">
            <option value="title">Name</option>
            <option value="Description">Major</option>
            <option value="userID">Minor</option>
            <option value="userID">Graduation Year</option>
            <option value="userID">User</option>
        </select>
        <button type="submit">Search</button>
        <button type="submit" name="clear_search">Clear Search</button>
    </form>
    <hr>
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
            echo "<div class='user-item'>";
            echo "<a href='view_user.php?forumID={$row['UserID']}&forumTitle={$row['Fname']}&forumDescription={$row['Lname']}' class='forum-title'>{$row['email']} • {$row['UserID']}</a>";
            #echo "<p class='user-description'>{$row['Description']}</p>";
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
        // Display matching forums
        while ($row = $result->fetch_assoc()) {
            // Display forum details
            echo "<div class='user-item'>";
            echo "<a href='view_user.php?forumID={$row['UserID']}&forumTitle={$row['Fname']}&forumDescription={$row['Lname']}' class='forum-title'>{$row['email']} • {$row['UserID']}</a>";
            #echo "<p class='user-description'>{$row['Description']}</p>";
            echo "</div>";
        }
    } else {
        echo "No forums available.";
    }
}

    /*
    // Retrieve user details for users with security setting equal to 1
    $sql = "SELECT email, Major, Minor, intended_grad_year, Experience FROM User WHERE security = 1 AND email != ?";
    $stmt = $conn->prepare($sql);
	
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Public Users:</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Email: " . $row['email'] . "</li>";
            echo "<li>Major: " . $row['Major'] . "</li>";
            echo "<li>Minor: " . $row['Minor'] . "</li>";
            echo "<li>Graduation Year: " . $row['intended_grad_year'] . "</li>";
            echo "<li>Experience: " . $row['Experience'] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        echo "No users found with security setting set to 1.";
    }

    $stmt->close();
    $conn->close();
#} else {
#    echo "No user signed in.";
#}
?>
*/
?>

