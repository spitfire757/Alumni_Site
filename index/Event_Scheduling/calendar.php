<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
<style>
    .event-details {
        text-align: center;
    }
</style>
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


<p style="text-align:center"><a href="create_event.php">Click Here to Create an Event</a></p>
<h2 align=center> Upcoming Events</h2>


 <?php
session_start();

if (isset($_SESSION['username'])) {
    
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve UserID and other fields based on the email (username)
    $currentUser = $_SESSION['username'];
    $sql = "SELECT UserID FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];
        // Store UserID in a session variable
        $_SESSION['userID'] = $userID;
    } else {
        echo "User not found for the given email/username: $currentUser";
        // You may want to handle this case appropriately, like redirecting to a login page
    }

    // Close the statement
    $stmt->close();

    // If the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get other form data
        $eventDate = date('Y-m-d', strtotime($_POST["date"]));
        $eventTime = $_POST["time"];
        $eventTime = $eventTime . ":00";
        $eventDetails = $_POST["bio"];
        $eventDateTime = $eventDate . " " . $eventTime;

        // Use the stored UserID to insert into Calendar table
        $sql = "INSERT INTO Calendar (User_ID, Date, Data) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error in preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $_SESSION['userID'], $eventDateTime, $eventDetails);
        $stmt->execute();
        $stmt->close();

        echo "Event created successfully <br>";
    }

    // Close the database connection
    $conn->close();
}

// Display events
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Calendar";
$result = $conn->query($sql);
$todaysDate = date('Y-m-d H:i:s');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            if ($row['Date'] >= $todaysDate) {
                $dateWithoutSeconds = substr($row['Date'], 0, -3);
                $userId = $row['User_ID'];
                $innerSql = "SELECT * FROM User WHERE UserID=?";
                $stmt = $conn->prepare($innerSql);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $innerResult = $stmt->get_result();
                $userRow = $innerResult->fetch_assoc();
                $fname = $userRow['Fname'];
                $lname = $userRow['LName'];
                ?>
                <div class="event-details">
                    <?php echo $dateWithoutSeconds . " - " . $row['Data'] . "<br>"; ?>
                    <?php echo "Posted by user: " . $fname . " " . $lname . "<br><br>"; ?>
                </div>
                <?php
                $stmt->close();
        }
    }
}
else {
    echo "No events currently scheduled";
}
$conn->close();
?>


</html>
