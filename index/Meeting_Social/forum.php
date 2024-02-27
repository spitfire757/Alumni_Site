<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <form action = "forum.php" method = "post">
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
                </div>
                <div>
                    <!-- Form for the forum -->
                    <select name = "thread">
                        <?php
                            echo "<option value=".$forum["Title"].">Volvo</option>";
                        ?>
                    </select>
                    You: <input type="text" name="reply"><br>
                    <button type = "submit" name = "submit" formaction="forum.php">Reply</button><br>
                </div>      
            </form>
            <?php
                /*
                $append_response = $forum['replies'] . '|new|' . $_POST['reply'];
                echo $append_response;
                #SQL does not update code correctly
                $sql = "UPDATE Forum SET replies = '".$append_response."' WHERE postID = ".$forum['postID'].";";
                #$sql = "UPDATE Forum SET replies = 'i want money now XD updated' WHERE postID = 3;";
                $result = $conn->query($sql);
                */
            ?>
        </div>
    </body>
</html>
