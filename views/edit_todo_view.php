<?php
    require "../functions/functions.php";
    checkLogin();
?>
<html>
    <head>
        <title>Edit Todo</title>
    </head>
    <body>
        <form action="../process/edit_todo.php" method="POST">
            <input type="text" name="todo_title"  placeholder="<?php echo $_SESSION['edit_todo_title']; ?>" value="<?php echo $_SESSION['edit_todo_title']; ?>"> <br>
            <input type="text" name="todo_description" placeholder="<?php echo $_SESSION['edit_todo_description']; ?>" value="<?php echo $_SESSION['edit_todo_description'] ?>"> <br>
            <input type="submit" value="Update">
        </form>
    </body>
</html>
