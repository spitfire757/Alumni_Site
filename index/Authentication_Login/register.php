<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <h1>
	Welcome, let's get you registered!
    </h1>
    <style>
	body {
            font-family: 'Roboto', sans-serif;
            background-color: #282c34; /* Dark background */
            color: #c0c0c0; /* Light grey text */
            text-align: center;
            padding: 50px;
            margin: 0;
        }
	h1 {
	   color: #61dafb; /* Robotic blue */
	}
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
            display: block;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 20px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #61dafb; /* Robotic blue */
            background-color: #282c34; /* Dark background */
            color: #c0c0c0; /* Light grey text */
            font-size: 16px;
        }

        input[type="submit"] {
            cursor: pointer;
            background-color: #61dafb; /* Robotic blue */
            color: white;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #1e90ff; /* Darker blue on hover */
        }
    </style>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; // You should hash this password

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database configuration
    $host = 'localhost';
    $db   = 'DB';
    $user = 'mysql_user';
    $pass = 'r00tpassw0rd/';
    $charset = 'utf8mb4';

    // Data Source Name
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        // Establish a connection with the database
        $pdo = new PDO($dsn, $user, $pass, $options);

        // SQL query to insert the user data into the database
        $sql = "INSERT INTO test (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username,  $hashed_password]);

        echo "User registered successfully!";
        header('Location: login.php');
        exit(); // Make sure to exit after setting the header
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
	//^^ Testing for DB connection via psudo remote connection 
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>


