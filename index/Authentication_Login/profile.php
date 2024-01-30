<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        
        <div>
            <nav>
                <table>
                    <tr>
                        <td>
                            <a href = "../help.php">Help</a>
                        </td>
                        <td>
                            <a href = "../message.php">Message</a>
                        </td>
                        <td>
                            <a href = "../forum.php">Forum</a>
                        </td>
                        <td>
                            <a href = "../calendar.php">Calendar</a>
                        </td>
                        <td>
                            <a href = "../profile.php">Profile</a>
                        </td>
                    </tr>
                </table>
            </nav>
        </div>
<img src="avatar.png" alt="Avatar" class="avatar">
<br>
<form action="edit_profile.php" method="get">
<button type="submit">Edit Profile</button>
</form>
<?php
    echo "<br> Username <br>";
    echo "Password <br>";
    echo "Major <br>";
    echo "Minor <br>";
    echo "About <br>";
    echo "Experience <br>";
    echo "Resume <br>";
?>

</body>
</html>

