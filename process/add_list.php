<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {   
        $todo_id = mysqli_real_escape_string($GLOBALS['conn'], $_GET['todoid']);
        if (checkTodo($todo_id))
        {
            if (setAddList($todo_id))
            {             
                header("Location: ../views/add_list_view.php");
            }
            else
            {
                $_SESSION['error'] = "You don't have access rights for this. <br>";
                header("Location: ../views/add_list_view.php");
            }
        }
        else
        {
            $_SESSION['error'] = "You don't have access rights for this. <br>";
            header("Location: ../views/user_view.php");
        }
    }
    else
    {
        if (isset($_POST['list_name']))
        {
            $list_name = mysqli_real_escape_string($GLOBALS['conn'], $_POST['list_name']);

            if (addList($list_name))
            {   
                die("here");
                if ($_SESSION['user_role_id'] == 100)
                {
                    header("Location: ../views/admin_viewuser_view");
                }
                else
                {
                    header("Location: ../views/user_view.php");
                }
            }
            else
            {
                $_SESSION['error'] = "Something went wrong. Please try again<br>";
                if ($_SESSION['user_role_id'] == 100)
                {
                    header("Location: ../views/admin_viewuser_view");
                }
                else
                {
                    header("Location: ../views/user_view.php");
                }
            }
        }
        else
        {
            $_SESSION['error'] = "Something went wrong. Please try again<br>";
            if ($_SESSION['user_role_id'] == 100)
                {
                    header("Location: ../views/admin_viewuser_view");
                }
                else
                {
                    header("Location: ../views/user_view.php");
                }
        }
    }
?>