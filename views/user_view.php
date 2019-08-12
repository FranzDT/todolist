<?php
    require "../functions/functions.php";
    checkLogin();

    if (isset($_SESSION['action_message']))
    {
        echo $_SESSION['action_message'];
        unset($_SESSION['action_message']);
    }

    if (isset($_SESSION['error']))
    {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
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
            // USER
            if ($_SESSION['user_role_id'] == 200)
            {
                $result = fetchTodo($_SESSION['user_id']);
                if ($result->num_rows > 0)
                {
                    echo "<table>
                                <tr>
                                    <th>todo title</th>
                                    <th>todo description</th>
                                    <th>Add List</th>
                                    <th>Delete</th>
                                </tr>"; 
                    while ($row = $result->fetch_assoc())
                    {
        ?>
                            <tr>
                                <td><a href="../process/edit_todo.php?todoid=<?php echo $row['todo_id'] ?>"><?php echo $row['todo_title']; ?></a></td>
                                <td><?php echo $row['todo_description']; ?></td>
                                <td><a href="../process/add_list.php?todoid=<?php echo $row['todo_id']; ?>">&plus;</a></td>
                                <td><a href="../process/delete_todo.php?todoid=<?php echo $row['todo_id']; ?>">&times;</a></td>
                            </tr>
        <?php              
                    }
                    echo "</table>";
                }
                else
                {

                }
            }
            // ADMIN
            else
            {

            }
        ?>
    </body>
</html>