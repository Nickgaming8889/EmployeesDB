<?php

    require_once "../../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product_show.css">
    <title>Product Details</title>
</head>
<body>
    <div class="go_back">
        <button><a href="product_list.php">List</a></button>
    </div>

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM producto WHERE id = :idProducto");
                $stmt->bindParam(':idProducto', $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    echo "<div class='foto'>";
                    $photoPath = '../photos/' . $result['foto_encryp'];

                    if (!empty($result['foto_encryp']) && file_exists($photoPath)) {
                        echo "<img src='". htmlspecialchars($photoPath). "' alt='Product photo'>";
                    }
                    else {
                        echo "<img src='../photos/default.jpg' alt='Imagen no disponible'>";
                    }
                    echo "</div>";

                    echo "<div><strong>Code: </strong>". htmlspecialchars($result['codigo']) . "</div>";
                    echo "<div><strong>Nombre: </strong>". htmlspecialchars($result['nombre']) . "</div>";
                    echo "<div><strong>Descripcion: </strong>". htmlspecialchars($result['descripcion']) . "</div>";
                    echo "<div><strong>Stock: </strong>". htmlspecialchars($result['stock']) . "</div>";
                    echo "<div><strong>Price: </strong>". htmlspecialchars($result['precio']) . "</div>";
                }
                else {
                    echo "<p>Producto no encontrado.</p>";
                }
            }
            catch (PDOException $e) {
                echo "Error: ". $e->getMessage();
            }
        }
    ?>
</body>
</html>