<?php
    session_start();
?>
<html>
    <head>
        <title>Add Todo</title>
    </head>
    <body>
        <form action="../process/add_todo_process.php" method="POST">
            <input type="text" name="todo_title"> <br>
            <input type="text" name="todo_description"> <br>
            <input type="submit" value="Add Task">
        </form>
    </body>
</html>