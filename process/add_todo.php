<?php
    require "../functions/functions.php";

    checkLogin();

    $todo_title = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_title']);
    $todo_description = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_description']);
    
    if ($_SESSION['user_role_id'] == 100)
    {
        if (addTodo($_SESSION['adminview_userid'], $todo_title, $todo_description))
        {
            $_SESSION['action_message'] = "Successfully added todo";
        }
        else
        {
            $_SESSION['action_message'] = "Failed to add task";
        }
            header("Location: ../views/admin_viewuser_view.php");
    }
    else
    {
        if (addTodo($_SESSION['user_id'], $todo_title, $todo_description))
        {
            $_SESSION['action_message'] = "Successfully added todo";
        }
        else
        {
            $_SESSION['action_message'] = "Failed to add task";
        }
        header("Location: ../views/user_view.php");
    }
?>