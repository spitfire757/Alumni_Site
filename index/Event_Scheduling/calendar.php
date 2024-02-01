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
                            <a href = "../Interface/help.php">Help</a>
                        </td>
                        <td>
                            <a href = "../Meeting_Social/message.php">Message</a>
                        </td>
                        <td>
                            <a href = "../Meeting_Social/forum.php">Forum</a>
                        </td>
                        <td>
                            <a href = "calendar.php">Calendar</a>
                        </td>
                        <td>
                            <a href = "../Authentication_Login/profile.php">Profile</a>
                        </td>
                    </tr>
                </table>
            </nav>
        </div>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>jQuery UI Datepicker - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );
        </script>
        </head>
        <body>
 
        <p>Select a Date: <input type="text" id="eventDate" name="eventDate"></p>
    <?php

    ?>
    </body>
    
</html>
