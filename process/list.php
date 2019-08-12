<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_GET['todoid']))
    {
        if (checkList($_GET['todo_id']))
        {
            
        }
        else
        {

        }
    }
    else
    {

    }
?>