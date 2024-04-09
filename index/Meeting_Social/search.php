<?php

#if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";
    
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user details for users with security setting equal to 1
    $currentUser = $_SESSION['username'];
    echo $currentUser; 
    $sql = "SELECT email, Major, Minor, intended_grad_year, Experience FROM User WHERE security = 1 AND email != ?";
    $stmt = $conn->prepare($sql);
	
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Users with security setting equal to 1:</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Email: " . $row['email'] . "</li>";
            echo "<li>Major: " . $row['Major'] . "</li>";
            echo "<li>Minor: " . $row['Minor'] . "</li>";
            echo "<li>Graduation Year: " . $row['intended_grad_year'] . "</li>";
            echo "<li>Experience: " . $row['Experience'] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        echo "No users found with security setting set to 1.";
    }

    $stmt->close();
    $conn->close();
#} else {
#    echo "No user signed in.";
#}
?>

