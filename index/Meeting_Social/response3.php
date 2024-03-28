<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style/global_style.css">
    <style>
        /* Additional styling for response elements */
        .response {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div>
    <h1>Forum</h1>
    
    <!-- Footer with UserID and Description -->
    <footer>
        <p>User ID: <?php echo $userID; ?></p>
        <p>Description: <?php echo $description; ?></p>
    </footer>

    <!-- Forum Responses -->
    <div class="responses">
        <h2>Responses</h2>
        <?php
        // Fetch and display responses
        foreach ($responses as $response) {
            echo '<div class="response">';
            echo '<p>Response ID: ' . $response['responseID'] . '</p>';
            echo '<p>User ID: ' . $response['userID'] . '</p>';
            echo '<p>Content: ' . $response['content'] . '</p>';
            echo '<p>DateTime: ' . $response['dateTime'] . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Sorting Options -->
    <div class="sorting-options">
        <h2>Sort Responses</h2>
        <form action="forum2.php" method="post">
            <select name="sort_by">
                <option value="dateTime">Date</option>
                <option value="popularity">Popularity</option>
            </select>
            <button type="submit" name="sort">Sort</button>
        </form>
    </div>

    <!-- Upvoting and Downvoting Buttons -->
    <div class="voting-buttons">
        <h2>Voting</h2>
        <!-- Upvote Button -->
        <form action="forum2.php" method="post">
            <button type="submit" name="upvote">Upvote</button>
        </form>
        <!-- Downvote Button -->
        <form action="forum2.php" method="post">
            <button type="submit" name="downvote">Downvote</button>
        </form>
    </div>

</div>
</body>
</html>
