<?php
    $servername = "localhost";
    $db = "todolist";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
?>