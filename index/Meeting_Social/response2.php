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

// If the form is submitted, add the content to the Forum_Response table
if(isset($_POST['submit'])) {
    $responseID = substr(hash('sha256',$response),0,16);
    $userID = $_POST['userID'];
    $response = $_POST['response'];
    $dateTime = date("m-d-Y H:i:s");

    // Insert the response into Forum_Response table
    $sql = "INSERT INTO Forum_Response VALUES ('$responseID', '$forum_ID', '$userID', '$response', NOW());";
    echo $sql;
    $result = $conn->query($sql); 
}

// Fetch data from Response Table for the selected forum
$query = "SELECT * FROM Forum_Response WHERE ForumID = 'qwerty';";
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
}

// Display forum title and description
echo "<h2>".$forum_Title."</h2><br>";
echo $forum_Description;
echo "<hr>";

echo "<form aciton = 'response2.php' method='post'>
      <input type='text' name='userID' placeholder='userID' maxlength='64'><br>
      <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
      <button type = 'submit' name = 'submit' formaction='response2.php'>Reply</button>
      </form>";

echo "<hr>";

// Display forum responses
while ($row = $result->fetch_assoc()) {
    echo "<h3>{$row['UserID']} • {$row['Datetime']}</h3>";
    echo "<p>{$row['Response']}</p>";
    echo "<br>";
}

echo "<a href='forum.html'>Back to Forum</a>";
