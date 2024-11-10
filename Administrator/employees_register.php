<?php
    require_once "../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_register.css">
    <title>Employee Registration</title>
</head>
<body>
    <h1>Register Employee</h1>
    <div class="go_back">
        <button><a href="employees_list.php">List Employees</a></button>
    </div>
    <form id="formRegistrarEmpleado" action="employees_save.php" method="post" enctype="multipart/form-data">
        <div class="register_inputs">
            <div class="input">
                <input type="text" name="name" id="name" placeholder="First Name">
            </div>
            <div class="input">
                <input type="text" name="surname" id="surname" placeholder="Surnames">
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email">
                <div id="emailMessage" class="error-message"></div>
            </div>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="input">
                <select name="rol" id="rol">
                    <option value="">Select Role</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
            <div class="input">
                <label for="photo">Foto:</label>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>
        </div>
        <div class="save_register">
            <button type="submit" class="save_btn">Guardar</button>
        </div>
        <div id="message" class="error-message"></div>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../scripts/register_scripts.js"></script>
</body>
</html>