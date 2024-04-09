<?php
// Check if user is logged in
if (isset($_SESSION['username'])) {
    $currentUserEmail = $_SESSION['username'];
    $servername = "localhost";
    $username = "mysql_user";
    $password = "r00tpassw0rd/";
    $dbname = "DB";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch connections from the database
    $sql = "SELECT * FROM load_contacts WHERE user_1 = '$currentUserEmail' OR user_2 = '$currentUserEmail'";
    $result = $conn->query($sql);

    $connections = array();

    // Check if there are rows returned
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Add the connection to the list if the current user's email is in it
                if ($row['user_1'] == $currentUserEmail || $row['user_2'] == $currentUserEmail) {
                    $connections[] = $row;
                }
            }
        } else {
            echo "No connections found.";
        }
        // Free result set
        $result->free();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
} else {
    echo "User is not logged in.";
}
?>

<h2>Captain's Dock - Messages Tab</h2>
<p>This is the content for the Messages Tab.</p>
<div style="display: flex;">
    <!-- Message box area (left side) -->
    <div id="firstContactForm" style="width: 60%; margin-right: 20px;">
        <h3>Who are you trying to reach?</h3>
        <form>
            <label for="firstName">Email (Username):</label><br>
            <input type="text" id="username" name="Email (Username)" required><br>
            <label for="message">Enter Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>
            <button class="button" type="submit">Send</button>
        </form>
        <?php
        // Display connections
        if (!empty($connections)) {
            echo "<h3>Your Connections:</h3>";
            echo "<ul>";
            foreach ($connections as $connection) {
                $id = $connection['id']; // Get the ID associated with the connection
                // Determine the email of the other user in the connection
                $otherUserEmail = ($connection['user_1'] == $currentUserEmail) ? $connection['user_2'] : $connection['user_1'];

                // Fetch first and last name associated with the email
                $sqlName = "SELECT Fname, LName FROM User WHERE email = '$otherUserEmail'";
                $resultName = $conn->query($sqlName);
                if ($resultName->num_rows > 0) {
                    $rowName = $resultName->fetch_assoc();
                    $firstName = $rowName['Fname'];
                    $lastName = $rowName['LName'];
                } else {
                    $firstName = "Unknown";
                    $lastName = "Unknown";
                }

                // Display email, associated first and last names, and the ID
                echo "<li>ID: $id - Email: $otherUserEmail - Name: $firstName $lastName</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>

    <!-- Content from first_contact.php (right side) -->
    <div style="width: 30%; display: flex; flex-direction: column; align-items: flex-end;">
        <h3> Enter the account email </h3>
        <form action="contact.php" method="post">
            <table>
                <tr>
                    <td><label for="accountName">Account Email:</label></td>
                    <td><input type="text" id="accountName" name="accountName" required></td>
                </tr>
            </table>
            <button type="submit">Submit</button>
        </form>
        <!-- Inside message.php -->
        <button id="toggleConnectionsBtn" onclick="toggleConnections()">Toggle Connections</button>
        <div id="connectionsContainer" style="display:none;">
            <iframe id="connectionsFrame" src="display_connections.php"></iframe>
        </div>

        <script>
            function toggleConnections() {
                var container = document.getElementById('connectionsContainer');
                container.style.display = container.style.display === 'none' ? 'block' : 'none';
            }
        </script>
    </div>
</div>

