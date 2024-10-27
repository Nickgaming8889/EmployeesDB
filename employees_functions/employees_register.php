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
        <button><a href="employees_list.php">List</a></button>
    </div>
    <form id="formRegistrarEmpleado" action="employees_save.php" method="post">
        <div class="register_inputs">
            <div class="input">
                <input type="text" name="name" id="name" placeholder="First Name" required>
            </div>
            <div class="input">
                <input type="text" name="surname" id="surname" placeholder="Surnames" required>
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input">
                <select name="rol" id="rol" required>
                    <option value="">Select Role</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
        </div>
        <div class="save_register">
            <button type="submit" class="save_btn">Guardar</button>
        </div>
        <div id="message" class="error-message"></div>        
    </form>
</body>
</html>
