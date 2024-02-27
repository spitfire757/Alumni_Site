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

                        $sql = "SELECT * FROM Forum WHERE ForumID = ('abcdefeg')";
                        $query = mysqli_query($conn,$sql);

                        $forum = (mysqli_fetch_assoc($query));

                        echo $forum;

                    ?>
                    <h4><?php 
                        /*
                        $sql = "SELECT * FROM User WHERE UserID = (".$forum["userID"].")";
                        $query = mysqli_query($conn,$sql);
                        $user = (mysqli_fetch_array($query));
                        
                        echo "".$user[1]." ".$user[2]."";
                        */
                        echo $forum["userID"]
                    ?></h4>

                    <p><?php echo $forum["Description"];?></p>
                </div>

                <!--div>
                    <iframe class = "view" src = "forum-view.php" height="200" width="300" frameborder="0" allowfullscreen="" title="Embedded post"></iframe>
                </div-->

                <div>
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
                echo "testing testing 123";
            ?>
        </div>
    </body>
</html>
