<!DOCTYPE html>
<html>
    <body>
        <div class = "content">
        <?php 
        /*

        Gather informaiton from Database to display

        $dbhost = "localhost";
        $dbuser = "mysql_user";
        $dbpass = "r00tpassw0rd/";
        $dbname = "DB";            
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

        0. Database = Messages, Table = Chat/GroupChat 

        1. Select table (chat) from database (messages) (maybe retrive from side panel from html/another php file?)

        2. Select all rows from table (chat) that contains
        - Timestamps (Primary Key) (DateTime)
        - Sender/Profile (Foreign Key to pull information from another table)(VarChar(32))
        -  Message Text

        3. Output Responses from Oldest to Newest (Top to Bottom)
        */

        $messenger = "Bob Jones";

        echo "<h2>".$messenger."</h2>";
    
        /*
        for (message in message content){
            if sender is user:
                echo "<p style='text-align: right'>.$message.";
            else: // assumes this is not from you
                echo "<p style='text-align: left'>.$message.";

        }
        */

        $message = "testing message";

        for( $i = 0; $i < 5; $i++ )
        {
            if (i%2==0){
                echo "<p style='text-align: right'>".$message."</p>";
            }
            if (i%2==1){ // assumes this is not from you
                echo "<p style='text-align: left'>".$message."</p>"; 
            }
        }


        ?>
        </div>
        <form action = "forum.php" method = "post">
            <div>
                <h4>Name of User Here</h4>
                <p>The following is a test section of where I can find code</p>
            </div>
            <div>
                You: <input type="text" name="reply"><br>
                <button type = "submit" name = "submit" formaction="leap_year.php">Reply</button><br>                </div>      
            </form>
        <?php
            /*
            !Connection to DB 

            $dbhost = "localhost";
            $dbuser = "mysql_user";
            $dbpass = "r00tpassw0rd/";
            $dbname = "DB";
            
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
            */

            /*
            Functionality

            0. Database = Messages, Table = Chat/GroupChat 

            1. Select table (chat) from database (messages) (maybe retrive from side panel from html/another php file?)

            1. Select all rows from table (chat) that contains
            - Timestamps (Primary Key) (DateTime)
            - Sender/Profile (Foreign Key to pull information from another table)(VarChar(32))
            - Message Text

            2. Output Responses from Oldest to Newest (Top to Bottom)

            3. If any user inputs thier response and hits send, the you insert the following into the table
            - Timestamp of Send Button
            - Sender/Profile information of Sender
            - Message Text

            ? Questions:
            - Is there a way in PHP to dynamically update the page/php
            since this is in an iframe
            */

            $dbhost = "localhost";
            $dbuser = "mysql_user";
            $dbpass = "r00tpassw0rd/";
            $dbname = "DB";
                        
            $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

            $post = $_POST["message"];

            $sql = "SELECT * FROM ''";

            $replies = $conn->query($sql);

                        while ($replies->num_rows>0){
                            echo "hi";
                        }

                        $sql = "INSERT INTO `` VALUES ('".$year."'); ";

                        $conn->query($sql);

                        /*

                        */
        ?>
    </body>
</html>