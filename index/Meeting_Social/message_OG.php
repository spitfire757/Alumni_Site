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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentUserEmail = $_SESSION['username'];

// Fetch connections from the database
$sql = "SELECT * FROM load_contacts WHERE user_1 = ? OR user_2 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentUserEmail, $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();

$connections = array();

// Check if there are rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['user_1'] == $currentUserEmail) {
            $connections[] = $row['user_2'];
        } else {
            $connections[] = $row['user_1'];
        }
    }
} else {
    echo "No connections found.";
}
$stmt->close();
$conn->close();
?>

<h2>Captain's Dock - Messages Tab</h2>
<p>This is the content for the Messages Tab.</p>
<div style="display: flex;">
    <!-- Message box area (left side) -->
	<div id="firstContactForm" style="width: 60%; margin-right: 20px;">
        <h3>Who are you trying to reach?</h3>
        <form>
            <label for="firstName">Email (Username):</label><br>
            <input type="text" id="username" name="Email (Username)" required><br>
            <label for="message">Enter Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>
            <button class="button" type="submit">Send</button>
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
