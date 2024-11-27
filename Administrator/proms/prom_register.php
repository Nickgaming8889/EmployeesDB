<?php
    require_once "../../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Promotion</title>
    <link rel="stylesheet" href="css/prom_register.css">
</head>
<body>
    <div class="go_back">
        <button><a href="prom_list.php">List Promotions</a></button>
    </div>
    <h1>Register a New Promotion</h1>
    <form id="promocion-form" method="POST" enctype="multipart/form-data" class="promocion-form">
        <div class="form-group">
            <label for="nombre">Promotion Name:</label>
            <input type="text" id="nombre" name="nombre">
        </div>
        <div class="form-group">
            <label for="foto">Promotion Image:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
        </div>
        <div id="message" class="error-message"></div> <!-- Form-wide message -->
        <div class="form-actions">
            <button type="submit" class="save_btn">Register Promotion</button>
        </div>
    </form>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/prom_register.js"></script>
</html>
