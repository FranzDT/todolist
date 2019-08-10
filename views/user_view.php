<?php
    require "../functions/functions.php";

    if (isset($_SESSION['addtodo_message']))
    {
        echo $_SESSION['addtodo_message'];
    }

    if (!(isset($_SESSION['user_id'])))
    {
        header("Location: ../process/logout.php");
    }
    else
    {
        if (isset($_SESSION['error']))
        {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }
?>
<html>
    <head>
        <title>User View</title>
    </head>
    <body>
        Welcome, <?php echo $_SESSION['username'];?> <br>
        <a href="../process/logout.php">Logout</a> <br>
        <a href="../views/add_todo_view.php">&plus; Add Todo</a>
        <?php
            if ($_SESSION['user_role_id'] == 200)
            {
                $result = fetchTodo($_SESSION['user_id']);
                if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
        ?>
                        <table>
                            <tr>
                                <th>todo title</th>
                                <th>todo description</th>
                                <th>delete</th>
                                <th>edit</th>
                            </tr>
                        <?php
                            while ($row = $result->fetch_assoc())
                            {    
                        ?>
                            <tr>
                                <th><?php echo $row['todo_title']; ?></th>
                                <th><?php echo $row['todo_description']; ?></th>
                                <th><a href="../process/edit_todo_process.php?todoid=<?php echo $row['todo_id']; ?>"></a></th>
                            </tr>
                        <?php
                            }
                        ?>
                        </table>
        <?php              
                    }
                }
                else
                {

                }
            }
            else
            {

            }
        ?>
    </body>
</html>