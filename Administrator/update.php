<?php
    require_once "../connectionDB.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $full_name = $name . ' ' . $surname;

        // Inicializar variables opcionales
        $passwordHash = null;
        $imgName = null;
        $encryptedName = null;

        // Manejo opcional de la contraseña
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        }

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
        $sql = "UPDATE empleados SET nombre = :name, correo = :email, rol = :rol";
        if ($passwordHash) {
            $sql .= ", contra = :password";
        }
        if ($imgName && $encryptedName) {
            $sql .= ", foto_nombre = :img_name, foto_encryp = :img_encrypt";
        }
        $sql .= " WHERE id = :id";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':id', $_POST['id']);

            // Enlazar solo si existen los valores opcionales
            if ($passwordHash) {
                $stmt->bindParam(':password', $passwordHash);
            }
            if ($imgName && $encryptedName) {
                $stmt->bindParam(':img_name', $imgName);
                $stmt->bindParam(':img_encrypt', $encryptedName);
            }

            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Employee updated successfully!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
?>
