<?php
    require "../functions/functions.php";

    if (isset($_GET['vkey']))
    {
        if (checkVkey($_GET['vkey']))
        {   
            if (emailVerify($_GET['vkey']))
            {
                $_SESSION['vkey_message'] ="SUCCESS";
            }
        }
        else
        {
            $_SESSION['vkey_message'] ="FAIL";
        }
    }
    else
    {
        $_SESSION['vkey_message'] ="FAIL";
    }
    header("Location: ../views/verification_view.php");
?>