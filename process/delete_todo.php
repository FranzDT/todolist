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
                header("Location: ../views/user_view.php");  
            }
            else
            {
                $_SESSION['error'] = "Failed to delete todo<br>";
                header("Location: ../views/user_view.php");  
            }
        }
        else
        {
            $_SESSION['error'] = "Page not found<br>";
            header("Location: ../views/user_view.php");    
        }
    }
    else
    {
        header("Location: ../views/user_view.php");
    }
?>