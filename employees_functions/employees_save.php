<?php
    require_once "../connectionDB.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //Receiving Data...
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $rol = $_POST['rol'];

            $full_name = $name ." ". $surname;
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO empleados (nombre, correo, rol, contra) VALUES (:fullname, :email, :rol, :password)");
            $stmt->bindParam(':fullname', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            header("Location: employees_list.php");
            exit();
        } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $conn = null;
        }
    ?>