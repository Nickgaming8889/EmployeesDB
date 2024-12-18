<?php
    session_start();
    if (!isset($_SESSION['nombre'])) {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_details.css">
    <title>Employee Details</title>
</head>
<body>
    <h1>Employee Details</h1>
    <div class="go_back">
        <button><a href="employees_list.php">List</a></button>
    </div>

    <?php
        require_once '../connectionDB.php';
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                // Conexión con la base de datos
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obtener los detalles del empleado
                $stmt = $conn->prepare("SELECT * FROM empleados WHERE id = :idEmpleado");
                $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);
                $stmt->execute();

                // Recuperar los resultados
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    // Mostrar la imagen del empleado si existe
                    echo "<div class='foto'>";
                    $photoPath = '../photos/' . $result['foto_encryp'];
                    
                    if (!empty($result['foto_encryp']) && file_exists($photoPath)) {
                        // Mostrar la imagen desde la carpeta "photos"
                        echo "<img src='" . htmlspecialchars($photoPath) . "' alt='Employee photo'>";
                    } else {
                        // Mostrar una imagen predeterminada si no existe
                        echo "<img src='../photos/default.jpg' alt='Imagen no disponible'>";
                    }
                    echo "</div>";

                    // Mostrar los detalles del empleado
                    echo "<div>Name: " . htmlspecialchars($result['nombre']) . "</div>";
                    echo "<div>Email: " . htmlspecialchars($result['correo']) . "</div>";
                    echo "<div>Role: " . htmlspecialchars(($result['rol'] == 1) ? 'Gerente' : 'Ejecutivo') . "</div>";
                } else {
                    echo "<p>Empleado no encontrado.</p>";
                }

                // Cerrar la conexión
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    ?>

</body>
</html>