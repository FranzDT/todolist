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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>User View</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
    </head>
    <body id="page top">
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
                                    <th>List</th>
                                    <th>Delete</th>
                                </tr>"; 
                    while ($row = $result->fetch_assoc())
                    {
        ?>
                            <tr>
                                <td><a href="../process/edit_todo.php?todoid=<?php echo $row['todo_id'] ?>"><?php echo $row['todo_title']; ?></a></td>
                                <td><?php echo $row['todo_description']; ?></td>
                                <td><a href="../process/add_list.php?todoid=<?php echo $row['todo_id']; ?>">&plus;</a></td>
                                <td><a href="../process/list.php?todo=<?php echo $row['todo_id']; ?>">View List</a></td>
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