<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {
        if (setTodoProgress($_GET['todoid']))
        {
            $_SESSION['action_message'] = "Successful";
            header("Location: ../views/user_view.php");
        }
        else
        {
            $_SESSION['action_message'] = "Successful";
            header("Location: ../views/user_view.php");
        }
    }
    else
    {
        $_SESSION['action_message'] = "Successful";
        header("Location: ../views/user_view.php");
    }
?>