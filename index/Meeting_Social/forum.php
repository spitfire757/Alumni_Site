<!DOCTYPE html>:x
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <form action = "forum.php" method = "post">
                <div>
                    <?php
                        echo "Hello before the results are generated";
                        include '/Alumni_Site/index/Meeting_Social/connect.php';
                        $conn = OpenCon();
                        $sql = "SELECT * FROM Forum";
                        $result = mysqli_query($conn,$sql);
                        echo $result;
                        echo "Hello after the results are generated";
                    ?>
                    <h4>Question: Where can I find jobs at?</h4>
                    <p>The following is a test section of where I can find code</p>
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
                    ?>
                </h3>
            </div>
        </div>
    </body>
</html>
