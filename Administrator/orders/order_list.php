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
    <link rel="stylesheet" href="css/order_list.css">
    <title>Pedidos List</title>
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
            <a href="../proms/prom_list.php">Promociones</a>
        </div>
        <div class="nav_orders">
            <a href="pedido_list.php">Pedidos</a> <!-- Changed to link to pedidos list -->
        </div>
        <div class="nav_logout">
            <a href="../logout.php">Salir</a>
        </div>
    </div>
    <div class="table">
        <div class="title">
            <div class="column">Fecha</div>
            <div class="column">Cliente</div>
            <div class="column">Estado</div>
            <div class="column">Acciones</div>
        </div>
        <?php
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Query to get orders (pedidos) with status = 1
                $stmt = $conn->prepare("SELECT p.id, p.fecha, p.id_cliente, p.status, c.nombre AS cliente_nombre 
                                        FROM pedido p 
                                        JOIN cliente c ON p.id_cliente = c.id 
                                        WHERE p.status = 1"); // Filter for active orders only (status = 1)
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the orders
                foreach ($result as $row) {
                    echo "<div class='product'>";
                    echo "<div class='row'>". htmlspecialchars($row['fecha']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars($row['cliente_nombre']) ."</div>";
                    echo "<div class='row'>". ($row['status'] ? 'Inactiva' : 'Activa') ."</div>";
                    echo "<div class='row'>";
                    echo "<a href='pedido_show.php?id=". htmlspecialchars($row['id']) ."'>Detalles</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
        ?>
    </div>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/prom_destroy.js"></script> <!-- This JS file might need renaming or modification for the 'pedido' functionality -->
</html>
