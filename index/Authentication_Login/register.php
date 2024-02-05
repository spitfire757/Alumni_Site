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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $major = $_POST['major'];
    $intendedGradYear = $_POST['intended_grad_year'];

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database configuration (replace with your actual database config)
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

        // Check if the username already exists
        $checkQuery = "SELECT COUNT(*) as count FROM email WHERE email = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$email]);
        $result = $checkStmt->fetch();

        if ($result['count'] > 0) {
            // Username already exists, handle accordingly (e.g., show an error message)
            echo "Email already exists in database. Please choose another email or contat admin.";
        } else {
            // Username doesn't exist, proceed with insertion
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert the user data into the database
            $insertQuery = "INSERT INTO User (email, password, first_name, last_name, major, intended_grad_year) 
                            VALUES (?, ?, ?, ?, ?, ?)";
            $insertStmt = $pdo->prepare($insertQuery);
            $insertStmt->execute([$email, $hashed_password, $firstName, $lastName, $major, $intendedGradYear]);

            echo "User registered successfully!";
            header('Location: login.php');
            exit(); // Make sure to exit after setting the header
        }
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form action="register.php" method="post">
    <label for="email">Email:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required><br>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br>

    <label for="major">Major:</label>
    <input type="text" id="major" name="major" required><br>

    <label for="intended_grad_year">Intended Graduation Year:</label>
    <input type="text" id="intended_grad_year" name="intended_grad_year" required><br>

    <input type="submit" name="register" value="Register">
</form>

</body>
</html>

