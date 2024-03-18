<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <!-- Loading content from the DB -->
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

            ?>

            <!-- Putting content onto page with buttons to open forums -->
            <form action = "response.php" method = "post">
            <?php
                while ($row = $query->fetch_assoc()){
                    echo "<h2>".$row["Title"]."</h2>";
                    $id = $row['ForumID'];
                    echo "<a href='response.php'>
                            <button type = 'submit' name = '.$id.'>Go</button><br>
                          </a>";
                    echo $row["Description"]."<br>";
                    echo "<br>";
                }
            ?>
            </form>

            <!-- If button is clicked, open that forum -->
            <?php
                


            ?>
        </div>
    </body>
</html>
