<?php
    require "../functions/functions.php";

?>
<html>
    <head>
        <title>Edit Todo</title>
    </head>
    <body>
        <form action="../process/edit_todo_process.php" method="POST">
            <input type="text" name="todo_title" placeholder="<?php echo $_SESSION['todo_title']; ?>" value="<?php echo $_SESSION['todo_tile'] ?>"> <br>
            <input type="text" name="todo_description" placeholder="<?php echo $_SESSION['todo_description']; ?>" value="<?php echo $_SESSION['todo_description'] ?>"> <br>
            <input type="submit" value="Update">
        </form>
    </body>
</html>
