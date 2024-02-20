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

                        $sql = "SELECT * FROM Forum";
                        $query = mysqli_query($conn,$sql);

                        $forum = (mysqli_fetch_array($query));
                    ?>
                    <h4><?php 

                    $sql = "SELECT * FROM User WHERE UserID = (".$forum[1].")";
                    $query = mysqli_query($conn,$sql);
                    $user = (mysqli_fetch_array($query));
                    
                    echo "".$user[1]." ".$user[2]."";
                    
                    ?></h4>
                    <p><?php echo $forum[2];?></p>
                </div>

                <!--
                <div>
                    <iframe class = "view" src = "forum-view.php" height="200" width="300" frameborder="0" allowfullscreen="" title="Embedded post"></iframe>
                </div>
-->

                <div>
                    You: <input type="text" name="reply"><br>
                    <button type = "submit" name = "submit" formaction="forum.php">Reply</button><br>
                </div>      
            </form>
            <?php

                $append_response = $_POST["reply"];
                $forum[3] .= '|new|'.$append_response;
                
                #SQL works in terms of updating code
                $sql = "UPDATE Forum SET message = ('".$forum[3]."') WHERE postID = ('".$forum[0]."');";
                $result = $conn->query($sql);
                
            ?>
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
