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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle form submission
        $major = $_POST['major'];
        $minor = $_POST['minor'];
        $experience = $_POST['experience'];
        $security = $_POST['securityToggle']; // Added

        // Validate the character limit for Experience
        if (strlen($experience) > 500) {
            echo "Error: Experience must not exceed 500 characters.";
        } else {
            // Update the user information in the database
            $updateSql = "UPDATE User SET Major=?, Minor=?, Experience=?, security=? WHERE email=?";
            $updateStmt = $conn->prepare($updateSql);

            if ($updateStmt === false) {
                die("Error in preparing the update statement: " . $conn->error);
            }

            $updateStmt->bind_param("sssss", $major, $minor, $experience, $security, $currentUser); // Modified
            $updateStmt->execute();
            $updateStmt->close();
        }
    }

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

        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo "User not found for the given email/username: $currentUser";
    }

    $stmt->close();
    $conn->close();
}
?>

