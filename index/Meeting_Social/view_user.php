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
    if(isset($_GET['UserID'])){
        $_SESSION["UserID"] = $_GET['UserID'];
    }

    $User_ID = $_SESSION["UserID"];

    // Fetch data from Response Table for the selected user
    $query = "SELECT * FROM User WHERE UserID = '$User_ID'";
    $result = $conn->query($query);

    if (!$result) {
        echo "Error: " . $conn->error;
    }

    $row = $result->fetch_assoc();
    echo $row['$User_ID'];
    echo $row['Fname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .profile-pic {
            max-width: 100px;
            max-height: 100px;
        }
        .info-section {
            display: flex;
            align-items: center;
        }
        .info-details {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <?php echo "1";?>
                <!--td rowspan="4"><img src="<?php #echo $row['profile_image']; ?>" alt="Profile Picture" class="profile-pic"></td-->
                <?php echo "2";?>
                <td class="info-section">
                    <div class="info-details">
                        <?php echo "3";?>
                        <strong><?php echo $row['Fname'] . ' ' . $row['LName']; ?></strong><br>
                        <?php echo $row['type'] . ', ' . $row['intended_grad_year'] . ', ' . $row['Major'] . '/' . $row['Minor']; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Contact: <?php echo $row['email']; ?></td>
            </tr>
            <tr>
                <td>Experience: <?php echo $row['experience']; ?></td>
            </tr>
            <tr>
                <td>Resume: <?php echo $row['resume']; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>