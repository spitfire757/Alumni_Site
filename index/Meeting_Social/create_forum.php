<?php
echo "this is create_forum";
#if (isset($_SESSION['username'])) {
    // Connect to SQL Database
    session_start();

    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";
    ?>
    <form action='creat_forum.php' method='post'>
        <input type='text' name='title' placeholder='Title' maxlength='64'><br>
        <textarea name='description' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
        <button type='submit' name='submit'>Reply</button>
    </form>
    <?php
    if(isset($_POST['submit'])) {
        $forumID = substr(hash('sha256', $_POST['title']), 0, 16);
        $userID = $_SESSION['username'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $dateTime = date("Y-m-d H:i:s");

        // Insert the response into Forum table
        $sql = "INSERT INTO Forum VALUES ('$forumID', '$userID', '$title', '$description',NOW());";
        $result = $conn->query($sql); 

        // Check if the insert was successful [this section was generated by ChatGPT to help with functionality]
        if($result) {
            // Redirect to refresh the page
            header("Location: response2.php?forumID=$forum_ID&forumTitle=$forum_Title&forumDescription=$forum_Description");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
#}
?>
