<?php
    require "../functions/functions.php";

    $oldpass = mysqli_real_escape_string($GLOBALS['conn'], $_POST['oldpassword']);
    $password = mysqli_real_escape_string($GLOBALS['conn'], $_POST['newpassword']);
    $password2 = mysqli_real_escape_string($GLOBALS['conn'], $_POST['newpassword2']);

    if (passwordVerify($_SESSION['username'], $oldpass))
    {
        if (comparePass($password, $password2))
        {
            if (changePassword($password))
            {   
                $_SESSION['action_message'] = "Successfully changed your password";
            }
            else
            {
                $_SESSION['action_message'] = "There was an error in changing your password";
            }
        }
        else
        {
            $_SESSION['action_message'] = "New password did not match";
        }
    }
    else
    {
        $_SESSION['action_message'] = "Old password is incorrect";
    }
    header("Location: ../views/userprofile_view.php");  
?>