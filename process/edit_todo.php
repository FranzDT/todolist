<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {   
        $todo_id = $_GET['todoid'];
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
        $todo_title = $_POST['todo_title'];
        $todo_description = $_POST['todo_description'];
        if (editTodo($_SESSION['edit_todo_id'], $todo_title, $todo_description))
        {
            $_SESSION['action_message'] = "Successfully updated todo";
        }
        else
        {
            $_SESSION['action_message'] = "Successfully updated todo";
        }
        unset($_SESSION['edit_todo_id']);
        unset($_SESSION['edit_todo_title']);
        unset($_SESSION['edit_todo_description']);
        
        if ($_SESSION['user_role_id'] == 100)
        {
            header("Location: ../views/admin_viewuser_view.php");
        }
        else
        {
            header("Location: ../views/user_view.php");
        }
    }
?>