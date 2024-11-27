<?php
    require_once "../../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Product</title>
    <link rel="stylesheet" href="css/product_register.css">
</head>
<body>
    <div class="go_back">
        <button><a href="product_list.php">List Employees</a></button>
    </div>
    <h1>Register a New Product</h1>
    <form id="product-form" method="POST" enctype="multipart/form-data" class="product-form">
        <div class="form-group">
            <label for="nombre">Product Name:</label>
            <input type="text" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="codigo">Product Code:</label>
            <input type="text" id="codigo" name="codigo" maxlength="32">
            <span id="codigoMessage"></span> <!-- Message placeholder -->
        </div>
        <div class="form-group">
            <label for="descripcion">Description:</label>
            <textarea id="descripcion" name="descripcion" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="precio">Price:</label>
            <input type="number" id="precio" name="precio" step="0.01" min="0">
        </div>
        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" min="0">
        </div>
        <div class="form-group">
            <label for="foto">Product Image:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
        </div>
        <div id="message" class="error-message"></div> <!-- Form-wide message -->
        <div class="form-actions">
            <button type="submit" class="save_btn">Register Product</button>
        </div>
    </form>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/product_register.js"></script>
</html>
