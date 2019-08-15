<?php   
    require "../functions/functions.php";
    checkLogin();
    checkAdmin();

    if (isset($_GET['userid']))
    {
        adminSetUser($_GET['userid']);
        header("Location: ../views/admin_edituser_view.php");
    }
    else
    {
        if (isset($_POST['email']))
        {
            $email = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
            $username = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
            $email_verify = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email_verify']);
            if ($_SESSION['edit_user_username'] == $username)
            {
                if ($_SESSION['edit_user_email'] == $email)
                {
                    if ($_SESSION['edit_user_email_verify'] == $email_verify)
                    {
                        header("Location: ../views/admin_edituser_view.php");
                    }
                    else
                    {
                        adminEditUser($username, $email, $email_verify);
                        $_SESSION['admin_edit_user'] = "Successfully Updated User";
                        header("Location: ../views/admin_view.php");
                    }
                }
                else
                {
                    if (checkEmail($email))
                    {
                        adminEditUser($username, $email, $email_verify);
                        $_SESSION['admin_edit_user'] = "Successfully Updated User";
                        header("Location: ../views/admin_view.php");
                    }
                    else
                    {
                        $_SESSION['admin_edit_user'] = "Email is already taken";
                        header("Location: ../views/admin_edituser_view.php");
                    }
                }

            }
            else
            {
                if (checkUsername($username))
                {
                    if ($_SESSION['edit_user_email'] == $email)
                    {
                        adminEditUser($username, $email, $email_verify);
                        $_SESSION['admin_edit_user'] = "Successfully Updated User";
                        header("Location: ../views/admin_view.php");
                    }
                    else
                    {
                        if (checkEmail($email))
                        {
                            adminEditUser($username, $email, $email_verify);
                            $_SESSION['admin_edit_user'] = "Successfully Updated User";
                            header("Location: ../views/admin_view.php");
                        }
                        else
                        {
                            $_SESSION['admin_edit_user'] = "Email is already taken";
                            header("Location: ../views/admin_edituser_view.php");
                        }
                    }
                }
                else
                {
                    $_SESSION['admin_edit_user'] = "Username is already taken";
                    header("Location: ../views/admin_edituser_view.php");
                }

            }
        }

        else
        {
            if (isset($_SESSION['edit_user_email']))
            {
                header("Location: ../views/admin_edituser_view.php");
            }
            else
            {
                    header("Location: ../views/admin_view.php");
            }

        }
    }
?>