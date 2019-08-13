<?php
    require "../functions/functions.php";

    if (isset($_POST['username']))
    {
        $username = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
        if (checkUsername($_POST['username']) === false)
        {
            if (userVerified($username))
            {
                $_SESSION['login_username'] = $username;
                header("Location: ../views/login_view.php");
            }
            else
            {
                $_SESSION['error'] = "Username is not yet verified. Please check your email to verify your account";
                header("Location: ../views/login_view.php");
            }
        }
        else
        {
            $_SESSION['error'] = "Username is not registered";
            header("Location: ../views/login_view.php");
        }
    }
    else
    {
        $password = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);
        if (passwordVerify($_SESSION['login_username'], $password))
        {
            setUserDetails($_SESSION['login_username']);
            unset($_SESSION['login_username']);
            if ($_SESSION['user_role_id'] == 100)
            {
                header("Location: ../views/admin_view.php");
            }
            else
            { 
                header("Location: ../views/user_view.php");
            }
        }
        else
        {
            $_SESSION['error'] = "Invalid Password";
            header("Location: ../views/login_view.php");
        }
    }
?>