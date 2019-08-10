<?php
    require "../functions/functions.php";
    $todo_id = $_GET['todoid'];

    if (isset($_GET['todo_id']))
    {
        if (checkTodo($todo_id))
        {
            setEditTodo($todo_id);
            header("Location: ../views/edit_todo_view.php");            
        }
        else
        {
            $_SESSION['error'] = "This site is restricted";
            header("Location: ../views/user_view.php");
        }
    }
    else
    {
        
    }
?>