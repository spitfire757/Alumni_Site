<?php
// Check if user is logged in
if (isset($_SESSION['username'])) {
    $currentUserEmail = $_SESSION['username'];
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch connections from the database
    $sql = "SELECT * FROM load_contacts WHERE user_1 = '$currentUserEmail' OR user_2 = '$currentUserEmail'";
    $result = $conn->query($sql);

    $connections = array();

    // Check if there are rows returned
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add the connection to the list if the current user's email is in it
                if ($row['user_1'] == $currentUserEmail || $row['user_2'] == $currentUserEmail) {
                    $connections[] = $row;
                }
            }
        } else {
            echo "No connections found.";
        }
        // Free result set
        $result->free();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
} else {
    echo "User is not logged in.";
}

// Handle sending messages
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['recipient_email']) && isset($_POST['message_text'])) {
        $recipientEmail = $_POST['recipient_email'];
        $messageText = $_POST['message_text'];

        // Check if recipient is a connection
        $isConnection = false;
        foreach ($connections as $connection) {
            if ($connection['user_1'] == $recipientEmail || $connection['user_2'] == $recipientEmail) {
                $isConnection = true;
                $connectionId = $connection['id'];
                break;
            }
        }

        if ($isConnection) {
            // Insert message into messages table
            $sqlInsertMessage = "INSERT INTO messages (id, message_text) VALUES ('$connectionId', '$messageText')";
            if ($conn->query($sqlInsertMessage) === TRUE) {
                echo "Message sent successfully.";
            } else {
                echo "Error: " . $sqlInsertMessage . "<br>" . $conn->error;
            }
        } else {
            echo "Recipient is not in your connections list.";
        }
    }
}
?>

<h2>Captain's Dock - Messages Tab</h2>
<p>This is the content for the Messages Tab.</p>
<div style="display: flex;">
    <!-- Message box area (left side) -->
    <div id="firstContactForm" style="width: 60%; margin-right: 20px;">
        <h3>Who are you trying to reach?</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="recipient_email">Recipient Email:</label><br>
            <input type="text" id="recipient_email" name="recipient_email" required><br>
            <label for="message_text">Enter Message:</label><br>
            <textarea id="message_text" name="message_text" rows="4" required></textarea><br><br>
            <button class="button" type="submit">Send</button>
        </form>
             <?php
        // Display connections
        if (!empty($connections)) {
            echo "<h3>Your Connections:</h3>";
            echo "<ul>";
            foreach ($connections as $connection) {
                $id = $connection['id']; // Get the ID associated with the connection
                // Determine the email of the other user in the connection
                $otherUserEmail = ($connection['user_1'] == $currentUserEmail) ? $connection['user_2'] : $connection['user_1'];

                // Fetch first and last name associated with the email
                $sqlName = "SELECT Fname, LName FROM User WHERE email = '$otherUserEmail'";
                $resultName = $conn->query($sqlName);
                if ($resultName->num_rows > 0) {
                    $rowName = $resultName->fetch_assoc();
                    $firstName = $rowName['Fname'];
                    $lastName = $rowName['LName'];
                } else {
                    $firstName = "Unknown";
                    $lastName = "Unknown";
                }

                // Display email, associated first and last names, and the ID
                echo "<li>ID: $id - Email: $otherUserEmail - Name: $firstName $lastName</li>";
            }
            echo "</ul>";
        }
	?>
        <!-- Display message history -->
        <?php
        if ($isConnection) {
            echo "<h3>Message History:</h3>";
            echo "<ul>";
            // Fetch message history for the connection
            $sqlMessageHistory = "SELECT * FROM messages WHERE id = '$connectionId'";
            $resultMessageHistory = $conn->query($sqlMessageHistory);
            if ($resultMessageHistory->num_rows > 0) {
                while ($rowMessage = $resultMessageHistory->fetch_assoc()) {
                    echo "<li>" . $rowMessage['message_text'] . "</li>";
                }
            } else {
                echo "No message history.";
            }
            echo "</ul>";
        }
        ?>
    </div>

    <!-- Content from first_contact.php (right side) -->
    <div style="width: 30%; display: flex; flex-direction: column; align-items: flex-end;">
        <h3> Enter the account email </h3>
        <form action="contact.php" method="post">
            <table>
                <tr>
                    <td><label for="accountName">Account Email:</label></td>
                    <td><input type="text" id="accountName" name="accountName" required></td>
                </tr>
            </table>
            <button type="submit">Submit</button>
        </form>
        <!-- Inside message.php -->
	<button id="toggleFriendRequestsBtn" onclick="toggleFriendRequests()">Toggle Friend Requests</button>
<div id="friendRequestsContainer" style="display:none;">
    <iframe id="friendRequestsFrame" src="view_requests.php"></iframe>
</div>

<script>
    function toggleFriendRequests() {
        var container = document.getElementById('friendRequestsContainer');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }
</script>    
</div>
</div>


