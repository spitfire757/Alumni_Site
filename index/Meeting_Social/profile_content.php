<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "User is not logged in.";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$currentUserEmail = $_SESSION['username'];


// SQL query to fetch the required user information
$sql = "SELECT Fname, Lname, Major, Minor, Experience FROM User WHERE Email=?";
$stmt = $conn->prepare($sql);

// Check if the statement was prepared correctly
if (!$stmt) {
    die("SQL statement failed: " . $conn->error);
}

// Bind parameters and execute the SQL statement
$stmt->bind_param("s", $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Name: " . htmlspecialchars($row['Fname']) . " " . htmlspecialchars($row['Lname']) . "<br>";
    echo "Major: " . htmlspecialchars($row['Major']) . "<br>";
    echo "Minor: " . htmlspecialchars($row['Minor']) . "<br>";
    echo "Experience: " . htmlspecialchars($row['Experience']) . "<br>";
} else {
    echo "No user information found for the provided email.";
}


// Handle POST request to update user information
// Handle POST request to update user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $experience = $_POST['experience'];
    $security = $_POST['securityToggle'];

    // Handle the image upload
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
        $filetype = $_FILES['userImage']['type'];
        $filesize = $_FILES['userImage']['size'];

        // Verify MIME type of the file
        if (!in_array($filetype, $allowed)) {
            echo "Error: Invalid file format.";
        } else {
            // Read the file
            $imageData = file_get_contents($_FILES['userImage']['tmp_name']);
	    if ($imageData === false) {
                echo 'Error reading image file';
            } else {
                echo 'Image data loaded, size: ' . strlen($imageData) . ' bytes';  // Debug: Check image data size
	    }


            $imageData = mysqli_real_escape_string($conn, $imageData);

            // SQL to update user information including the image data
            $sql = "UPDATE User SET Major=?, Minor=?, Experience=?, Security=?, ImageData=? WHERE Email=?";
            $stmt = $conn->prepare($sql);
            $null = NULL;
            $stmt->bind_param("ssssbs", $major, $minor, $experience, $security, $null, $currentUserEmail);
            $stmt->send_long_data(5, $imageData);
	    $stmt->execute();



            if ($stmt->error) {
                echo "Error updating information: " . $stmt->error;
            } else {
                echo "Information and image updated successfully!";
            }
        }
    } else {
        echo "Error: " . $_FILES['userImage']['error'];
    }
}

// Retrieve image data and display it
$sql = "SELECT Fname, Lname, Major, Minor, Experience, ImageData FROM User WHERE Email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Name: " . htmlspecialchars($row['Fname']) . " " . htmlspecialchars($row['Lname']) . "<br>";
    echo "Major: " . htmlspecialchars($row['Major']) . "<br>";
    echo "Minor: " . htmlspecialchars($row['Minor']) . "<br>";
    echo "Experience: " . htmlspecialchars($row['Experience']) . "<br>";
    if ($row['ImageData']) {
        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['ImageData']).'" alt="User Image"/>';
    }
}







// Grab user connections
$sql = "SELECT id, user_1, user_2 FROM load_contacts WHERE user_1 = ? OR user_2 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $currentUserEmail, $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();

$connections = [];
while ($row = $result->fetch_assoc()) {
    $connections[$row['id']] = $row['user_1'] == $currentUserEmail ? $row['user_2'] : $row['user_1'];
}

$messageHistory = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $experience = $_POST['experience'];
    $security = $_POST['securityToggle'];

    // Prepare and execute  update query here
    $sql = "UPDATE User SET Major=?, Minor=?, Experience=?, Security=? WHERE Email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sssis", $major, $minor, $experience, $security, $currentUserEmail);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error updating information: " . $stmt->error;
    } else {
        echo "Information updated successfully!";
    }

    $stmt->close();
}

echo "Data hash: " . md5($imageData);



$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global_style.css">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }
        form {
            margin-top: 20px;
        }
        input, textarea, select {
            width: 300px;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class='container'>
    <h3>User Profile</h3>
    <form method='post' enctype='multipart/form-data'>
        Major: <input type='text' name='major' required><br>
        Minor: <input type='text' name='minor' required><br>
        Experience: <textarea name='experience' required></textarea><br>
        Security Setting: <select name='securityToggle' required>
            <option value='1'>On</option>
            <option value='0'>Off</option>
        </select><br>
        Upload Image: <input type='file' name='userImage' accept='image/*'><br>
        <button type='submit'>Update</button>
    </form>
    <form method='post' action='signout.php'>
        <button type='submit'>Logout</button>
    </form>
</div>
</body>
</html>
