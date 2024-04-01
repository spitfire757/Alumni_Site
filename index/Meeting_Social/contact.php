<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the currently signed-in user
    $senderUsername = $_SESSION['username'];

    // Retrieve the email submitted in the form
    $receiverEmail = $_POST['accountName'];

    // Connect to the database
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to check if the specified email exists in the "User" table
    $sql = "SELECT * FROM User WHERE email = '$receiverEmail'";
    $result = $conn->query($sql);

    // Check if there are any matching rows
    if ($result->num_rows > 0) {
        // Fetch the matching user's data
        $row = $result->fetch_assoc();
        $receiverUsername = $row['email'];

        // Insert friend request into the "friend_request" table
        $insertSql = "INSERT INTO friend_requests (sender_username, receiver_name)
                      VALUES ('$senderUsername', '$receiverUsername')";
        if ($conn->query($insertSql) === TRUE) {
            echo "<p>Friend request sent to $receiverUsername ($receiverEmail).</p>";
        } else {
            echo "<p>Error sending friend request: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>No matching user found for email: $receiverEmail.</p>";
    }

    // Close the database connection
    $conn->close();
}
?>


