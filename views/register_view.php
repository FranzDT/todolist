<?php
    session_start();
    
    if (isset($_SESSION['error']))
    {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
?>
<html>
    <head> 
        <title>Todolist Register</title>
    </head>
    <body>
        <form action="../process/register_process.php" method="POST">
            Username: <input type="text" name="username" required> <br>
            Email: <input type="email" name="email" required> <br>
            Password: <input type="password" name="password" required> <br>
            Confirm Password: <input type="password" name="password2" required><br>
            <input type="submit" value="register">
        </form>
    </body>
</html>