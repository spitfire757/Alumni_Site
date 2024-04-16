<?php
#if (isset($_SESSION['username'])) {
    // Connect to SQL Database
    session_start();

    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $username = $_SESSION['username'];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #ccc;
        }
        h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <hr>
    <h3>Create Forum</h3>
    <a href="forum2.php">Return to PCSE Forum</a>
    <form action='create_forum.php' method='post'>
        <input type='text' name='title' placeholder='Title' maxlength='64'><br>
        <textarea name='description' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
        <button type='submit' name='reply'>Reply</button>
    </form>
    <hr>
    <?php
    if(isset($_POST['reply'])) {
        $forumID = substr(hash('sha256', $_POST['title']), 0, 16);
        $userID = $_SESSION['username'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $dateTime = date("Y-m-d H:i:s");

        // Insert the response into Forum table
        $sql = "INSERT INTO Forum VALUES ('$forumID', '$userID', '$description', '$title', NOW());";
        $result = $conn->query($sql); 

        // Check if the insert was successful
        if($result) {
            // Redirect to refresh the page
            header("Location: forum2.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } 
#}
?>
