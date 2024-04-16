
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

    $sql = "SELECT * FROM User WHERE $search_criteria LIKE '%$search_query%' AND security = BINARY '0'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching users
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
            
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".ucwords($row['type'])."<br>";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".$row['intended_grad_year']."<br>";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".ucwords($row['Major'])."<br>";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".ucwords($row['Minor'])."<br>";
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
    $sql = "SELECT * FROM User WHERE security = BINARY '0';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display matching users
        while ($row = $result->fetch_assoc()) {
            // Display user details
            echo "<a href='view_user.php?userid={$row['UserID']}'>{$row['Fname']} {$row['LName']}</a><br>";
            
            $dec = "";
            if($row['type'] != ""){
                $dec .= "Account: ".ucwords($row['type'])."<br>";
            }
            if($row['intended_grad_year'] != ""){
                $dec .= "Graduation: ".$row['intended_grad_year']."<br>";
            }
            if($row['Major'] != ""){
                $dec .= "Major: ".ucwords($row['Major'])."<br>";
            }
            if($row['Minor'] != ""){
                $dec .= "Minor: ".ucwords($row['Minor'])."<br>";
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


