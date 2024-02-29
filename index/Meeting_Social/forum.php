<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <div>
                <!-- Loading content onto the page from the DB -->
                <?php
                    session_start();
                    #include 'connect.php';
                    #After you get the DB to output dummy data, try moving this into the connect.php file
                    $servername = "localhost";
                    $username = "mysql_user";
                    $password = "r00tpassw0rd/";
                    $dbname = "DB";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    $sql = "SELECT * FROM Forum WHERE ForumID = 'qwerty'";
                    $query = mysqli_query($conn, $sql);
                    $forum = mysqli_fetch_assoc($query)
                ?>
            <!-- Form for the forum -->
            </div>
            <form action = "forum.php" method = "post">
                    <!-- This should load the content when selected -->
                    <select name = "thread">
                        <option value="start"><?php echo isset($_SESSION["thread"]) ? $_SESSION["thread"] : ""; ?></option>
                        <option value="default">Select a Thread</option>
                        <option value="<?php echo $forum["ForumID"]; ?>"><?php echo $forum["Title"]; ?></option>
                        <option value="testing">Testing</option>
                    </select>
                    <button type = "submit" name = "refresh" formaction="forum.php">Go</button><br>
     
                    <h2><?php echo $forum["Title"];?></h2>
                    <h3><?php echo $forum["userID"];?></h3>
                    <p><?php echo $forum["Description"];?></p>
                    <input type="text" name="userID" placeholder="userID" maxlength="64"><br>
                    <textarea id="response" name="response" placeholder="Insert Your Response Here" rows="4" cols="50" maxlength="255"></textarea><br>                  
                    <button type = "submit" name = "submit" formaction="forum.php" required>Reply</button><br>      
            </form>
            <?php
                if (isset($_POST['submit'])) {

                    # Get the elements needed for a new response
                    $userID = $_POST['userID'];
                    $response = $_POST['response'];
                    $dateTime = date("d-m-Y h:i:s");
                    $responseID = substr(hash('sha256',$response),0,32);
                    $forumID = $forum["ForumID"];
                    
                    # Add Response to Response Table
                    $sql = "INSERT INTO Forum_Response VALUES ($responseID,$forumID,$userID,$response,$dateTime);";
                    $query = mysqli_query($conn, $sql);

                    $_POST['userID'] = "";
                    $_POST['response'] = "";
                }
                
            ?>
        </div>
    </body>
</html>
