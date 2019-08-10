<?php
    session_start();
    require "../conn/conn.php";

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
?>