<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
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
input[type="text"], textarea {
    width: 50%;
height: 40px;
    padding: 10px;
    margin: 5px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
}

input[type="date"] {
    width: 8%;
    height: 20px;
    padding: 10px;
    margin: 5px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
}
    </style>
    <link rel="stylesheet" href="../style/global_style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>

<body>
<div>
    <nav>
        <table>
            <tr>
                <td>
                    <a href = "../Interface/help.php">Help</a>
                </td>
                <td>
                    <a href = "../Meeting_Social/message.php">Message</a>
                </td>
                <td>
                    <a href = "../Meeting_Social/forum.php">Forum</a>
                </td>
                <td>
                    <a href = "calendar.php">Calendar</a>
                </td>
                <td>
                    <a href = "../Authentication_Login/profile.php">Profile</a>
                </td>
            </tr>
        </table>
    </nav>
</div>
    <br>

    <h3>Create an Event</h3>
    <form action="calendar.php" method="POST">
        <label for="datepicker">Enter the date of your event:<br></label>
        <input type="date" id="datepicker" name="date" required><br>
        <label for="time"><br>Enter the time of your event:<br></label>
        <input type="time" id="time" name="time" required><br>
        <label for="bio"><br>Enter event description:<br></label>
        <input type="text" id="bio" name="bio" required><br>
        <input type="submit" value="Create">
    </form>
</body>
</html>

<?php
   

        
?>
