<?php
    session_start();
    require "../conn/conn.php";
    require_once('../SMTP.php');
    require_once('../PHPMailer.php');
    require_once('../Exception.php');

    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\Exception;

    function checkLogin()
    {
        if (!(isset($_SESSION['user_id'])))
        {
            header("Location: ../process/logout.php");
        }
    }

    function checkAdmin()
    {
        if (!(isset($_SESSION['user_role_id'])))
        {
            header("Location: ../process/logout.php");
        }
        else
        {
            if ($_SESSION['user_role_id'] != 100)
            {
                header("Location: ../process/logout.php");
            }
        }
    }

    function checkEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        if ($GLOBALS['conn']->query($sql)->num_rows == 0)
        {
            return true;
        }
        return false;
    }

    function checkUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        if ($GLOBALS['conn']->query($sql)->num_rows == 0)
        {
            return true;
        }
        return false;
    }

    function comparePass($password, $password2)
    {
        if ($password == $password2)
        {
            return true;
        }
        return false;
    }

    function registerUser($email, $username, $password, $vkey)
    {
        $sql = "INSERT INTO users(email, username, password, verify_code, email_verify,user_role_id, created_date)
                VALUES ('$email'
                , '$username'
                , '$password'
                , '$vkey'
                , 0
                , 200
                , (SELECT CURRENT_TIMESTAMP))";
        
        if ($GLOBALS['conn']->query($sql))
        {
            return true;
        }
        return false;
    }

    function sendVerificationCode($email, $vkey)
    {
        $mail=new PHPMailer(true); // Passing `true` enables exceptions

        try {
            //settings
            $mail->SMTPDebug=2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host='smtp.mail.yahoo.com';
            $mail->SMTPAuth=true; // Enable SMTP authentication
            $mail->Username='fst.todolist@yahoo.com'; // SMTP username
            $mail->Password='qwertyAgent123'; // SMTP password
            $mail->SMTPSecure='ssl';
            $mail->Port=465;

            $mail->setFrom('fst.todolist@yahoo.com', 'TodoList App Email Verification');

            //recipient
            $mail->addAddress($email, $email);     // Add a recipient

            //content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject='Todolist Email Verification';
            $mail->Body="<a href='http://localhost:8080/todolist/process/verification_process.php?vkey=$vkey'> Confirm Account</a>";
            $mail->AltBody='This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } 
        catch(Exception $e) {
            
        }

    }

    function checkVkey($vkey)
    {
        $sql = "SELECT * FROM users WHERE verify_code = '$vkey'";
        if ($GLOBALS['conn']->query($sql)->num_rows > 0)
        {
            return true;
        }
        return false;
    }

    function emailVerify($vkey)
    {
        $sql = "UPDATE users SET email_verify = 1 WHERE verify_code = '$vkey'";
        return $GLOBALS['conn']->query($sql);
    }

    function userVerified($username)
    {
        $sql = "SELECT email_verify FROM users WHERE username = '$username'";
        $result = $GLOBALS['conn']->query($sql);
        if ($row = $result->fetch_assoc())
        {   
            if ($row['email_verify'] == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    function passwordVerify($username, $password)
    {
        $sql = "SELECT password FROM users WHERE username = '$username'";
        $result = $GLOBALS['conn']->query($sql);
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                if (password_Verify($password, $row['password']))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    }

    function setUserDetails($username)
    {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $GLOBALS['conn']->query($sql);
        while ($row = $result->fetch_assoc())
        {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_role_id'] = $row['user_role_id'];
            $_SESSION['email'] = $row['email'];
        }
        $signin = "UPDATE users SET last_signin = (SELECT CURRENT_TIMESTAMP()) WHERE username = '$username'";
        $GLOBALS['conn']->query($signin);
    }

    function fetchTodoBacklog($user_id)
    {
        $sql = "SELECT * FROM todo WHERE user_id = $user_id AND todo_status = 'backlog'";
        return $GLOBALS['conn']->query($sql);
    }
    
    function fetchTodoProgress($user_id)
    {
        $sql = "SELECT * FROM todo WHERE user_id = $user_id AND todo_status = 'progress'";
        return $GLOBALS['conn']->query($sql);
    }
    
    function fetchTodoDone($user_id)
    {
        $sql = "SELECT * FROM todo WHERE user_id = $user_id AND todo_status = 'done'";
        return $GLOBALS['conn']->query($sql);
    }

    function addTodo($user_id, $todo_title, $todo_description)
    {
        $sql = "INSERT INTO todo (todo_title, todo_description, todo_status, user_id, created_date)
                VALUES('$todo_title'
                , '$todo_description'
                , 'backlog'
                , '$user_id'
                , (SELECT CURRENT_TIMESTAMP)
                )";
        return $GLOBALS['conn']->query($sql);
    }

    function checkTodo($todo_id)
    {
        $sql = "SELECT todo_id FROM todo WHERE todo_id = $todo_id";
        $sql2 = "SELECT user_id FROM todo WHERE todo_id = $todo_id";
        $result = $GLOBALS['conn']->query($sql2);
        if ($GLOBALS['conn']->query($sql)->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                if (isset($_SESSION['adminview_userid']))
                {
                    if ($row['user_id'] == $_SESSION['adminview_userid'])
                    {
                        return true;
                    }
                }
                else
                {
                    if ($row['user_id'] == $_SESSION['user_id'])
                    {
                        return true;
                    }
                }
                
            }
        }
        return false;
    }

    function setEditTodo($todo_id)
    {
        $sql = "SELECT todo_id, todo_title, todo_description FROM todo WHERE todo_id = $todo_id";
        $result = $GLOBALS['conn']->query($sql);
        while ($row = $result->fetch_assoc())
        {
            $_SESSION['edit_todo_id'] = $row['todo_id'];
            $_SESSION['edit_todo_title'] = $row['todo_title'];
            $_SESSION['edit_todo_description'] = $row['todo_description'];
        }
    }

    function editTodo($todo_id, $todo_title, $todo_description)
    {
        $sql = "UPDATE todo SET todo_title = '$todo_title', todo_description = '$todo_description' WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function verifyUserTodo($todo_id)
    {
        $sql = "SELECT user_id FROM todo WHERE todo_id";
        $result = $GLOBALS['conn']->query($sql);
        while ($row = $result->fetch_assoc())
        {
            if ($row['user_id'] == $_SESSION['user_id'])
            {
                return true;
            }
        }
        return false;
    }

    function deleteTodo($todo_id)
    {
        $sql = "DELETE FROM todo WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function setAddList($todo_id)
    {
        $sql = "SELECT * FROM todo WHERE todo_id = $todo_id";
        $result = $GLOBALS['conn']->query($sql);
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $_SESSION['addlist_userid'] = $row['user_id'];
                $_SESSION['addlist_todoid'] = $todo_id;
                return true;
            }
        }
        return false;
    }

    function addList($list_name)
    {
        $todo = $_SESSION['addlist_todoid'];
        $user = $_SESSION['addlist_userid'];
        $sql = "INSERT INTO list(list_name, todo_id, user_id, list_status, created_date) 
        VALUES('$list_name', $todo, $user, 'inprogress', (SELECT CURRENT_TIMESTAMP))";
        return $GLOBALS['conn']->query($sql);
    }

    function getList($todo_id)
    {
        $sql = "SELECT list_name, list_status, list_id FROM list WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function setTodoProgress($todo_id)
    {
        $sql = "UPDATE todo SET todo_status ='progress' WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function setTodoDone($todo_id)
    {
        $sql = "UPDATE todo SET todo_status ='done' WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function setTodoBacklog($todo_id)
    {
        $sql = "UPDATE todo SET todo_status ='backlog' WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

    function fetchUsers()
    {
        $sql = "SELECT user_id, username, email, user_role_id, email_verify, created_date, last_signin FROM users ";
        return $GLOBALS['conn']->query($sql);
    }

    function listDone($list_id)
    {
        $sql="UPDATE list SET list_status = 'done' WHERE list_id = $list_id";
        return $GLOBALS['conn']->query($sql);
    }

    function checkAllList($todo_id)
    {
        $sql = "SELECT list_id FROM list WHERE list_status = 'inprogress' AND todo_id = $todo_id";
        if ($GLOBALS['conn']->query($sql)->num_rows == 0)
        {
            return true;
        }
        return false;
    }

    function editUser($username, $email)
    {
        $id = $_SESSION['user_id'];
        $sql = "UPDATE users SET username = '$username', email = '$email' WHERE user_id = $id";
        return $GLOBALS['conn']->query($sql);
    }

    function changePassword($password)
    {
        $id = $_SESSION['user_id'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$password' WHERE user_id = $id";
        return $GLOBALS['conn']->query($sql);
    }

    function deleteUser($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = $user_id";
        $GLOBALS['conn']->query($sql);
    }

    function adminSetUser($user_id)
    {
        $sql = "SELECT user_id, email, username, email_verify FROM users WHERE user_id = $user_id";
        $result = $GLOBALS['conn']->query($sql);
        while ($row = $result->fetch_assoc())
        {
            $_SESSION['edit_user_id'] = $row['user_id'];
            $_SESSION['edit_user_email'] = $row['email'];
            $_SESSION['edit_user_username'] = $row['username'];
            $_SESSION['edit_user_email_verify'] = $row['email_verify'];
        }
    }

    function adminEditUser($username, $email, $email_verify)
    {
        $id = $_SESSION['edit_user_id'];
        $sql = "UPDATE users SET username ='$username', email = '$email', email_verify = $email_verify WHERE user_id = $id";
        $GLOBALS['conn']->query($sql);
    }
?>