<?php
session_start();

if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get sender's username and ID from session
    $senderUsername = $_SESSION['username'];

    // Get receiver's name and ID from the form submission
    $receiverName = $_POST['accountName'];

    // Retrieve sender's UserID based on the username
    $sqlSender = "SELECT UserID FROM User WHERE email = ?";
    $stmtSender = $conn->prepare($sqlSender);

    if ($stmtSender === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmtSender->bind_param("s", $senderUsername);
    $stmtSender->execute();
    $resultSender = $stmtSender->get_result();

    if ($resultSender->num_rows > 0) {
        $rowSender = $resultSender->fetch_assoc();
        $senderID = $rowSender['UserID'];

        // Insert the request into the database
        $sqlInsert = "INSERT INTO friend_requests (sender_username,  receiver_name) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        
        if ($stmtInsert === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

        $stmtInsert->bind_param("ss", $senderUsername, $senderID, $receiverName, $receiverID);
        $stmtInsert->execute();
        $stmtInsert->close();

        echo "Request sent successfully!";
    } else {
        echo "Error: User not found for the given email/username: $senderUsername";
    }

    $stmtSender->close();
    $conn->close();
} else {
    echo "No user signed in, unable to connect to DB, sign in, or contact DB admin";
}
?>

