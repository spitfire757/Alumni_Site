<!DOCTYPE html>
<html>
<style>
    .iframe-container {
        position: relative;
        width: 100%;
        height: 300px; /* Adjust height as needed */
        overflow: hidden;
    }
    .iframe-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .fixed-header {
        position: sticky;
        top: 0;
        background-color: white;
        padding: 10px;
        z-index: 1000; /* Ensure it's above the iframe content */
    }
    .scrollable-content {
        overflow-y: scroll;
        height: calc(100% - 40px); /* Subtract header height */
        padding-top: 40px; /* Adjust according to header height */
    }
</style>
<body>
<div class="iframe-container">
    <div class="fixed-header">
        <?php

            session_start();

            $servername = "localhost";
            $username = "mysql_user";
            $password = "r00tpassw0rd/";
            $dbname = "DB";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get forumID from session
            if(isset($_GET['forumID']) && isset($_GET['forumTitle']) && isset($_GET['forumDescription'])) {
                $_SESSION["forumID"] = $_GET['forumID'];
                $_SESSION["forumTitle"] = $_GET['forumTitle'];
                $_SESSION["forumDescription"] = $_GET['forumDescription'];
            }

            $forum_ID = $_SESSION["forumID"];
            $forum_Title = $_SESSION["forumTitle"];
            $forum_Description = $_SESSION["forumDescription"];
            
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
            $query = "SELECT * FROM Forum_Response WHERE ForumID = '$forum_ID' ORDER BY $sort_by;";
            $result = $conn->query($query);
            
            if (!$result) {
                echo "Error: " . $conn->error;
            }
            
            // Display forum title and description
            echo "<h2>".$forum_Title."</h2>";
            echo "<p>".$forum_Description."</p>";
            echo "<br><a href='forum2.php'>Back to Forum</a>";
            echo "<hr>";
        ?>
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

            echo "<hr>";

            // If the form is submitted, add the content to the Forum_Response table
            if(isset($_POST['submit'])) {
                $responseID = substr(hash('sha256', $_POST['response']), 0, 16);
                $userID = $_SESSION['username'];
                $response = $_POST['response'];
                $dateTime = date("Y-m-d H:i:s");

                // Insert the response into Forum_Response table
                $sql = "INSERT INTO Forum_Response VALUES ('$responseID', '$forum_ID', '$userID', '$response', NOW())";
                $result = $conn->query($sql); 

                // Check if the insert was successful [this section was generated by ChatGPT to help with functionality]
                if($result) {
                    // Redirect to refresh the page
                    header("Location: response2.php?forumID=$forum_ID&forumTitle=$forum_Title&forumDescription=$forum_Description");
                    exit();
                } else {
                    echo "Error: " . $conn->error;
                }
            }

            // Handle vote increment and decrement
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
                foreach ($_POST['vote'] as $response_vote => $vote_direction) {
                    $responseID = substr($response_vote, 0, -3); // Extract the response ID from the name attribute
                    $vote_type = substr($response_vote, -3); // Extract the vote direction (up or down)

                    // Update the votes in the database
                    $sql = "UPDATE Forum_Response SET votes = votes " . ($vote_type === '_up' ? '+' : '-') . " 1 WHERE ResponseID = '$responseID'";
                    $result = $conn->query($sql);

                    // Check if the update was successful
                    if (!$result) {
                        echo "Error: " . $conn->error;
                    }
                }
                header("Location: response2.php?forumID=$forum_ID&sort_by=$sort_by");
                exit();
            }

            if (!$result) {
                echo "Error: " . $conn->error;
            }

            // Display forum responses
            while ($row = $result->fetch_assoc()) {
                // Display each response
            }
        ?>
    </div>
</div>
</body>
</html>

        