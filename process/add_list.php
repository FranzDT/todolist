<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {   
        $todo_id = mysqli_real_escape_string($GLOBALS['conn'], $_GET['todoid']);
        if (checkTodo($todo_id))
        {
            setAddList($todo_id);
            header("Location: ../views/add_list_view.php");
        }
    }
    else
    {
        if (isset($_POST['list_name']))
        {
            $list_name = mysqli_real_escape_string($GLOBALS['conn'], $_POST['list_name']);

            if (checkList($list_name))
            {   
                header("Location: ../views/add_list_view.php");
            }
            else
            {
                $_SESSION['error'] = "Something went wrong. Please try again<br>";
                header("Location: ../views/add_list_view.php");
            }
        }
        else
        {
            $_SESSION['error'] = "Something went wrong. Please try again<br>";
            header("Location: ../views/add_list_view.php");
        }
    }
?>