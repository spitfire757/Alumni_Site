<!DOCTYPE html>
<html lang="en">
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
            <form action="request.php" method="post">
                <table>
                    <tr>
                        <td><label for="accountName">Account Name:</label></td>
                        <td><input type="text" id="accountName" name="accountName" required></td>
                    </tr>
                    <tr>
                        <td><label for="accountID">Account ID:</label></td>
                        <td><input type="text" id="accountID" name="accountID" required></td>
                    </tr>
                </table>
                <button type="submit">Submit</button>
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

</body>
</html>



<?php
session_start();
    if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Current User : ",  $_SESSION['username'];
    echo "Here you can request to message certain accounts";
      


    }
    // Between here and the else statement will be executed if a user is signed in
    //
    //
    //
    //
    // Dont edit anything below for now
    else{
	    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
    }
    return $conn;
?>
</html>
