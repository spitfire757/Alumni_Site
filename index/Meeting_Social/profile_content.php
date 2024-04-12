<?php

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
    
    
    // Upload and process image file
    $targetDir = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDir . basename($_FILES["image"]["name"]); // Path to the uploaded file
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            // Save file path to database for the user
            // Update the query to include the file path
            // $sql = "UPDATE User SET Major=?, Minor=?, Experience=?, security=?, picture=? WHERE email=?";
            // Bind parameters and execute query
            // ...
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }


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
    <link rel="stylesheet" href="../style/global_style.css">
    <title>User Profile</title>
    <style>
        body {
            font-family: Trajan Pro, sans-serif;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .left {
            text-align: left;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        textarea,
        select {
            width: 300px;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button[type="button"],
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        button[type="button"]:hover,
        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="submit"] {
            margin-left: 10px;
        }

        #logoutForm {
            margin-top: 20px;
        }
    </style>
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
<form method='post' action='' id='updateForm' enctype="multipart/form-data">
    <!-- Image upload field -->
    Image: <input type="file" name="image" id="image"><br>
    <br>
    <!-- Other form fields -->
    Major: <input type='text' name='major' id='major' value='<?php echo $major; ?>'><br>
    Minor: <input type='text' name='minor' id='minor' value='<?php echo $minor; ?>'><br>
    Experience: <textarea name='experience' id='experience'><?php echo $experience; ?></textarea><br>
    <label for='securityToggle'>Security Setting:</label>
    <select id='securityToggle' name='securityToggle' required>
        <option value='0' <?php echo ($security == 0 ? 'selected' : ''); ?>>On</option>
        <option value='1' <?php echo ($security == 1 ? 'selected' : ''); ?>>Off</option>
    </select><br>
    <!-- Update button -->
    <button type='button' id='updateBtn'>Update</button>
</form>
<form method='post' action='signout.php' id='logoutForm'>
    <!-- Logout button -->
    <button type='submit'>Logout</button>
</form>

	<?php
    }

    $stmt->close();
    $conn->close();
} else {
    echo "";
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

