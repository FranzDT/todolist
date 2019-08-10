<?php
    require "../functions/functions.php";

    $todo_title = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_title']);
    $todo_description = mysqli_real_escape_string($GLOBALS['conn'], $_POST['todo_description']);

    if (addTodo($_SESSION['user_id'], $todo_title, $todo_description))
    {
        $_SESSION['addtodo_message'] = "Successfully added todo";
        header("Location: ../views/user_view.php");
    }
    else
    {
        $_SESSION['addtodo_message'] = "Failed to add task";
        header("Location: ../views/user_view.php");
    }
?>