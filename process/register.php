<?php
    require "../conn/conn.php";
    require "../functions/functions.php";

    $username = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
    $email = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
    $password = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password']);
    $password2 = mysqli_real_escape_string($GLOBALS['conn'], $_POST['password2']);

    
    if (checkEmail($email))
    {
        if (checkUsername($username))
        {
            if (comparePass($password, $password2))
            {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $vkey = md5(time().$username);
                if (registerUser($email, $username, $password, $vkey))
                {
                    if (sendVerificationCode($email, $vkey))
                    {
                        $_SESSION['action_message'] = "Successfully added user";
                    }
                }
                else
                {
                    $_SESSION['error'] = "Something went wrong, please try again.";
                }
            }
            else
            {
                $_SESSION['error'] = "Password did not match";
            }
        }
        else
        {
            $_SESSION['error'] = "Username is already used. Please use another username";
        }
    }
    else
    {
        $_SESSION['error'] = "Email is already registered. Please use another email";
    }

    if (isset($_SESSION['user_role_id']))
    {
        if ($_SESSION['user_role_id'] == 100)
        {
            header("Location: ../views/admin_view.php");
        }
        else
        {   
            header("Location: ../views/register_view.php");
        }
    }
?>