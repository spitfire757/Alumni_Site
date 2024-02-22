<?php
if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $currentUser = $_SESSION['username'];
    echo "<br> Email(Username): $currentUser <br>";

    // Retrieve UserID and other fields based on the email (username)
    $sql = "SELECT UserID, email, Fname, LName FROM User WHERE email = ?";
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
        $email = $row['email'];
        $FName = $row['Fname'];
        $LName = $row['LName'];

        // Display UserID, Email, and other information as needed
        echo "UserID for $currentUser: $userID <br>";
        echo "Email: $email <br>";
        echo "Name: $FName $LName <br>";
        // Add other fields as needed
        echo "Password (Needs to stay hidden) <br>";
        echo "Major <br>";
        echo "Minor <br>";
        echo "About <br>";
        echo "Experience <br>";
        echo "Resume <br>";
    } else {
        echo "User not found for the given email/username: $currentUser";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

