<?php
    require "../functions/functions.php";
    checkLogin();


    if (isset($_GET['todoid']))
    {
        if (setTodoBacklog($_GET['todoid']))
        {
            $_SESSION['action_message'] = "Successful";
        }
        else
        {
            $_SESSION['action_message'] = "Successful";
        }
    }
    else
    {
        $_SESSION['action_message'] = "Successful";
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