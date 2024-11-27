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
    <link rel="stylesheet" href="css/product_list.css">
    <title>Products List</title>
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
            <a href="product_list.php">Productos</a>
        </div>
        <div class="nav_proms">
            <a href="../proms/prom_list.php">Promociones</a>
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
            <div class="column">Código Producto</div>
            <div class="column">Nombre</div>
            <div class="column">Descripción</div>
            <div class="column">Stock</div>
            <div class="column">Precio</div>
            <div class="column">Acciones</div>
        </div>
        <?php
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obtener productos activos (no eliminados)
                $stmt = $conn->prepare("SELECT * FROM producto WHERE eliminar = 0");
                $stmt->execute();

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Mostrar los productos
                foreach ($result as $row) {
                    echo "<div class='product'>";
                    echo "<div class='row'>". htmlspecialchars($row['codigo']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars($row['nombre']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars($row['descripcion']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars($row['stock']) ."</div>";
                    echo "<div class='row'>". htmlspecialchars(number_format($row['precio'], 2)) ."</div>";
                    echo "<div class='row'>";
                    echo "<a href='product_destroy.php?id=". htmlspecialchars($row['id']) ."' onclick='deleteProduct()'>Eliminar</a> | ";
                    echo "<a href='product_show.php?id=". htmlspecialchars($row['id']) ."'>Detalles</a> | ";
                    echo "<a href='product_edit.php?id=". htmlspecialchars($row['id']) ."'>Actualizar</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null;
        ?>
        <div class="add_btn">
            <button type="submit"><a class="add" href="product_register.php">Add Product</a></button>
        </div>
    </div>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/product_destroy.js"></script>
</html>
