<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <?php
                

                echo "title";
                echo "<button type = 'submit' name = 'refresh' formaction='forum.php'>Go</button><br>";
                echo "desc<br>";
                echo "user + datetime<br>";
                echo "<br>";
                echo "<input type='text' name='userID' placeholder='userID' maxlength='64'><br>
                      <textarea id='response' name='response' placeholder='Insert Your Response Here' rows='4' cols='50' maxlength='255'></textarea><br>    
                      <button type = 'submit' name = 'submit' formaction='forum.php' required>Reply</button><br>";
                for ($x = 0; $x <= 10; $x++){
                    echo "responses<br><br>";
                }

                # Get the elements needed for a new response
                $userID = $_POST['userID'];
                $response = $_POST['response'];
                $dateTime = date("m-d-Y H:i:s");
                $responseID = substr(hash('sha256',$response),0,16);
                $forumID = $forum["ForumID"];

                echo "userID: ".$userID."<br>datetime: ".$dateTime."<br>response: ".$response."<br>forumID: ".$forumID."<br> responseID: ".$responseID."<br>";
                
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
<html>