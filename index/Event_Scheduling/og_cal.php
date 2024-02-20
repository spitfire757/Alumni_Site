<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>

        <div>
            <nav>
                <table>
                    <tr>
                        <td>
                            <a href = "../Interface/help.php">Help</a>
                        </td>
                        <td>
                            <a href = "../Meeting_Social/message.php">Message</a>
                        </td>
                        <td>
                            <a href = "../Meeting_Social/forum.php">Forum</a>
                        </td>
                        <td>
                            <a href = "calendar.php">Calendar</a>
                        </td>
                        <td>
                            <a href = "../Authentication_Login/profile.php">Profile</a>
                        </td>
                    </tr>
                </table>
            </nav>
        </div>
<br>
<a href = "create_event.php">Create Event</a>
<h2> Upcoming Events</h2>
<?php
session_start();
if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventDate = date('Y-m-d', strtotime($_POST["date"]));
    $eventTime = $_POST["time"];
    $eventTime = $eventTime . ":00";
    $eventDetails = $_POST["bio"];
    $eventDateTime = $eventDate . " " . $eventTime;



}

//test 



//test
    $userID = 0 ;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO Calendar (User_ID, Date, Data) VALUES ('$userID', '$eventDateTime', '$eventDetails')";
    if ($conn->query($sql) === TRUE) {
        echo "Event created successfully <br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM Calendar";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "There is an Event " . $row['Date'] . ", " . $row['Data'] . " posted by userID: " . $row['User_ID'] . "<br>";
    }
} else {
    echo "No events currently scheduled";
}
$conn->close();
?>

</body>
</html>
