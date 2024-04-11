<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../style/global_style.css">
    <style>
        
input[type="text"], textarea {
    width: 50%;
    height: 40px;
    padding: 10px;
    margin: 5px auto;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
}

input[type="date"] {
    width: 8%;
    height: 20px;
    padding: 10px;
    margin: 5px auto;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: none;
}
    </style>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>

<body>

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
<p style="text-align:center"><a href="calendar.php">Cancel Event Creation</a></p>
</body>
</html>

<?php
   

        
?>
