<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<form action="send_request.php" method="post">
    <table>
        <tr>
            <td><label for="accountName">Account Name:</label></td>
            <td><input type="text" id="accountName" name="accountName" required></td>
        </tr>
        <tr>
            <td><label for="accountID">Account ID:</label></td>
            <td><input type="text" id="accountID" name="accountID" required></td>
        </tr>
    </table>
    <button type="submit">Submit</button>
</form>


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

    // Get the sender's username and user ID from session
    $senderUsername = $_SESSION['username'];
    // Get receiver's name and ID from the form submission
    // Retrieve UserID and other fields based on the email (username)
    $sql = "SELECT UserID, email, Fname, LName FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $senderUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userID = $row['UserID'];
        $email = $row['email'];
        $FName = $row['Fname'];
        $LName = $row['LName'];

        // Display UserID, Email, and other information as needed
        echo "UserID for $email: $userID <br>";
        echo "Email: $email <br>";
        echo "Name: $FName $LName <br>";
    }





    // Need to double check everything below here, as the response sequence is not passing correctly and a bunch of 
    // these errors are caused by unkown names 
    // Double check that all variables pass and check error log from /var/log/apache2/error.log
    // Double check DB submission once fixed so no values are NULL (check sender_ID)  
        // Insert the request into the database
	echo $email;
	echo $userID;
        $sql = "INSERT INTO friend_requests (sender_username, sender_id, receiver_name, receiver_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $sender_ID, $senderID, $receiverName, $receiverID);
        $stmt->execute();
        $stmt->close();

        echo "Request sent successfully!";
    } 
 else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>


