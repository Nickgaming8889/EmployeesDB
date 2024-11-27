<?php
    require_once "../connectionDB.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE id = :idEmpleado");
            $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);
            $stmt->execute();

            $employee = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employee) {
                echo "El empleado que estas buscando no se ha encontrado";
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
    <link rel="stylesheet" href="../styles/employees_edit.css">
    <title>Editar Empleado</title>
</head>
<body>
    <div class="go_back">
        <button><a href="employees_list.php">List Employees</a></button>
    </div>
    <form id="employeeForm" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div id="message" style="color: red; display: none;"></div>

        <!-- Nombre -->
        <div class="input">
            <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo htmlspecialchars(explode(' ', $employee['nombre'])[0]); ?>">
        </div>

        <!-- Apellido -->
        <div class="input">
            <input type="text" name="surname" id="surname" placeholder="Apellido" value="<?php echo htmlspecialchars(explode(' ', $employee['nombre'])[1] ?? ''); ?>">
        </div>

        <!-- Email -->
        <div class="input">
            <input type="text" name="email" id="email" placeholder="Email" value="<?php echo htmlspecialchars($employee['correo']); ?>">
        </div>

        <!-- Password (solo si es necesario cambiarla) -->
        <div class="input">
            <input type="text" name="password" id="password" placeholder="Password">        
        </div>

        <!-- Rol -->
        <div class="input">
            <select name="rol" id="rol">
                <option value="0" <?php echo $employee['rol'] == 0 ? 'selected' : ''; ?>>Select Role</option>
                <option value="1" <?php echo $employee['rol'] == 1 ? 'selected' : ''; ?>>Gerente</option>
                <option value="2" <?php echo $employee['rol'] == 2 ? 'selected' : ''; ?>>Ejecutivo</option>
            </select>
        </div>

        <!-- Foto -->
        <div class="input">
            <label for="photo">Foto:</label>
            <input type="file" name="photo" id="photo" accept="image/*">
            <?php if ($employee['foto_nombre']): ?>
                <div>
                    <img src="../photos/<?php echo htmlspecialchars($employee['foto_nombre']); ?>" alt="Foto de empleado" style="width: 100px; height: 100px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="save_update">
            <button type="submit" class="save_btn">Actualizar</button>
        </div>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../scripts/edit_scripts.js"></script>
</html>
