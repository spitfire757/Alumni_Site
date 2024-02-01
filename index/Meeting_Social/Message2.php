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
            background-color: #305A8C; /* Updated color code */
            color: white;
        }

        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
        }

        .tab:hover {
            background-color: #2A4C7D; /* Adjusted color on hover if needed */
        }

        .content {
            padding: 20px;
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

    <div class="buttons">
        <button class="button" onclick="goToPage('firstContact')">First Contact</button>
        <button class="button" onclick="goToPage('messaging')">Messaging</button>
    </div>

    <div id="helppage" class="content" style="display: none;">
        <h2>Captain's Dock - Help Page Tab</h2>
        <p>This is the content for the Help Page Tab.</p>
    </div>

    <div id="messages" class="content" style="display: none;">
        <h2>Captain's Dock - Messages Tab</h2>
        <p>This is the content for the Messages Tab.</p>
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
        }
    </script>

</body>
</html>
