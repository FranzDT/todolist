<?php
    require "../functions/functions.php";
    checkLogin(); 
    checkAdmin();
    
    if (isset($_GET['userid']))
    {
        $_SESSION['adminview_userid'] = $_GET['userid'];
        header("Location: ../views/admin_viewuser_view.php");
    }
?>