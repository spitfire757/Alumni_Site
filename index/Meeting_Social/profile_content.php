<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        /* CSS styles here */
        .container {
            display: flex;
            justify-content: space-between;
        }

        .left, .right {
            width: 45%;
        }

        .left form, .right form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php
session_start();

if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $currentUser = $_SESSION['username'];
    // Retrieve UserID and other fields based on the email (username)
    $sql = "SELECT UserID, email, Fname, LName, Major, Minor, Experience, security FROM User WHERE email = ?";
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
        $email = $row['email'];
        $FName = $row['Fname'];
        $LName = $row['LName'];
        $major = $row['Major'];
        $minor = $row['Minor'];
        $security = $row['security'];
        $experience = $row['Experience'];
        $pset_off = "Your information Such as Name, Major, Minor, and Experience are hidden from searches";
        $pset_on  = "Your information such as Name, Major, Minor, and Experience will show in searches";

        echo "<div class='container'>";
        echo "<div class='left'>";
        echo "UserID for $currentUser: $userID <br>";
        echo "Email: $email <br>";
        echo "Name: $FName $LName <br>";
        echo "Major: $major <br>";
        echo "Minor: $minor <br>";
        echo "Experience: $experience <br>";
        echo "Privacy Settings: ";
        echo ($security == 1) ? $pset_on : $pset_off; // Display privacy settings based on the security value

        // Display the form for updating information
        echo "<form method='post' action=''>";
        echo "<br>";
        echo "Major: <input type='text' name='major' value='$major'><br>";
        echo "Minor: <input type='text' name='minor' value='$minor'><br>";
        echo "Experience: <textarea name='experience'>$experience</textarea><br>";

        // Security Settings Dropdown
        echo "<label for='securityToggle'>Security Setting:</label>";
        echo "<select id='securityToggle' name='securityToggle' required>";
        echo "<option value='0'" . ($security == 0 ? ' selected' : '') . ">On</option>";
        echo "<option value='1'" . ($security == 1 ? ' selected' : '') . ">Off</option>";
        echo "</select><br>";
        echo "</div>";

        echo "<div class='right'>";
        // Upload Resume
        // echo "<label for='resume'>Upload Resume:</label>";
        // echo "<input type='file' id='resume' name='resume'><br>";

        // Upload Image
        // echo "<label for='image'>Upload Image:</label>";
        // echo "<input type='file' id='image' name='image'><br>";

        echo "<input type='submit' value='Update'>";
        echo "</form>";
        echo "</div>";
        echo "</div>";

    } else {
        echo "User not found for the given email/username: $currentUser";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>
<form action="signout.php" method="post">
    <button type="submit">Sign Out</button>
</form>
</body>
</html>

