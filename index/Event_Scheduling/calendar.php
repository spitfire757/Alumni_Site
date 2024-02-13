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
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventDate = $_POST["date"];
    $eventTime = $_POST["time"];
    $eventDetails = $_POST["bio"];
    $eventDateTimeOffset = $eventDate . " " . $eventTime;
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Insert the event into the database
    $sql = "INSERT INTO Calendar (Date, Data) VALUES ('$eventDateTimeOffset', '$eventDetails')";
    if ($conn->query($sql) === TRUE) {
        echo "Event created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
// Display upcoming events
$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM Calendar";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "There is an Event " . $row['Date'] . ", " . $row['Data'] . "<br>";
    }
} else {
    echo "No events currently scheduled";
}
$conn->close();

?>

</body>
</html>
