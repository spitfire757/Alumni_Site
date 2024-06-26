<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$username = $_SESSION['username'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get forumID from session
if (isset($_GET['userid'])) {
    $_SESSION["UserID"] = $_GET['userid'];
}

$User_ID = $_SESSION["UserID"];

// Fetch data from Response Table for the selected user
$query = "SELECT * FROM User WHERE UserID = $User_ID";
$result = $conn->query($query);

if (!$result) {
    echo "Error: " . $conn->error;
}

while ($row = $result->fetch_assoc()) {
    $pic = $row['email_auth'];
    $fname = $row['Fname'];
    $lname = $row['LName'];
    $account = $row['type'];
    $grad = $row['intended_grad_year'];
    $major = $row['Major'];
    $minor = $row['Minor'];
    $email = $row['email'];
    $exp = $row['experience'];
    $res = $row['resume'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .info-section {
            display: flex;
            align-items: center;
        }
        .info-details {
            margin-left: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <a href='search.php'>Back to Search</a>
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <td class="info-section">
                        <div class="info-details">
                            <strong><?php echo ucwords($fname) . ' ' . ucwords($lname); ?></strong><br>
                            <?php
                            $dec = "";
                            if ($account != "") {
                                $dec .= ucwords($account) . ", ";
                            }
                            if ($grad != "") {
                                $dec .= ucwords($grad) . ", ";
                            }
                            if ($major != "") {
                                $dec .= ucwords($major);
                            }
                            if ($minor != "") {
                                $dec .= "/" . ucwords($minor);
                            }
                            // Removed unnecessary line break
                            $dec .= "<hr><br>"; // Moved the line break inside the $dec string
                            echo $dec;
                            ?>
                        </div>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>Contact: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
                </tr>
                <tr>
                    <td>Experience: <?php echo "<br><br>".$exp; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
