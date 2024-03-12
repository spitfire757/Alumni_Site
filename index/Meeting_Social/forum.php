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

                    $sql = "SELECT * FROM Forum";
                    $query = $conn->query($sql);
                    
                    
                    while ($row = $query->fetch_assoc()){
                        echo $row["Title"]."<br>";
                        echo $row["Description"]."<br>";
                    }

                    
                ?>
            <!-- Form for the forum -->
            </div>
            <form action = "forum.php" method = "post">
                    <!-- This should load the content when selected -->     
            </form>
            <?php
                if (isset($_POST['submit'])) {

                    
                    /*
                    # Add Response to Response Table
                    $sql = "INSERT INTO Forum_Response VALUES ($responseID,$forumID,$userID,$response,$dateTime);";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $query = mysqli_query($conn, $sql);
                    */
                    $sql = "INSERT INTO Forum_Response VALUES ('$responseID', '$forumID', '$userID', '$response', '$dateTime')";

                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    
                    $_POST['userID'] = "";
                    $_POST['response'] = "";
                }
                
            ?>
        </div>
    </body>
</html>
