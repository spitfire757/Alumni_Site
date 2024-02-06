<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <form action = "forum.php" method = "post">
                <div>
                    <h4>Question: Where can I find jobs at?</h4>
                    <p>The following is a test section of where I can find code</p>
                </div>
                <div>
                    You: <input type="text" name="reply"><br>
                    <button type = "submit" name = "submit" formaction="leap_year.php">Reply</button><br>
                </div>      
            </form>
            <div>
                <h3>
                    <?php
                        $dbhost = "localhost";
                        $dbuser = "mysql_user";
                        $dbpass = "r00tpassw0rd/";
                        $dbname = "DB";
                        
                        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

                        $post = $_POST["reply"];

                        $sql = "SELECT * FROM 'post'";

                        $replies = $conn->query($sql);

                        while ($replies->num_rows>0){
                            echo "hi";
                        }

                        $sql = "INSERT INTO `` VALUES ('".$year."'); ";

                        $conn->query($sql);

                        /*

                        */
                    ?>
                </h3>
            </div>
        </div>
    </body>
</html>