<?php
    session_start();
    if (!isset($_SESSION['nombre'])) {
        header("Location: index.php");
        exit;
    }

    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_list.css">
    <title>Employees List</title>
</head>
<body>
    <div class="nav_menu">
        <div class="nav_welcome">
            Bienvenido <?php echo htmlspecialchars($nombre) ?>  
        </div>
        <div class="nav_start">
            <a href="dashboard.php">Inicio</a>
        </div>
        <div class="nav_employees">
            <a href="employees_list.php">Empleados</a>
        </div>
        <div class="nav_products">
            <a href="products/product_list.php">Productos</a>
        </div>
        <div class="nav_proms">
            <a href="proms/prom_list.php">Promociones</a>
        </div>
        <div class="nav_orders">
            <a href="orders/order_list.php">Pedidos</a>
        </div>
        <div class="nav_logout">
            <a href="logout.php">Salir</a>
        </div>
    </div>
    <div class="table">
        <div class="title">
            <div class="column">
                Nombre
            </div>
            <div class="column">
                Email
            </div>
            <div class="column">
                Rol
            </div>
            <div class="column">
                Acciones
            </div>
        </div>
            <?php
                require_once "../connectionDB.php";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM empleados WHERE eliminar = 0");
                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $row) {
                        echo "<div class='employee'>";
                        echo "<div class='row'>". htmlspecialchars($row['nombre']) ."</div>";
                        echo "<div class='row'>". htmlspecialchars($row['correo']) ."</div>";
                        echo "<div class='row'>". htmlspecialchars(($row['rol'] == 1) ? "Gerente" : "Ejecutivo") ."</div>";
                        echo "<div class='row'>";
                        echo "<a href='employees_delete.php?id=". htmlspecialchars($row['id']). "' onclick='deleteEmployee()'>Eliminar</a>";
                        echo "<a href='employees_details.php?id=". htmlspecialchars($row['id']). "'>Detalles</a>";
                        echo "<a href='employees_edit.php?id=". htmlspecialchars($row['id']). "'>Actualizar</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
            ?>
            <div class="add_btn">
                <button type="submit"><a class="add" href="employees_register.php">Add Employee</a></button>
            </div>
    </div>
</body>
    <script src="../scripts/delete_scripts.js"></script>
</html>