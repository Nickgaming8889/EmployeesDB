<?php
    require_once "../../connectionDB.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $status = isset($_POST['status']) ? $_POST['status'] : 1; // Default to 1 if not provided

        // Inicializar variables opcionales
        $imgName = null;
        $encryptedName = null;

        // Manejo opcional de la subida de foto
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $imgName = $_FILES['photo']['name'];
            $imgTMP = $_FILES['photo']['tmp_name'];
            $encryptedName = md5_file($imgTMP) . '.' . pathinfo($imgName, PATHINFO_EXTENSION);

            $uploadDir = '../photos/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filePath = $uploadDir . $encryptedName;
            if (!move_uploaded_file($imgTMP, $filePath)) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to upload photo.']);
                exit;
            }
        }

        // Construir la consulta SQL dinámica
        $sql = "UPDATE producto SET nombre = :name, codigo = :codigo, descripcion = :descripcion, precio = :precio, stock = :stock, status = :status";
        if ($imgName && $encryptedName) {
            $sql .= ", foto_nombre = :img_name, foto_encryp = :img_encrypt";
        }
        $sql .= " WHERE id = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $_POST['id']);

            // Enlazar solo si existen los valores opcionales
            if ($imgName && $encryptedName) {
                $stmt->bindParam(':img_name', $imgName);
                $stmt->bindParam(':img_encrypt', $encryptedName);
            }

            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Product updated successfully!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
?>
