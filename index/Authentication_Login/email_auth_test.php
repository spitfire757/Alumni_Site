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

// Function to generate a random 6-digit token
function generateToken() {
    return mt_rand(100000, 999999);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is set
    if (isset($_POST["email"])) {
        // Retrieve email from form data
        $email = $_POST["email"];
        
        // Generate random token
        $token = generateToken();

        // Store token in the database
        $sql_insert_token = "INSERT INTO User (token_1) VALUES ('$token')";
        if ($conn->query($sql_insert_token) === TRUE) {
            echo "Token stored successfully.";
        } else {
            echo "Error storing token: " . $conn->error;
        }

        // Now, you can proceed with handling the email and token as needed
        // ...
    } else {
        // Email is not set
        echo "Email is required.";
    }
}
?>

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


