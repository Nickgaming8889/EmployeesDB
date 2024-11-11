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
    <title>Welcome</title>
</head>
<body>
    <?php
        include('menu.php');
    ?>
    <h3>Hola, bienvenido al sistema :D</h3>
</body>
</html>