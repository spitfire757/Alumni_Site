<!DOCTYPE html>
<html lang="en">


<?php
session_start();

$pendingRequests = array(); // Initialize an empty array to store pending requests

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
    echo $receiverUsername;

    // Retrieve user ID from the current user's username
    $sqlUserID = "SELECT UserID FROM User WHERE email = ?";
    $stmtUserID = $conn->prepare($sqlUserID);

    if ($stmtUserID === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmtUserID->bind_param("s", $receiverUsername);
    $stmtUserID->execute();
    $resultUserID = $stmtUserID->get_result();

    if ($resultUserID->num_rows > 0) {
        $rowUserID = $resultUserID->fetch_assoc();
        $userID = $rowUserID['UserID'];

        // Check if the username or user ID is in any row of the friend_requests table
        $sqlCheckRequests = "SELECT * FROM friend_requests WHERE (sender_username = ? OR sender_id = ? OR receiver_name = ? OR receiver_id = ?) AND status = 'pending'";
        $stmtCheckRequests = $conn->prepare($sqlCheckRequests);

        if ($stmtCheckRequests === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

    } else {
        echo "User not found with the provided username.";
    }

    $stmtUserID->close();
    $conn->close();
}

// Print out the pending requests
echo "<h2>Pending Friend Requests:</h2>";
echo "<ul>";
foreach ($pendingRequests as $request) {
    echo "<li>";
    echo "Sender: " . $request['sender_username'] . " (ID: " . $request['sender_id'] . ")";
    echo "</li>";
}
echo "</ul>";
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
                <label for="firstName">Email (Username):</label><br>
                <input type="text" id="username" name="Email (Username)" required><br>
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

