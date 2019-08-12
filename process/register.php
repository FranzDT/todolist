<?php
    session_start();
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

                        echo $vkey;
                    }
                    else
                    {
                        echo "fail";
                    }
                }
                else
                {
                    echo "fail";
                }
            }
            else
            {
                $_SESSION['error'] = "Password did not match";
                header("Location: ../views/register_view.php");
            }
        }
        else
        {
            $_SESSION['error'] = "Username is already used. Please use another username";
            header("Location: ../views/register_view.php"); 
        }
    }
    else
    {
        $_SESSION['error'] = "Email is already registered. Please use another email";
        header("Location: ../views/register_view.php");
    }
?>