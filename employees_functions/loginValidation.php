<?php
    require_once "../connectionDB.php"; // Asegúrate de que esta ruta sea correcta

    header('Content-Type: application/json');

    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Crear una nueva conexión PDO
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar la consulta para verificar el usuario
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE email = :email AND password = :password AND activo = 1 AND eliminado = 0");
            $stmt->bindParam(':email', $email);
            // Aquí debes encriptar la contraseña antes de compararla, por ejemplo, usando password_hash() y password_verify()
            $stmt->bindParam(':password', $password); // Asegúrate de que la contraseña esté encriptada en la base de datos
            $stmt->execute();

            // Verificar si el usuario existe
            if ($stmt->fetch()) {
                echo json_encode(['status' => 'exists']);
            } else {
                echo json_encode(['status' => 'not_exists', 'message' => 'Usuario no encontrado o inactivo.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
    }
?>