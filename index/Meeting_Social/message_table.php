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
    echo "Current User: ",  $_SESSION['username'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $senderUsername = $_SESSION['username'];
        $receiverFname = $_POST['receiver_fname'];
        $receiverLname = $_POST['receiver_lname'];

        // Retrieve signed-in user's ID
        $sqlUserID = "SELECT UserID FROM User WHERE Fname = ?";
        $stmtUserID = $conn->prepare($sqlUserID);

        if ($stmtUserID === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

        $stmtUserID->bind_param("s", $senderUsername);
        $stmtUserID->execute();
        $resultUserID = $stmtUserID->get_result();

        if ($resultUserID->num_rows > 0) {
            $rowUserID = $resultUserID->fetch_assoc();
            $user1ID = $rowUserID['UserID'];

            // Check if there is an accepted friend request between User_1 and User_2
            $sqlFriendRequest = "SELECT * FROM friend_requests WHERE sender_username = ? AND status = 'accepted'";
            $stmtFriendRequest = $conn->prepare($sqlFriendRequest);

            if ($stmtFriendRequest === false) {
                die("Error in preparing the statement: " . $conn->error);
            }

            $stmtFriendRequest->bind_param("s", $senderUsername);
            $stmtFriendRequest->execute();
            $resultFriendRequest = $stmtFriendRequest->get_result();

            while ($rowFriendRequest = $resultFriendRequest->fetch_assoc()) {
                $receiverID = $rowFriendRequest['receiver_id'];

                // Check if the provided friend matches a row in the friend_requests table
                if ($receiverID === $user1ID) {
                    $user2ID = $rowFriendRequest['receiver_id'];

                    // Store the message in the message table
                    $user1Message = $_POST['user1_message'];
                    $user2Message = $_POST['user2_message'];

                    $sqlInsertMessage = "INSERT INTO messages (User_1, User_2, User_1_message, User_2_message) VALUES (?, ?, ?, ?)";
                    $stmtInsertMessage = $conn->prepare($sqlInsertMessage);

                    if ($stmtInsertMessage === false) {
                        die("Error in preparing the statement: " . $conn->error);
                    }

                    $stmtInsertMessage->bind_param("iiss", $user1ID, $user2ID, $user1Message, $user2Message);
                    $stmtInsertMessage->execute();
                    $stmtInsertMessage->close();

                    echo "Message sent successfully!";
                } else {
                    echo "The friend request is not accepted or the provided friend does not match the friend request.";
                }
            }

            $stmtFriendRequest->close();
        } else {
            echo "User not found with the provided username.";
        }

        $stmtUserID->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Message to Friend</title>
</head>
<body>

<h2>Submit Message to Friend</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="receiver_fname">Friend's First Name:</label>
    <input type="text" name="receiver_fname" required>
    <br>

    <label for="receiver_lname">Friend's Last Name:</label>
    <input type="text" name="receiver_lname" required>
    <br>

    <label for="user1_message">Your Message:</label>
    <textarea name="user1_message" required></textarea>
    <br>

    <label for="user2_message">Friend's Response:</label>
    <textarea name="user2_message" required></textarea>
    <br>

    <button type="submit">Submit Message</button>
</form>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

