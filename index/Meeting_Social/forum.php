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
                        <?php
                            echo "<option value='start'>".$_SESSION["thread"]."</option>";
                            echo "<option value='default'>Select a Thread</option>";
                            echo "<option value=".$forum["ForumID"].">".$forum["Title"]."</option>";
                            echo "<option value='testing'>Testing</option>";
                        ?>
                    </select>
                    <button type = "submit" name = "refresh" formaction="forum.php">Go</button><br>
     
                    <h2><?php echo $forum["Title"];?></h2>
                    <h3><?php echo $forum["userID"];?></h3>
                    <p><?php echo $forum["Description"];?></p>
                    <input type="text" name="userID" placeholder="userID" maxlength="64" required><br>
                    <textarea id="response" name="response" placeholder="Insert Your Response Here" rows="4" cols="50" maxlength="255" required></textarea><br>                  
                    <button type = "submit" name = "submit" formaction="forum.php" required>Reply</button><br>      
            </form>
            <?php
                if (isset($_POST['submit'])) {
                    $userID = $_POST['userID'];
                    $response = $_POST['response'];

                    echo $userID;
                    echo $response;

                    $currentDateTime = date("Y-m-d H:i:s");
                    echo $currentDateTime;

                    
                    $_POST['userID'] = "";
                    $_POST['response'] = "";
                }
                
            ?>
        </div>
    </body>
</html>
