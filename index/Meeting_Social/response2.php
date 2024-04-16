<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$username = $_SESSION['username'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['forumID']) && isset($_GET['forumTitle']) && isset($_GET['forumDescription'])) {
    $_SESSION["forumID"] = $_GET['forumID'];
    $_SESSION["forumTitle"] = $_GET['forumTitle'];
    $_SESSION["forumDescription"] = $_GET['forumDescription'];
}

$forum_ID = $_SESSION["forumID"];
$forum_Title = $_SESSION["forumTitle"];
$forum_Description = $_SESSION["forumDescription"];

$sort_by = "Datetime DESC";

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
            $sort_by = "Datetime DESC";
            break;
    }
}

$query = "SELECT * FROM Forum_Response WHERE ForumID = '$forum_ID' ORDER BY $sort_by;";
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
}

echo "<h2>".$forum_Title."</h2>";
echo "<p>".$forum_Description."</p>";
echo "<br><a href='forum2.php'>Back to Forum</a>";
echo "<hr>";

?>
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Your PHP-generated CSS here */
    </style>
</head>
<body>
    <div id="responseContent"></div>
    <script>
        $(document).ready(function() {
            function fetchResponseData() {
                $.ajax({
                    url: 'fetch_response.php',
                    type: 'GET',
                    success: function(data) {
                        $('#responseContent').html(data);
                    },
                    error: function() {
                        $('#responseContent').html('<p>Error loading responses.</p>');
                    }
                });
            }
            fetchResponseData();
        });
    </script>

    <form action='response2.php' method='post'>
        <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
        <button type='submit' name='reply'>Reply</button>
    </form>

    <form action="response2.php" method="get">
        <select name="sort_by">
            <option value="datetime_desc">Datetime Added (Newest to Oldest)</option>
            <option value="datetime_asc">Datetime Added (Oldest to Newest)</option>
            <option value="popularity_desc">Popularity (Most Upvotes)</option>
            <option value="popularity_asc">Popularity (Least Upvotes)</option>
        </select>
        <button type="submit">Sort</button>
    </form>

    <?php
    echo "<hr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<div style='display: flex; align-items: center;'>";
        echo "<div style='margin-right: 10px;'>"; // Left column for voting system
        echo "<form method='post'>";
        // Upvote button
        echo "<button type='submit' name='vote[{$row['ResponseID']}_up]' value='up' style='padding: 5px; spacing: 15px;'>↑</button>";
        echo $row['votes'];
        echo "</form>";
        echo "</div>";
        echo "<div id='Response' style='max-width: 80%;'>"; // Right column for response content
        echo "<h3>{$row['UserID']} • {$row['Datetime']}</h3>";
        echo "<p>{$row['Response']}</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "<hr>";

    if(isset($_POST['reply'])) {
        $responseID = substr(hash('sha256', $_POST['response']), 0, 16);
        $userID = $username;
        $response = $_POST['response'];
        $dateTime = date("Y-m-d H:i:s");
        $vtes = 0;

        $sql = "INSERT INTO Forum_Response VALUES ('$responseID', '$forum_ID', '$userID', '$response', NOW(), $vtes);";
        $result = $conn->query($sql); 

        header("Location: response2.php?forumID=$forum_ID&forumTitle=$forum_Title&forumDescription=$forum_Description");
        exit();

        if($result) {
            header("Location: response2.php?forumID=$forum_ID&forumTitle=$forum_Title&forumDescription=$forum_Description");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vote'])) {
        foreach ($_POST['vote'] as $response_vote => $vote_direction) {
            $responseID = substr($response_vote, 0, -3);
            $vote_type = substr($response_vote, -3);

            if ($vote_direction == 'up') {
                $sql = "UPDATE Forum_Response SET votes = votes + 1 WHERE ResponseID = '$responseID'";
                $result = $conn->query($sql);

                if (!$result) {
                    echo "Error: " . $conn->error;
                }
            }
        }
    }

    header("Location: response2.php?forumID=$forum_ID&sort_by=$sort_by");
    exit();

    if (!$result) {
        echo "Error: " . $conn->error;
    }
    ?>
</body>
<link rel='stylesheet' type='text/css' href='Alumni_Site/index/style/global_style.css'>
<form action='response2.php' method='post'>
    <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
    <button type='submit' name='submit'>Reply</button>
</form>
</html>
