<?php
    require_once "../connectionDB.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("UPDATE empleados SET eliminar = 1 WHERE id = :idEmpleado");
            $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: employees_list.php");
            exit();
        } catch (PDOException $e) {
            echo "Error". $e->getMessage();
        }
    }
?>