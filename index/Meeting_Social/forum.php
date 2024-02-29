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

                    
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);

                    $dom = new DOMDocument();
                    $loaded = $dom->loadHTMLFile("forum.html");

                    if (!$loaded) {
                        die("Failed to load HTML file.");
                    }

                    $div = $dom->getElementById('select_form');

                    if ($div) {
                        echo $dom->saveHTML($div);
                    } else {
                        echo "Element with ID 'select_form' not found.";
                    }
                    


                    $conn = new mysqli($servername, $username, $password, $dbname);
                    /*
                    $sql = "SELECT * FROM Forum WHERE Title = '.$.'";
                    $query = mysqli_query($conn, $sql);
                    $forum = mysqli_fetch_assoc($query)
                    */
                ?>
            <!-- Form for the forum -->
            </div>
            <form action = "forum.php" method = "post">
                    <!-- This should load the content when selected -->
                    <h2><?php echo $forum["Title"];?></h2>
                    <h3><?php echo $forum["userID"];?></h3>
                    <p><?php echo $forum["Description"];?></p>
            </form>
            <?php
                if (isset($_POST['submit'])) {

                    # Get the elements needed for a new response
                    $userID = $_POST['userID'];
                    $response = $_POST['response'];
                    $dateTime = date("m-d-Y H:i:s");
                    $responseID = substr(hash('sha256',$response),0,16);
                    $forumID = $forum["ForumID"];

                    echo "userID: ".$userID."<br>datetime: ".$dateTime."<br>response: ".$response."<br>forumID: ".$forumID."<br> responseID: ".$responseID."<br>";
                    
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
