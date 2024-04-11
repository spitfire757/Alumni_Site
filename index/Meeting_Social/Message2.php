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
        $sqlCheckRequests = "SELECT * FROM friend_requests WHERE (sender_username = ? OR receiver_name = ?) AND status = 'pending'";
        $stmtCheckRequests = $conn->prepare($sqlCheckRequests);

        if ($stmtCheckRequests === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

    } else {
        echo "User not found";

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
    <link href = "Alumni_Site/index/style/cnu_style.css"></link>
    <div class="tabs">
        <div class="tab" onclick="showTab('home')">Home</div>
        <div class="tab" onclick="showTab('helppage')">Help Page</div>
        <div class="tab" onclick="showTab('messages')">Messages</div>
        <div class="tab" onclick="showTab('forum')">Forum</div>
        <div class="tab" onclick="showTab('calendar')">Calendar</div>
        <div class="tab" onclick="showTab('profile')">Profile</div>
	<div class="tab" onclick="showTab('search')">Search</div>
    </div>
    <!--
    <div id="home" class="content">
        <img src="../images/christopher-newport-university-jerry-gammon.jpeg" height= "200px">
        <h2>Captain's Dock</h2>
        <p>"Welcome to Captains Dock, the vibrant hub for Christopher Newport University alumni! Here, you'll connect with fellow Captains, explore career opportunities, and stay updated on all things CNU. Engage in meaningful discussions, mentorship programs, and alumni events tailored to your interests. Join us in celebrating the legacy of excellence and camaraderie that defines our beloved CNU community. Dive into Captains Dock today and embark on an exciting journey of networking, growth, and lifelong connections."</p>
        <table>
            <tr>
                <td>
                <iframe src="../Event_Scheduling/calendar.php" width="100%" height="200px" frameborder="0"></iframe><br>
            </tr>
            <tr>
                <td>
                <iframe src="search.php" width="100%" height="200px" frameborder="0"></iframe><br>
            </tr>
            <tr>
                <td>
                    <h2>PCSE Instagram</h2>
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/cnupcse/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:16px;"> <a href="https://www.instagram.com/cnupcse/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank"> <div style=" display: flex; flex-direction: row; align-items: center;"> <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div></div></div><div style="padding: 19% 0;"></div> <div style="display:block; height:50px; margin:0 auto 12px; width:50px;"><svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-511.000000, -20.000000)" fill="#000000"><g><path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path></g></g></g></svg></div><div style="padding-top: 8px;"> <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this profile on Instagram</div></div><div style="padding: 12.5% 0;"></div> <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;"><div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div> <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div> <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div></div><div style="margin-left: 8px;"> <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div> <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div></div><div style="margin-left: auto;"> <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div> <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div> <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div></div></div> <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;"> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div> <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div></div></a><p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/cnupcse/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">PCSE at CNU</a> (@<a href="https://www.instagram.com/cnupcse/?utm_source=ig_embed&amp;utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">cnupcse</a>) • Instagram photos and videos</p></div></blockquote> <script async src="//www.instagram.com/embed.js"></script>
                </td>
                <td>
                    <h2>PCSE LinkedIn</h2>
                    <iframe src="https://www.linkedin.com/embed/feed/update/urn:li:share:7112093059823116290" height="707" width="504" frameborder="0" allowfullscreen="" title="Embedded post"></iframe>
                </td>
            </tr>
        </table>
    </div>
-->
<div id="home" class="content" style="font-family: Trajan Pro, sans-serif; display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <img src="../images/christopher-newport-university-jerry-gammon.jpeg" height="400px" style="margin-bottom: 20px;">
    <h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0;">Captain's Dock</h2>
    <p style="font-size: 1rem; margin-bottom: 20px;">Welcome to Captains Dock, the vibrant hub for Christopher Newport University alumni! Here, you'll connect with fellow Captains, explore career opportunities, and stay updated on all things CNU. Engage in meaningful discussions, mentorship programs, and alumni events tailored to your interests. Join us in celebrating the legacy of excellence and camaraderie that defines our beloved CNU community. Dive into Captains Dock today and embark on an exciting journey of networking, growth, and lifelong connections.</p>
    <table style="margin-bottom: 20px;">
        <tr>
            <td>
                <iframe src="../Event_Scheduling/calendar.php" width="100%" height="200px" frameborder="0" style="border: none;"></iframe>
            </td>
        </tr>
        <tr>
            <td>
                <h2 style="font-size: 1.5rem; font-weight: bold; margin-top: 20px; text-align: center;">PCSE Instagram</h2>
                <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/cnupcse/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                    <!-- Instagram Embed Code -->
                </blockquote>
                <script async src="//www.instagram.com/embed.js"></script>
           
                <h2 style="font-size: 1.5rem; font-weight: bold; margin-top: 20px; text-align: center;">PCSE LinkedIn</h2>
                <iframe src="https://www.linkedin.com/embed/feed/update/urn:li:share:7112093059823116290" height="707" width="504" frameborder="0" allowfullscreen="" title="Embedded post" style="border: none;"></iframe>
            </td>
        </tr>
    </table>
</div>


    <div id="helppage" class="content" style="display: none;">
        <h2>Captain's Dock - Help Page Tab</h2>
<iframe src="help.php" width="100%" height="800px" frameborder="0"></iframe><br>
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
		<?php include 'message_app.php'; ?>
                </div>
    <!-- </div> !>




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
    // <-- WORKING 4/1/2024 --> 
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
        <iframe src="forum2.php" width="100%" height="800px" frameborder="0"></iframe><br>
    </div>

    <div id="calendar" class="content" style="display: none;">
        <h2>Captain's Dock - Calendar Tab</h2>
        <iframe src="../Event_Scheduling/calendar.php" width="100%" height="800px" frameborder="0"></iframe><br>

    </div>


  <div id="search" class="content" style="display: none;">
        <h2>Welcome to the Captain's Dock - Connect Page</h2>
        <p>This is the content for the connect  Page tab.</p>
        <iframe src="search.php" width="100%" height="800px" frameborder="0"></iframe><br>
    </div>


    <div id="profile" class="content" style="display: none;">
        <h2>Captain's Dock - Profile Tab</h2>
        <p>This is the content for the Profile Tab.</p>
	<?php include 'profile_content.php'; ?>
    </div>

<<<<<<< HEAD
    <div id="connect" class="content" style="display: none;">
        <h2>Captain's Dock - Connect Tab</h2>
        <p>This is the content for the Connect Tab.</p>
        <?php include 'profile_content.php'; ?>
    </div>
=======



>>>>>>> f485150ebb05964eca08dff6b3a38ac9d5b4d81d

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

