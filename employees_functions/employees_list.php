<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_list.css">
    <title>Employees List</title>
</head>
<body>
    <div class="table">
        <div class="title">
            <div class="column">
                Nombre
            </div>
            <div class="column">
                Email
            </div>
            <div class="column">
                Rol
            </div>
        </div>
            <?php
                require_once "../connectionDB.php";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM empleados WHERE eliminar = 0");
                    $stmt->execute();

                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($result as $row) {
                        echo "<div class='employee'>";
                        echo "<div class='row'>". htmlspecialchars($row['nombre']) ."</div>";
                        echo "<div class='row'>". htmlspecialchars($row['correo']) ."</div>";
                        echo "<div class='row'>". htmlspecialchars(($row['rol'] == 1) ? "Gerente" : "Ejecutivo") ."</div>";
                        echo "<div class='row'><a href='employees_delete.php?id=". htmlspecialchars($row['id']). "' onclick=\"return confirm('¿Estás seguro de que deseas eliminar este empleado?');\">Eliminar</a></div>";
                        echo "</div>";
                    }
                }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
            ?>
            <div class="add_btn">
                <button type="submit"><a class="add" href="employees_register.php">Add Employee</a></button>
            </div>
    </div>
</body>
    <script src="../scripts/scripts.js"></script>
</html>