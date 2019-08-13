<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {
        $todo_id = mysqli_real_escape_string($GLOBALS['conn'], $_GET['todoid']);
        if (checkTodo($todo_id))
        {
            if (deleteTodo($todo_id))
            {
                $_SESSION['action_message'] = "Successfully deleted todo <br>";
            }
            else
            {
                $_SESSION['error'] = "Failed to delete todo<br>";
            }
        }
        else
        {
            $_SESSION['error'] = "Page not found<br>"; 
        }
    }
    else
    {
        header("Location: ../views/user_view.php");
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