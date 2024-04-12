
<?php
/*

#if (isset($_SESSION['username'])) {
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";
    
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $query = "SELECT * FROM User;";
    $result = mysqli_query($conn, $query);
    ?>
    <head>
    <style>
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        
        table {
            margin: auto;
            width: 80%;
        }

        td {
            padding: 10px;
            text-align: center;
        }
        .separator {
    margin-top: 20px;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.search-form {
    margin-bottom: 20px;
}

.search-input,
.search-select {
    padding: 10px;
    margin-right: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.search-input::placeholder {
    color: #999;
}

.forum-title-smaller {
    font-size: 1.3rem; 

    </style>
    </head>
    <hr>
    <link rel="stylesheet" href="../style/global_style.css">
    <form action="search.php" method="get">
        <input type="text" name="search_query" placeholder="Search...">
        <select name="search_criteria">
            <option value="title">Name</option>
            <option value="Description">Major</option>
            <option value="userID">Minor</option>
            <option value="userID">Graduation Year</option>
            <option value="userID">User</option>
        </select>
        <button type="submit">Search</button>
        <button type="submit" name="clear_search">Clear Search</button>
    </form>
    <hr>
    <?php
    while ($row = $result->fetch_assoc()) {
        // Display user details
        echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
        
        $dec = "";
        if($row['type'] != ""){
            $dec .= "Account: ".$row['type']." ";
        }
        if($row['intended_grad_year'] != ""){
            $dec .= "Graduation: ".$row['intended_grad_year']." ";
        }
        if($row['Major'] != ""){
            $dec .= "Major: ".$row['Major']." ";
        }
        if($row['Minor'] != ""){
            $dec .= "Minor: ".$row['Minor']." ";
        }
        $dec = $dec."<br><hr>"; 
        echo $dec;
    }
// Display user titles and descriptions
    // PHP Logic for Handling Search
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_criteria = $_GET['search_criteria'];

    // SQL query to retrieve users based on search criteria
    $sql = "SELECT * FROM User WHERE $search_criteria LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching users
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
            
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".$row['type']." ";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".$row['intended_grad_year']." ";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".$row['Major']." ";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".$row['Minor']." ";
            }
            $dec = $dec."<br><hr>"; 
            echo $dec;
        }
    }
} else {
        echo "No users found.";
    }
if (isset($_GET['clear_search'])) {
    // Clear the search
    header("Location: search.php");
    exit();
} else {
    // Default display: All forums
    $sql = "SELECT * FROM User;";
    echo $sql;
    $result = $conn->query($sql);
    echo $result;
    if ($result->num_rows > 0) {
        // Display matching forums
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>'";
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".mb_convert_case($row['type'],MB_CASE_TITLE, "UTF-8")." ";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".mb_convert_case($row['intended_grad_year'],MB_CASE_TITLE, "UTF-8")." ";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".mb_convert_case($row['Major'],MB_CASE_TITLE, "UTF-8")." ";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".mb_convert_case($row['Minor'],MB_CASE_TITLE, "UTF-8")." ";
            }
        }
    } else {
        echo "No users found.";
    }
}

    /*
    // Retrieve user details for users with security setting equal to 1
    $sql = "SELECT email, Major, Minor, intended_grad_year, Experience FROM User WHERE security = 1 AND email != ?";
    $stmt = $conn->prepare($sql);
	
    if ($stmt === false) {
        die("Error in preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Public Users:</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Email: " . $row['email'] . "</li>";
            echo "<li>Major: " . $row['Major'] . "</li>";
            echo "<li>Minor: " . $row['Minor'] . "</li>";
            echo "<li>Graduation Year: " . $row['intended_grad_year'] . "</li>";
            echo "<li>Experience: " . $row['Experience'] . "</li>";
            echo "<br>";
        }
        echo "</ul>";
    } else {
        echo "No users found with security setting set to 1.";
    }

    $stmt->close();
    $conn->close();
#} else {
#    echo "No user signed in.";
#}
?>
*/
?>

<link rel='stylesheet' type='text/css' href='../style/global_style.css'>
<?php
session_start();

$servername = "localhost";
$username = "mysql_user";
$password = "r00tpassw0rd/";
$dbname = "DB";

$conn = new mysqli($servername, $username, $password, $dbname);

$query = "SELECT * FROM User";
$result = mysqli_query($conn, $query);
?>

<style>
        /* Button styles */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Table styles */
        table {
            margin: auto;
            width: 80%;
        }

        td {
            padding: 10px;
            text-align: center;
        }
        .separator {
    margin-top: 20px;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
}

.search-form {
    margin-bottom: 20px;
}

.search-input,
.search-select {
    padding: 10px;
    margin-right: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.search-input::placeholder {
    color: #999;
}

.forum-title-smaller {
    font-size: 1.3rem; /* Adjust the font size as needed */
    /* Add any additional styles here if necessary */
}

</style>
<body style="text-align: center; font-family: Trajan Pro, sans-serif;">

<form action="search.php" method="get" class="search-form">
    <input type="text" name="search_query" placeholder="Search..." class="search-input">
    <br>
    <select name="search_criteria" class="search-select">
        <option value="Fname">First Name</option>
        <option value="LName">Last Name</option>
        <option value="Major">Major</option>
        <option value="Minor">Minor</option>
        <option value="intended_grad_year">Graduation</option>
        <option value="type">Account Type</option>
    </select>
    <br>
    <button type="submit" class="btn">Search</button>
    <button type="submit" name="clear_search" class="btn">Clear Search</button>
</form>
<hr class="separator">
</body>
<?php
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = $_GET['search_query'];
    $search_criteria = $_GET['search_criteria'];

    $sql = "SELECT * FROM User WHERE $search_criteria LIKE '%$search_query%'";
    echo $sql;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching users
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
            
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".$row['type']." ";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".$row['intended_grad_year']." ";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".$row['Major']." ";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".$row['Minor']." ";
            }
            $dec = $dec."<br><hr>"; 
            echo $dec;
        }
    }
    else {
            echo "No users found.";
    }
} elseif (isset($_GET['clear_search'])) {
    header("Location: search.php");
    exit();
} else {
    $sql = "SELECT * FROM User";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching users
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
            
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".$row['type']." ";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".$row['intended_grad_year']." ";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".$row['Major']." ";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".$row['Minor']." ";
            }
            $dec = $dec."<br><hr>"; 
            echo $dec;
        }
    }
    else {
        echo "No users found.";
    }
}
?>


