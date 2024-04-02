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

    $stmtUserID->close();
    $conn->close();
}
}
else {
	echo "No User Signed in";
	echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body {
                        overflow: hidden; /* Prevent scrolling */
                    }
                    .overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .overlay-content {
                        text-align: center;
                        background-color: white;
                        padding: 20px;
                        border-radius: 5px;
                    }
                    .overlay-content button {
                        margin: 10px;
                        padding: 10px 20px;
                        background-color: #305A8C; /* Adjust button color as needed */
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                    }
                </style>
            </head>
            <body>
                <div class='overlay'>
                    <div class='overlay-content'>
                        <h2>No User Signed In</h2>
                        <button onclick=\"window.location.href='/Alumni_Site/index/Authentication_Login/login.php'\">Sign In</button>
                        <button onclick=\"window.location.href='/Alumni_Site/index/Authentication_Login/register.php'\">Register</button>
                    </div>
                </div>
            </body>
            </html>";
    exit; // Stop further execution of PHP code
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


        #buttons button {
            padding: 10px 20px;
            background-color: #305A8C;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 0 10px;
    }

        #buttons button:hover {
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

            <!-- Content from first_contact.php (right side) -->
            <div style="width: 30%; display: flex; flex-direction: column; align-items: flex-end;">
<h3> Enter the account email </h3>
<form action="send_request.php" method="post">
    <table>
        <tr>
            <td><label for="accountName">Account Email:</label></td>
            <td><input type="text" id="accountName" name="accountName" required></td>
        </tr>
    </table>
    <button type="submit">Submit</button>
</form>

<?php


if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the sender's username and user ID from sessio
    $senderUsername = $_SESSION['username'];
    echo "Current User : ", $senderUsername;
    echo "FROM HERE DOWN ISSUES WITH CONTACT"; 

    //Working on message, checking for current accepted requests first, will check both the reciever and sender username(email) 
    //So that we can pull any conversation from request_id 
    //$sql = "SELECT sender_username, receiver_name from friend_requests where sender_username = ? or receiver_name = ?";
    //$stmt = $conn->prepare($sql);
    //if ($stmt === false) {
      //  die("Error in preparing the statement: " . $conn->error);
    //}
    //$stmt->bind_param("ss", $currentUser);
   // $stmt->execute();
   // $result = $stmt->get_result();
   // if ($result->num_rows > 0) {
//	    $row = $result->fetch_assoc();
//	    echo "Pass";
   // }
}
?>

            </div>
	</div>
    </div>
    <div id="forum" class="content" style="display: none;">
        <h2>Captain's Dock - Forum Tab</h2>
        <div class="tab" onclick="showTab('showForums')">Forums</div>
        <div class="tab" onclick="showTab('createForums')">Create Forum</div>
        <div id="showForums" class="content" style="display: none;">
            <iframe src="forum2.php" width="100%" height="400px" frameborder="0"></iframe><br>
        </div>
            <div id="createForums" class="content" style="display: none;">                <iframe src="creat_forum.php" width="100%" height="400px" frameborder="0"></iframe><br>
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
    
                // If the Forum tab is selected, show the first contact form by default
                if (tabId === 'showForums') {
                    document.getElementById('showForums').style.display = 'block';
                }
            }
    
        </script>
    </div>

    <div id="calendar" class="content" style="display: none;">
        <h2>Captain's Dock - Calendar Tab</h2>
        <iframe src="../Event_Scheduling/calendar.php" width="100%" height="400px" frameborder="0"></iframe><br>

    </div>

    <div id="profile" class="content" style="display: none;">
        <h2>Captain's Dock - Profile Tab</h2>
        <p>This is the content for the Profile Tab.</p>
	<?php include 'profile_content.php'; ?>
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

