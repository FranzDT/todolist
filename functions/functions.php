<?php
    session_start();
    require "../conn/conn.php";

    function checkLogin()
    {
        if (!(isset($_SESSION['user_id'])))
        {
            header("Location: ../process/logout.php");
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
        $subject = "Todolist Email Verification";
        $message = "<a href='http://localhost/todolist/process/verification_process.php?vkey=$vkey'> Confirm Account</a>";
        $headers = "From: fst.todolist@yahoo.com \r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        return mail($email, $subject, $message, $headers);
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
        }
        $signin = "UPDATE users SET last_signin = (SELECT CURRENT_TIMESTAMP()) WHERE username = '$username'";
        $GLOBALS['conn']->query($signin);
    }

    function fetchTodo($user_id)
    {
        $sql = "SELECT * FROM todo WHERE user_id = $user_id";
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
        $sql = "SELECT list_name, list_status FROM list WHERE todo_id = $todo_id";
        return $GLOBALS['conn']->query($sql);
    }

?>