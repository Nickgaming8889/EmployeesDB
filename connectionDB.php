<?php
    try {
        $servername = "127.0.0.1";
        $username = "nicholas";
        $password = "1968";
        $dbname = "test";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: ". $e->getMessage();
    }
?>