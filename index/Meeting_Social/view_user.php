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
    if(isset($_GET['userid'])){
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
                <!--td rowspan="4"><img src="<?php #echo $row['profile_image']; ?>" alt="Profile Picture" class="profile-pic"></td-->
                <td class="info-section">
                    <div class="info-details">
                        <strong><?php echo $fname . ' ' . $lname; ?></strong><br>
                        <?php echo $account . ', ' . $grad . ', ' . $major . '/' . $minor; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Contact: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
            </tr>
            <tr>
                <td>Experience: <?php echo $exp; ?></td>
            </tr>
            <tr>
                <td>Resume: <?php echo $res; ?></td>
            </tr>
        </tbody>
    </table>
</body>
</html>