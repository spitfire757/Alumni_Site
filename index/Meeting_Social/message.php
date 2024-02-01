<!DOCTYPE html>
<html>
    <body>
        <?php
            /*
            !Connection to DB [No Schema Yet]

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

            echo "Hello World";
        ?>
    </body>
</html>