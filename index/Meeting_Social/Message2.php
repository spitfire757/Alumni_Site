<!DOCTYPE html>
<html lang="en">

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

    $receiverUsername = $_SESSION['username'];

    // Query pending friend requests
    $sql = "SELECT * FROM friend_requests WHERE receiver_name = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $receiverUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Pending Friend Requests</h2>";
    echo "<ul>";

    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['sender_username']} wants to connect. <a href='accept_request.php?request_id={$row['request_id']}'>Accept</a></li>";
    }

    echo "</ul>";

    $stmt->close();
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .tabs {
            display: flex;
            background-color: #305A8C; /* Updated color code, feel free to change it*/
            color: white;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
        }

        .tab:hover {
            background-color: #2A4C7D;
        }

        .content {
            padding: 20px;
        }

        .buttons {
            margin-top: 20px;
            display: none; 
            justify-content: center;
        }

        .button {
            padding: 10px 20px;
            background-color: #305A8C;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #2A4C7D;
        }

        /* Style for input and textarea */
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }
    </style>
    <title>Captain's Dock</title>
</head>
<body>

    <div class="tabs">
        <div class="tab" onclick="showTab('home')">Home</div>
        <div class="tab" onclick="showTab('helppage')">Help Page</div>
        <div class="tab" onclick="showTab('messages')">Messages</div>
        <div class="tab" onclick="showTab('forum')">Forum</div>
        <div class="tab" onclick="showTab('calendar')">Calendar</div>
        <div class="tab" onclick="showTab('profile')">Profile</div>
    </div>

    <div id="home" class="content">
        <h2>Welcome to the Captain's Dock - Home Page</h2>
        <p>This is the content for the Home Page tab.</p>
    </div>

    <div id="helppage" class="content" style="display: none;">
        <h2>Captain's Dock - Help Page Tab</h2>
        <p>This is the content for the Help Page Tab.</p>
    </div>

    <div id="messages" class="content" style="display: none;">
        <h2>Captain's Dock - Messages Tab</h2>
        <p>This is the content for the Messages Tab.</p>
        <div id="firstContactForm" class="content" style="display: none;">
            <h3>Who are you trying to reach?</h3>
            <form>
                <label for="firstName">First Name:</label><br>
                <input type="text" id="firstName" name="firstName" required><br>
                <label for="lastName">Last Name:</label><br>
                <input type="text" id="lastName" name="lastName" required><br>
                <label for="ID">ID:</label><br>
                <input type="text" id="ID" name="ID" required><br><br>
                <label for="message">Enter Message:</label><br>
                <textarea id="message" name="message" rows="4" required></textarea><br><br>
                <button class="button" type="submit">Send</button>
            </form>
        </div>

        <div id="messagingForm" class="content" style="display: none;">
            <h3>Who are you trying to contact?</h3>
            <form>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" required><br><br>
                <label for="message">Enter Message:</label><br>
                <textarea id="message" name="message" rows="4" required></textarea><br><br>
                <button class="button" type="submit">Send</button>
            </form>
        </div>
    </div>

    <div id="forum" class="content" style="display: none;">
        <h2>Captain's Dock - Forum Tab</h2>
        <p>This is the content for the Forum Tab.</p>
    </div>

    <div id="calendar" class="content" style="display: none;">
        <h2>Captain's Dock - Calendar Tab</h2>
        <p>This is the content for the Calendar Tab.</p>
    </div>

    <div id="profile" class="content" style="display: none;">
        <h2>Captain's Dock - Profile Tab</h2>
        <p>This is the content for the Profile Tab.</p>
    </div>
    <!-- Inside message.php -->
    <a href="view_requests.php">View Friend Requests</a>

    <script>
        function showTab(tabId) {
            // Hide all tabs
            var tabs = document.getElementsByClassName('content');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = 'none';
            }

            // Show the selected tab
            document.getElementById(tabId).style.display = 'block';

            // If the Messages tab is selected, show the first contact form by default
            if (tabId === 'messages') {
                document.getElementById('firstContactForm').style.display = 'block';
            }
        }
    </script>
</html>

