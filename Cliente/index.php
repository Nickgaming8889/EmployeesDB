<?php
    session_start();
    require_once "../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Nick's Store</title>
</head>
<body>
    <!-- Encabezado -->
    <div class="navbar">
        <div class="logo">
            <a href="index.php">Logotipo</a>
        </div>
        <div class="menu">
            <?php if (isset($_SESSION['usuario'])): ?>
                <!-- Menú para usuarios autenticados -->
                <a href="index.php">Home</a>
                <a href="catalogo_producto.php">Productos</a>
                <a href="contacto.php">Contacto</a>
                <a href="logout.php">Salir</a>
                <a href="carrito.php">Ver carrito</a>
                <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
            <?php else: ?>
                <!-- Menú para visitantes -->
                <a href="index.php">Home</a>
                <a href="catalogo_producto.php">Productos</a>
                <a href="contacto.php">Contacto</a>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <?php
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta para obtener una promoción aleatoria
                $sql_promocion = "SELECT * FROM promocion ORDER BY RAND() LIMIT 1";
                $stmt_promocion = $conn->prepare($sql_promocion); // Preparar la sentencia
                $stmt_promocion->execute();
                $row_promocion = $stmt_promocion->fetch(PDO::FETCH_ASSOC);

                // Consulta para obtener 6 productos aleatorios
                $sql_productos = "SELECT * FROM producto ORDER BY RAND() LIMIT 6";
                $stmt_productos = $conn->prepare($sql_productos);
                $stmt_productos->execute();

                // Generación de la ruta de la foto de la promoción
                $photoPath = '../Administrator/photos/' . $row_promocion['foto_encryp'];
            }
            catch (PDOException $e) {
                echo "Error: ". $e->getMessage();
            }
        ?>

        <!-- Promoción -->
        <div class="promocion">
            <h2>Promoción</h2>
            <?php
                if ($row_promocion) {
                    echo "<div class='foto'>";
                    if (!empty($row_promocion['foto_encryp']) && file_exists($photoPath)) {
                        echo "<img src='". htmlspecialchars($photoPath) ."' alt='Imagen de la promoción'>";
                    } else {
                        echo "<img src='../photos/default.jpg' alt='Imagen no disponible'>";
                    }
                    echo "</div>";
                    echo "<p><strong>".$row_promocion['nombre']."</strong></p>";
                }
            ?>
        </div>

        <!-- Productos aleatorios -->
        <div class="product-carousel">
            <?php while ($row_producto = $stmt_productos->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="product">
                    <?php
                        if ($row_producto) {
                            echo "<div class='foto'>";
                            $photoPathP = '../Administrator/photos/' . $row_producto['foto_encryp'];

                            if (!empty($row_producto['foto_encryp']) && file_exists($photoPathP)) {
                                echo "<img src='". htmlspecialchars($photoPathP) ."' alt='Imagen del producto'>";
                            } else {
                                echo "<img src='../photos/default.jpg' alt='Imagen no disponible'>";
                            }
                            echo "</div>";
                        }
                    ?>
                    <h3><?php echo $row_producto['nombre']; ?></h3>
                    <p>$<?php echo number_format($row_producto['precio'], 2); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>Derechos reservados &copy; 2024 | <a href="terminos.php" style="color: #fff;">Términos y condiciones</a> | Síguenos en 
            <a href="https://facebook.com" style="color: #fff;">Facebook</a>, 
            <a href="https://twitter.com" style="color: #fff;">Twitter</a>, 
            <a href="https://instagram.com" style="color: #fff;">Instagram</a>
        </p>
    </div>
</body>
</html>
