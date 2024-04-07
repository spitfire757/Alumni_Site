<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $experience = $_POST['experience'];
    $security = $_POST['securityToggle'];

    // Validate and sanitize your input data here

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

    // Prepare and execute your update query here
    $sql = "UPDATE User SET Major=?, Minor=?, Experience=?, security=? WHERE email=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sssis", $major, $minor, $experience, $security, $currentUser);
    $stmt->execute();

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request or no user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
<?php
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

    // Retrieve user information
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
        ?>
        <form method='post' action='' id='updateForm'>
            <br>
            Major: <input type='text' name='major' id='major' value='<?php echo $major; ?>'><br>
            Minor: <input type='text' name='minor' id='minor' value='<?php echo $minor; ?>'><br>
            Experience: <textarea name='experience' id='experience'><?php echo $experience; ?></textarea><br>
            <label for='securityToggle'>Security Setting:</label>
            <select id='securityToggle' name='securityToggle' required>
                <option value='0' <?php echo ($security == 0 ? 'selected' : ''); ?>>On</option>
                <option value='1' <?php echo ($security == 1 ? 'selected' : ''); ?>>Off</option>
            </select><br>
            <button type='button' id='updateBtn'>Update</button>
        </form>
        <form method='post' action='signout.php' id='logoutForm'>
            <button type='submit'>Logout</button>
        </form>
        <?php
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No user signed in, unable to connect to DB, sign in or contact DB admin";
}
?>

<script>
    document.getElementById('updateBtn').addEventListener('click', function() {
        var major = document.getElementById('major').value;
        var minor = document.getElementById('minor').value;
        var experience = document.getElementById('experience').value;
        var security = document.getElementById('securityToggle').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo $_SERVER["PHP_SELF"]; ?>', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Refresh the page after successful update
                location.reload();
            } else {
                console.log('Request failed. Status: ' + xhr.status);
            }
        };
        xhr.send('major=' + encodeURIComponent(major) + '&minor=' + encodeURIComponent(minor) + '&experience=' + encodeURIComponent(experience) + '&securityToggle=' + encodeURIComponent(security));
    });
</script>
</body>
</html>

