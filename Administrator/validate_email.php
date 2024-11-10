<?php
// validate_email.php
require_once "../connectionDB.php"; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Validar el formato del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Formato de correo electrónico inválido.']);
        exit();
    }

    try {
        // Crear conexión a la base de datos
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar la consulta para contar los correos electrónicos que coinciden
        $stmt = $conn->prepare("SELECT COUNT(*) FROM empleados WHERE correo = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Obtener el conteo de correos electrónicos
        $count = $stmt->fetchColumn();

        // Verificar si el correo electrónico ya existe
        if ($count > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }

    // Cerrar la conexión
    $conn = null;
} else {
    echo json_encode(['error' => 'Método de solicitud no permitido.']);
}
?>