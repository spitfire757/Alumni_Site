<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<p>User is not logged in.</p>";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<p>Connection failed: " . $conn->connect_error . "</p>");
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

$messageHistory = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connectionId'], $_POST['message'])) {
    $connectionId = $_POST['connectionId'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (id, message_text) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $connectionId, $message);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error sending message: " . $stmt->error;
    } else {
        echo "<p>Message Sent!</p>";
    }
}

if (isset($_GET['connectionId'])) {
    $connectionId = $_GET['connectionId'];
    $sql = "SELECT message_text FROM messages WHERE id = ? ORDER BY message_text";
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

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Message Center</title>
<link rel="stylesheet" href="test_style.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }
    .main {
        display: flex;
        justify-content: space-around;
        padding: 20px;
        margin-top: 10px; /* Reduced margin-top since header is removed */
    }
    .section {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        width: 23%;
        margin: 1%;
        flex-grow: 1;
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    h3 {
        color: #333;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    select, textarea, input[type="text"] {
        padding: 10px;
        margin-top: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }
    button {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        margin-top: 12px;
        cursor: pointer;
        border-radius: 4px;
        width: 100%;
    }
    button:hover {
        background-color: #218838;
    }
    ul {
        list-style-type: none;
        padding: 0;
    }
    li {
        padding: 8px;
        border-bottom: 1px solid #ccc;
    }
    #historyContent, #friendRequestsContainer {
        display: none;
        width: 100%;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function fetchHistory() {
    var connectionId = $('#historyConnectionId').val();
    if (!connectionId) {
        alert('Please select a connection to view the history.');
        return;
    }

    $.ajax({
        url: 'fetch_history.php',
        type: 'POST',
        data: {'connectionId': connectionId},
        success: function(data) {
            $('#messageList').html(data); // Assuming the server returns formatted HTML
            $('#historyContent').show();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#messageList').html('<li>Error loading messages. Please try again.</li>');
            console.error('Error fetching history:', textStatus, errorThrown);
        }
    });
}

function sendMessage() {
    var connectionId = $('#connectionSelect').val();
    var message = $('#messageText').val();

    if (message.trim() == '') {
        alert('Please enter a message.');
        return; // Prevent sending an empty message
    }

    $.ajax({
        url: 'send_message.php',
        type: 'POST',
        data: {'connectionId': connectionId, 'message': message},
        success: function(data) {
            $('#messageText').val(''); // Clear the message input box
            fetchHistory(); // Refresh the message history view
        },
        error: function() {
            alert('Error sending message.');
        }
    });
}

function toggleVisibility(id) {
    var element = document.getElementById(id);
    element.style.display = (element.style.display === 'none') ? 'block' : 'none';
}
</script>
</head>
<body>
<div class="main">
    <div class="section" id="sendMessageSection">
        <h3>Send a Message:</h3>
        <form id="messageForm">
            <select name="connectionId" id="connectionSelect" required>
                <?php foreach ($connections as $id => $email): ?>
                    <option value="<?= $id; ?>"><?= htmlspecialchars($email); ?></option>
                <?php endforeach; ?>
            </select>
            <textarea name="message" id="messageText" rows="4" required></textarea>
            <button type="button" onclick="sendMessage()">Send</button>
        </form>
    </div>
    <div class="section" id="viewHistorySection">
        <h3>View Message History:</h3>
        <select id="historyConnectionId" required>
            <option value="">Select a Connection...</option>
            <?php foreach ($connections as $id => $email): ?>
                <option value="<?= $id; ?>"><?= htmlspecialchars($email); ?></option>
            <?php endforeach; ?>
        </select>
        <button onclick="fetchHistory()">Fetch History</button>
        <div id="historyContent">
            <h4>History:</h4>
            <ul id="messageList"></ul>
        </div>
    </div>
    <div class="section" id="enterEmailSection">
        <h3>Enter the Account Email</h3>
        <form action="contact.php" method="post">
            <input type="text" id="accountName" name="accountName" required>
            <button type="submit">Submit</button>
        </form>
        <button id="toggleFriendRequestsBtn" onclick="toggleVisibility('friendRequestsContainer')">Toggle Friend Requests</button>
        <div id="friendRequestsContainer">
            <iframe id="friendRequestsFrame" src="view_requests.php" style="width:100%; height:150px;"></iframe>
        </div>
    </div>
    <div class="section" id="toggleConnectionsSection">
        <h3>Toggle Connections</h3>
        <button onclick="toggleVisibility('connectionsContainer')">Connections</button>
        <div id="connectionsContainer" style="display:none;">
            <ul>
                <?php foreach ($connections as $connection): ?>
                    <li><?= htmlspecialchars($connection); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

