<!DOCTYPE html>
<html>
<head>
    <title>Email Registration</title>
</head>
<body>
    <h2>Email Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
// Database connection (replace with your own credentials)
$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is set
    if (isset($_POST["email"])) {
        // Retrieve email from form data
        $email = $_POST["email"];

        // Generate random 6-digit integer
        $token = mt_rand(100000, 999999);

        // Store token in the database for the specified email
        $sql_insert_token = "UPDATE User SET token_1 = '$token' WHERE email = '$email'";
        if ($conn->query($sql_insert_token) === TRUE) {
            echo "Token stored successfully for email: $email";
        } else {
            echo "Error storing token: " . $conn->error;
        }
    } else {
        // Email is not set
        echo "Email is required.";
    }
    $command = "python email_auth.py $email $token";
    $output = shell_exec($command);
}
?>

