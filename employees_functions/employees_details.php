<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_details.css">
    <title>Employee Details</title>
</head>
<body>
    <h1>Employee Details</h1>
    <div class="go_back">
        <button><a href="employees_list.php">List</a></button>
    </div>

    <?php
        require_once '../connectionDB.php';
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM empleados WHERE id = :idEmpleado");
                $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                
                echo "<div>Name: ". htmlspecialchars($result['nombre'])."</div>";
                echo "<div>Email: ". htmlspecialchars($result['correo'])."</div>";
                echo "<div>Role: ". htmlspecialchars(($result['rol'] == 1) ? 'Gerente' : 'Ejecutivo')."</div>";
                
                $conn = null;
            } catch (PDOException $e) {
                echo "Error: ". $e->getMessage();
            }
        }
    ?>
</body>
</html>