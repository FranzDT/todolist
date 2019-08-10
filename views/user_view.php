<?php
    require "../functions/functions.php";
?>
<html>
    <head>
        <title>User View</title>
    </head>
    <body>
        Welcome, <?php echo $_SESSION['username'];?> <br>
        <a href="../process/logout.php">Logout</a>
        <?php
            if ($_SESSION['user_role_id'] == 200)
            {
                
            }
            else
            {

            }
        ?>
    </body>
</html>