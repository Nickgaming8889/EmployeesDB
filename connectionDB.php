<?php
    $servername = "127.0.0.1";
    $username = "nicholas";
    $password = "1968";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE $dbname";
        $result = $conn->query($sql);
        echo "Connection Successfully";
    }
    catch (PDOException $e) {
        echo "Connection Failed: ". $e->getMessage();
    }

    $conn = null;
?>