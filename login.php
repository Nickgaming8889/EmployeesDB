<?php
function hashPassword($password) {
    return hash('sha256', $password);
}

function verifyPassword($username, $password) {
    // Conectar a la base de datos usando PDO
    $dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8';
    $user = 'nicholas';
    $pass = '1968';

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar la consulta
        $stmt = $pdo->prepare("SELECT contra FROM empleados WHERE correo = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Verificar si se encontró el usuario
        if ($stmt->rowCount() > 0) {
            $storedPasswordHash = $stmt->fetchColumn();

            // Hashear el password ingresado
            $inputPasswordHash = hashPassword($password);

            // Comparar los hashes
            if ($inputPasswordHash === $storedPasswordHash) {
                echo "Password correcto";
            } else {
                echo $inputPasswordHash;
                echo "Password incorrecto";
            }
        } else {
            echo "Usuario no encontrado";
        }

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}

// Ejemplo de uso
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Asegúrate de sanitizar esta entrada
    $password = $_POST['password']; // Asegúrate de sanitizar esta entrada
    verifyPassword($username, $password);
}
?>