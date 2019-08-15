<?php
    require "../functions/functions.php";
    checkLogin();

    $username = mysqli_real_escape_string($GLOBALS['conn'], $_POST['username']);
    $email = mysqli_real_escape_string($GLOBALS['conn'], $_POST['email']);
    
    if (checkEmail($_POST['email']))
    {
        if (checkUsername($_POST['username']))
        {
            if (editUser($username, $email))
            {
                setUserDetails($username);
                $_SESSION['action_message'] = "Successfully updated your profile";
            }
            else
            {
            }
        }
        else
        {
            $_SESSION['action'] = "edit";
            $_SESSION['action_message'] = "Username is taken";
        }
    }
    else
    {
        $_SESSION['action'] = "Edit Profile";
        $_SESSION['action_message'] = "Email is taken";
    }

    header("Location: ../views/userprofile_view.php");
?>