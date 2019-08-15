<?php
    require "../functions/functions.php";
    checkLogin();
    checkAdmin();

    if (isset($_GET['userid']))
    {
        
    }
    else
    {
        header("Location: ../views/admin_view.php");
    }
?>