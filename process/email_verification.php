<?php
    session_start();
    require "../functions/functions.php";
    
    $vkey = $_GET['vkey'];
    if (checkVkey($vkey))
    {
        if (emailVerify($vkey))
        {
            $_SESSION['vkey_status'] = true;
            $_SESSION['vkey_message'] = "Succesfully verified your email. Thank you!";
        }
        else
        {
            $_SESSION['vkey_status'] = false;
            $_SESSION['vkey_message'] = "Something went wrong with our servers. Please try again.";
        }
    }
    else
    {
        $_SESSION['vkey_status'] = false;
        $_SESSION['vkey_message'] = "Your verification code is incorrect";
    }
    header("Location: ../views/verification_view.php");
?>