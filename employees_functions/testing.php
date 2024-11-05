<?php
require_once "../connectionDB.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Receiving Data...
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        $full_name = $name . " " . $surname;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el empleado
        $stmt = $conn->prepare("INSERT INTO empleados (nombre, correo, rol, contra) VALUES (:fullname, :email, :rol, :password)");
        $stmt->bindParam(':fullname', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        // Obtener el ID del empleado recién insertado
        $employeeId = $conn->lastInsertId();

        // Manejo de la foto
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo = $_FILES['photo'];
            $originalName = $photo['name'];
            $tempPath = $photo['tmp_name'];

            // Generar un nombre encriptado para la foto
            $encryptedName = md5(uniqid(rand(), true)) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
            $uploadDir = '../uploads/';
            $destinationPath = $uploadDir . $encryptedName;

            // Mover el archivo subido
            if (move_uploaded_file($tempPath, $destinationPath)) {
                // Guardar los nombres de la foto en la base de datos
                $stmt = $conn->prepare("UPDATE empleados SET foto_nombre = :originalName, foto_encryp = :encryptedName WHERE id = :employeeId");
                $stmt->bindParam(':originalName', $originalName);
                $stmt->bindParam(':encryptedName', $encryptedName);
                $stmt->bindParam(':employeeId', $employeeId);
                $stmt->execute();
            } else {
                echo "Error al mover el archivo de la foto.";
            }
        }

        // Redirigir a la lista de empleados
        header("Location: employees_list.php");
        exit();
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
