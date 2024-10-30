<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si no hay sesión, redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Aquí puedes incluir la lógica para obtener información del usuario si es necesario
// Por ejemplo, puedes hacer una consulta a la base de datos para obtener detalles del usuario

require_once "../connectionDB.php"; // Asegúrate de que esta ruta sea correcta

try {
    // Crear conexión a la base de datos
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener información del usuario
    $stmt = $conn->prepare("SELECT * FROM empleados WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Verificar si el usuario existe
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de tener un archivo CSS si es necesario -->
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?>!</h1> <!-- Suponiendo que 'nombre' es un campo en la base de datos -->
        <nav>
            <ul>
                <li><a href="logout.php">Cerrar sesión</a></li>
                <!-- Agrega más enlaces según sea necesario -->
            </ul>
        </nav>
    </header>
    <main>
        <h2>Información del Usuario</h2>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['correo']); ?></p>
        <p><strong>Rol:</strong> <?php echo htmlspecialchars($user['rol']); ?></p> <!-- Suponiendo que 'rol' es un campo en la base de datos -->
        <!-- Agrega más información según sea necesario -->
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Mi Aplicación</p>
    </footer>
</body>
</html>