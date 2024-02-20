<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <form action = "forum.php" method = "post">
                <div>
                    <?php
                        session_start();
                        #include 'connect.php';
                        
                        #After you get the DB to output dummy data, try moving this into the connect.php file
                        $servername = "localhost";
                        $username = "mysql_user";
                        $password = "r00tpassw0rd/";
                        $dbname = "DB";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        $sql = "SELECT * FROM Forum";
                        $query = mysqli_query($conn,$sql);

                        $forum = (mysqli_fetch_array($query));

                        $_SESSION['responses'] = $forum[3];
                    ?>
                    <h4><?php echo $forum[1];?></h4>
                    <p><?php echo $forum[2];?></p>
                </div>
                <div>
                    <iframe src = "forum-view.php" height="707" width="504" frameborder="0" allowfullscreen="" title="Embedded post"></iframe>
                </div>

                <div>
                    You: <input type="text" name="reply"><br>
                    <button type = "submit" name = "submit" formaction="forum.php">Reply</button><br>
                </div>      
            </form>
            <div>
                <h3>
                    <?php
                        /*
                        $dbhost = "localhost";
                        $dbuser = "mysql_user";
                        $dbpass = "r00tpassw0rd/";
                        $dbname = "DB";
                        
                        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

                        $post = $_POST["reply"];

                        $sql = "SELECT * FROM Forum (table)";

                        $replies = $conn->query($sql);

                        while ($replies->num_rows>0){
                            echo "hi";
                        }

                        $sql = "INSERT INTO `` VALUES ('".$year."'); ";

                        $conn->query($sql);

                        */

                        /*
                        $message = "dummy text, not in DB. There are four parts to a critical response paragraph:1) an argumentative topic sentence, 2) evidence in the form of quotations or paraphrases for the argument you are making, 3) interpretation of your evidence in relation to the argument, and 4) a strong concluding statement.";
                        echo "<table>";
                        $i = 10;
                        while ($i>0) {
                            echo "<tr style='text-align: right'>".$message."</tr><br><br>";
                            $i --;
                        }
                        echo "</table>";
                        
                        $post = $_POST["reply"];

                        echo "<p style='text-align: right'>".$post."</p><br>";
                        */
                    ?>
                </h3>
            </div>
        </div>
    </body>
</html>
