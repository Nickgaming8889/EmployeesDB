<?php
    require_once "../../connectionDB.php";

    session_start();
    if (!isset($_SESSION['nombre'])) {
        header("Location: ../index.php");
        exit;
    }

    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/prom_list.css">
    <title>Promotions List</title>
</head>
<body>
    <div class="nav_menu">
        <div class="nav_welcome">
            Bienvenido <?php echo htmlspecialchars($nombre) ?>  
        </div>
        <div class="nav_start">
            <a href="../dashboard.php">Inicio</a>
        </div>
        <div class="nav_employees">
            <a href="../employees_list.php">Empleados</a>
        </div>
        <div class="nav_products">
            <a href="../products/product_list.php">Productos</a>
        </div>
        <div class="nav_proms">
            <a href="prom_list.php">Promociones</a>
        </div>
        <div class="nav_orders">
            <a href="../orders/order_list.php">Pedidos</a>
        </div>
        <div class="nav_logout">
            <a href="../logout.php">Salir</a>
        </div>
    </div>
    <div class="table">
        <div class="title">
            <div class="column">ID</div>
            <div class="column">Nombre</div>
            <div class="column">Estado</div>
            <div class="column">Acciones</div>
        </div>
        <?php
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obtener promociones activas (no eliminadas)
                $stmt = $conn->prepare("SELECT * FROM promocion WHERE eliminar = 0");
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar las promociones
                foreach ($result as $row) {
                    echo "<div class='product'>";
                    echo "<div class='row'>". htmlspecialchars($row['id']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars($row['nombre']) ."</div>";
                    echo "<div class='row'>". ($row['status'] ? 'Activa' : 'Inactiva') ."</div>";
                    echo "<div class='row'>";
                    echo "<a href='prom_destroy.php?id=". htmlspecialchars($row['id']) ."' onclick='deleteProm()'>Eliminar</a> | ";
                    echo "<a href='prom_show.php?id=". htmlspecialchars($row['id']) ."'>Detalles</a> | ";
                    echo "<a href='prom_edit.php?id=". htmlspecialchars($row['id']) ."'>Actualizar</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
        ?>
        <div class="add_btn">
            <button type="submit"><a class="add" href="prom_register.php">Add Promotion</a></button>
        </div>
    </div>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/prom_destroy.js"></script>
</html>
