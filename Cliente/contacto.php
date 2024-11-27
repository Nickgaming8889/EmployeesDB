<?php
    session_start();
    require_once "../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
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
</body>
</html>