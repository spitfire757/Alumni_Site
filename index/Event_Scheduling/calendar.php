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


<h2 align=center> Upcoming Events</h2>

 <?php
session_start();
$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_SESSION['username'])) {
    
    ?>
    <p style="text-align:center"><a href="create_event.php">Click Here to Create an Event</a></p>
    <?php

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve UserID and other fields based on the email (username)
    $currentUser = $_SESSION['username'];
    $sql = "SELECT UserID FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];
        $_SESSION['userID'] = $userID;
    } else {
        echo "User not found for the given email/username: $currentUser";
    }
    $stmt->close();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $eventDate = date('Y-m-d', strtotime($_POST["date"]));
        $eventTime = $_POST["time"];
        $eventTime = $eventTime . ":00";
        $eventDetails = $_POST["bio"];
        $eventDateTime = $eventDate . " " . $eventTime;
        $todaysDate = date('Y-m-d H:i:s');
        $eventDateTime = date("Y-m-d H:i:s", strtotime($eventDateTime));
        if($eventDateTime <= $todaysDate){
            ?>
            <div class="event-details">
                <?php echo "<h3>The date you entered was invalid. Please select a date that has not passed. </h3> <br>"; ?>
            </div>
            <?php
        }
        else{
            $sql = "INSERT INTO Calendar (User_ID, Date, Data) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error in preparing the statement: " . $conn->error);
            }

            $stmt->bind_param("sss", $_SESSION['userID'], $eventDateTime, $eventDetails);
            $stmt->execute();
            $stmt->close();

            ?>
            <div class="event-details">
                <?php echo "Event Created Succesfully <br><br>"; ?>
            </div>
            <?php
        }

    }
    $conn->close();
}

// Display events
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Calendar ORDER BY Date ASC";
$result = $conn->query($sql);
$todaysDate = date('Y-m-d H:i:s');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            if ($row['Date'] >= $todaysDate) {
                $date = new DateTime($row['Date']);
                $formattedDate = $date->format('F j, Y g:iA');
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
                    <?php echo $formattedDate . " - " . $row['Data'] . "<br>"; ?>
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
