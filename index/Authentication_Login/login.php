<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Technopoliz</title>
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
    <h1>Login to Technopoliz</h1>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>


</body>
</html>



<?php
    session_start();
    // Replace these with your actual database credentials
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Establish a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the username and password from the login form
        $inputUsername = $_POST["username"];
        $inputPassword = $_POST["password"];

        // Prepare a SQL statement to select the user's hashed password from the database
        $sql = "SELECT * FROM users WHERE user = '$inputUsername'";
        $result = $conn->query($sql);

        if ($result === false) {
            echo "Error in SQL query: " . $conn->error;
        } else {
            if ($result->num_rows == 1) {
                // If the username exists in the database
                $row = $result->fetch_assoc();
                $hashedPasswordFromDB = $row["pass"]; // Assuming the column name is 'password'
		// Verify the input password against the hashed password from the database
                if (password_verify($inputPassword, $hashedPasswordFromDB)) {
			// Passwords match, redirect the user to the 'default' page
		    session_start();
	    	    $_SESSION['username'] = $inputUsername;
		    echo"Successful";
                    header("Location: profile.php");
                    exit();
                } else {
                    // Incorrect password
                    echo "Incorrect password.";
                }
            } else {
                // User not found in the database
                echo "User not found.";
            }
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
