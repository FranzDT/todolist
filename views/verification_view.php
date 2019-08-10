<?php
    session_start();
?>
<html>
    <head>
        <title>Verification Code</title>
    </head>
    <body>
        <?php
            echo $_SESSION['vkey_message'];
            session_destroy();
        ?>
    </body>
</html>