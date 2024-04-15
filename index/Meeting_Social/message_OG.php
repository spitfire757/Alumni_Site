<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "User is not logged in.";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentUserEmail = $_SESSION['username'];

$sql = "SELECT id, user_1, user_2 FROM load_contacts WHERE user_1 = ? OR user_2 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentUserEmail, $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();



// Grab user connections 
$connections = [];
while ($row = $result->fetch_assoc()) {
    $connections[$row['id']] = $row['user_1'] == $currentUserEmail ? $row['user_2'] : $row['user_1'];
}


// Grab message history please work 
$messageHistory = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['connectionId'], $_POST['message'])) {
        $connectionId = $_POST['connectionId'];
        $message = $_POST['message'];

        $sql = "INSERT INTO messages (id, message_text) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $connectionId, $message);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error sending message: " . $stmt->error;
        } else {
            echo "Message sent successfully!";
        }
    }
}

// Fetching message history for the selected connection
    if (isset($_POST['connectionId'])) {
        $connectionId = $_POST['connectionId'];
        $sql = "SELECT message_text FROM messages WHERE id = ? ORDER BY message_text"; // Assuming the `message_text` column should be used for ordering
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $connectionId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $messageHistory[] = $row['message_text'];
        }
    }







$stmt->close();
$conn->close();
?>

<h2>Captain's Dock - Messages Tab</h2>
<div style="display: flex;">
    <div id="firstContactForm" style="width: 60%; margin-right: 20px;">
        <h3>Send a Message:</h3>
        <form method="post">
            <select name="connectionId" required>
                <?php foreach ($connections as $id => $email): ?>
                    <option value="<?= $id; ?>"><?= htmlspecialchars($email); ?></option>
                <?php endforeach; ?>
            </select><br>
            <textarea name="message" rows="4" required></textarea><br>
            <button type="submit">Send</button>
        </form>
    </div>



 <!-- Toggle connections and display them -->
    <div style="width: 30%; display: flex; flex-direction: column; align-items: flex-end;">
        <button id="toggleConnectionsBtn" onclick="toggleConnections()">Toggle Connections</button>
        <div id="connectionsContainer" style="display:none;">
            <h3>Your Connections:</h3>
            <?php
            if (!empty($connections)) {
                echo "<ul>";
                foreach ($connections as $connection) {
                    echo "<li>" . htmlspecialchars($connection) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No connections to display.</p>";
            }
            ?>
        </div>
    </div>



<script>
    function toggleConnections() {
        var container = document.getElementById('connectionsContainer');
        container.style.display = container.style.display === 'none' ? 'block' : 'none';
    }



</script>

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
