<?php
    require "../functions/functions.php";

    checkLogin();

    $todo_title = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_title']);
    $todo_description = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_description']);

    if (addTodo($_SESSION['user_id'], $todo_title, $todo_description))
    {
        $_SESSION['action_message'] = "Successfully added todo";
        header("Location: ../views/user_view.php");
    }
    else
    {
        $_SESSION['action_message'] = "Failed to add task";
        header("Location: ../views/user_view.php");
    }
?>