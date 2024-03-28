<!DOCTYPE html>
<html>
<body>
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

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Forum_Response WHERE ForumID = '$forum_ID' ORDER BY Datetime ASC;";
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
}

// Display forum title and description
echo "<h2>".$forum_Title."</h2>";
echo "<p>".$forum_Description."</p>";
echo "<br><a href='forum3.php'>Back to Forum</a>";
echo "<hr>";

// Display forum responses
while ($row = $result->fetch_assoc()) {
    echo "<div class='response'>";
    echo "<h3>{$row['UserID']}</h3>";
    echo "<p>{$row['Response']}</p>";
    echo "<p class='description'>{$row['Description']}</p>";
    echo "</div>";
}

echo "<hr>";

// If the form is submitted, add the content to the Forum_Response table
if(isset($_POST['submit'])) {
    $responseID = substr(hash('sha256', $_POST['response']), 0, 16);
    $userID = $_POST['userID'];
    $response = $_POST['response'];
    $description = $_POST['description'];
    $dateTime = date("Y-m-d H:i:s");

    // Insert the response into Forum_Response table
    $sql = "INSERT INTO Forum_Response (ResponseID, ForumID, UserID, Response, Description, DateTime) VALUES ('$responseID', '$forum_ID', '$userID', '$response', '$description', NOW())";
    $result = $conn->query($sql); 

    // Check if the insert was successful
    if($result) {
        // Redirect to refresh the page
        header("Location: response3.php?forumID=$forum_ID&forumTitle=$forum_Title&forumDescription=$forum_Description");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>
<link rel='stylesheet' type='text/css' href='Alumni_Site/index/style/global_style.css'>
<form action='response3.php' method='post'>
    <input type='text' name='userID' placeholder='userID' maxlength='64'><br>
    <input type='text' name='response' placeholder='Response' maxlength='255'><br>
    <textarea name='description' placeholder='Description' rows='4' cols='50' maxlength='255'></textarea><br>    
    <button type='submit' name='submit'>Reply</button>
</form>
</body>
</html>
