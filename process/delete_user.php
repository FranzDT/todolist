<?php
    require "../functions/functions.php";
    checkLogin();
    checkAdmin();

    if (isset($_GET['userid']))
    {
        deleteUser($_GET['userid']);
    }
    header("Location: ../views/admin_view.php");
?>