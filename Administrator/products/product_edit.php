<?php
    require_once "../../connectionDB.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM producto WHERE id = :idProducto");
            $stmt->bindParam(':idProducto', $id, PDO::PARAM_INT);
            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                echo "El producto que estás buscando no se ha encontrado";
                exit();
            }
        } 
        catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product_edit.css">
    <title>Editar Producto</title>
</head>
<body>
    <div class="go_back">
        <button><a href="product_list.php">List Products</a></button>
    </div>
    <form id="productForm" action="product_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div id="message" style="color: red; display: none;"></div>

        <!-- Código -->
        <div class="input">
            <label for="codigo">Codigo:</label>
            <input type="text" name="codigo" id="codigo" placeholder="Código Producto" value="<?php echo htmlspecialchars($product['codigo']); ?>" required>
        </div>

        <!-- Nombre -->
        <div class="input">
            <label for="nombre">Nombre:</label>
            <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo htmlspecialchars($product['nombre']); ?>" required>
        </div>

        <!-- Descripción -->
        <div class="input">
            <label for="descripcion">Descripcion:</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
        </div>

        <!-- Precio -->
        <div class="input">
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" placeholder="Precio" step="0.01" value="<?php echo htmlspecialchars($product['precio']); ?>" required>
        </div>

        <!-- Stock -->
        <div class="input">
            <label for="codigo">Stock:</label>
            <input type="number" name="stock" id="stock" placeholder="Stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
        </div>

        <!-- Estado -->
        <div class="input">
            <select name="status" id="status">
                <option value="1" <?php echo $product['status'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $product['status'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>

        <!-- Foto -->
        <div class="input">
            <label for="photo">Foto:</label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <?php if ($product['foto_encryp']): ?>
                <div>
                    <img src="../photos/<?php echo htmlspecialchars($product['foto_encryp']); ?>" alt="Foto del producto" style="width: 100px; height: 100px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="save_update">
            <button type="submit" class="save_btn">Actualizar Producto</button>
        </div>
    </form>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/product_edit.js"></script>
</html>
