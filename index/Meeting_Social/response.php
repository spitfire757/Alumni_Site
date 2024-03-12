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
            ?>
        </div>
    </body>
<html>