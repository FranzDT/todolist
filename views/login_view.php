<?php
    session_start();
    if (isset($_SESSION['error']))
    {
        if (isset($_SESSION['login_username']))
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            $label = "Password: ";
            $input_type = "password";
            $input_name = "password";
            $submit_value = "Confirm Password";
        }
        else
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            $label = "Username: ";
            $input_type = "text";
            $input_name = "username";
            $submit_value = "Confirm Username";
        }
    }
    else
    {
        if (isset($_SESSION['login_username']))
        {
            $label = "Password: ";
            $input_type = "password";
            $input_name = "password";
            $submit_value = "Confirm Password";
        }
        else
        {
            $label = "Username: ";
            $input_type = "text";
            $input_name = "username";
            $submit_value = "Confirm Username";
        }
    }
?>
<html>
    <head>
        <title>Todolist Login</title>
    </head>
    <body>
        <form action="../process/login_process.php" method="POST">
            <label for="this"><?php echo $label;?></label><br>
            <input type="<?php echo $input_type ?>" name="<?php echo $input_name ?>" required><br>
            <input type="submit" value="<?php echo $submit_value; ?>">
        </form>
    </body>
</html>