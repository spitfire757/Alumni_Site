<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <?php 
                session_start();
                echo $_SESSION['responses'];
            ?>
        </div>
    </body>
<html>