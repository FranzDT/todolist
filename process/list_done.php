<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['listid']))
    {
        if (listDone($_GET['listid']))
        {     
            $_SESSION['action_message']="Update successful";
        }
        else
        {
            $$_SESSION['action_message']="Update failed";
        }
    }
    
    if ($_SESSION['user_role_id'] == 100)
    {
        header("Location: ../views/admin_viewuser_view.php");
    }
    else
    {
        header("Location: ../views/user_view.php");
    }
?>