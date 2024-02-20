<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/global_style.css">
    </head>
    <body>
        <div>
            <?php
                session_start();
                $reponses = $_SESSION['responses'];
                echo $responses["replies"];
            ?>
        </div>
    </body>
<html>