<?php
    session_start();
    if (!(isset($_SESSION['user_id'])))
    {
        header("Location: ../process/logout.php");
    }
?>
<html>
    <head>
        <title>Add Todo</title>
    </head>
    <body>
        <form action="../process/add_todo.php" method="POST">
            <input type="text" name="todo_title"> <br>
            <input type="text" name="todo_description"> <br>
            <input type="submit" value="Add Task">
        </form>
    </body>
</html>