<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<p>User is not logged in.</p>";
    exit;
}

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("<p>Connection failed: " . $conn->connect_error . "</p>");
}

$currentUserEmail = $_SESSION['username'];

$sql = "SELECT Fname, Lname, Major, Minor, Experience, Security FROM User WHERE Email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentUserEmail);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $major = $_POST['major'];
    $minor = $_POST['minor'];
    $experience = $_POST['experience'];
    $security = $_POST['securityToggle'];

    $sql = "UPDATE User SET Major=?, Minor=?, Experience=?, Security=? WHERE Email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $major, $minor, $experience, $security, $currentUserEmail);
    $stmt->execute();

    if ($stmt->error) {
        echo "<script>alert('Error updating information: " . addslashes($stmt->error) . "');</script>";
    } else {
        echo "<script>alert('Information updated successfully!'); window.location.href = window.location.href;</script>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        input, textarea, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
    <h3>User Profile</h3>
<body>
<div class='container'>
    <form method='post'>
        Major: <input type='text' name='major' value="<?= htmlspecialchars($userData['Major']) ?>"><br>
        Minor: <input type='text' name='minor' value="<?= htmlspecialchars($userData['Minor']) ?>"><br>
        Experience: <textarea name='experience'><?= htmlspecialchars($userData['Experience']) ?></textarea><br>
        Security Setting: <select name='securityToggle'>
            <option value='1' <?= $userData['Security'] ? 'selected' : '' ?>>On</option>
            <option value='0' <?= !$userData['Security'] ? 'selected' : '' ?>>Off</option>
        </select><br>
        <button type='submit'>Update</button>
    </form>
</div>
</body>
    <form method='post' action='signout.php'>
        <button type='submit'>Logout</button>
    </form>
</html>

