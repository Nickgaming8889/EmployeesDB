<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $dbname";
        $result = $conn->query($sql);
    }
    catch (PDOException $e) {        
    }

    $conn = null;
?>