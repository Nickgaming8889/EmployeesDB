<?php
    require_once "../connectionDB.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        $password = $_POST['password'];

        $full_name = $name .' '. $surname;
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Photo upload handling
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
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Photo upload error.']);
            exit;
        }

        // Database insert
        try {
            $stmt = $conn->prepare("INSERT INTO empleados (nombre, correo, rol, contra, foto_nombre, foto_encryp) VALUES (:name, :email, :rol, :password, :img_name, :img_encrypt)");
            $stmt->bindParam(':name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':password', $passwordHash);
            $stmt->bindParam(':img_name', $imgName);
            $stmt->bindParam(':img_encrypt', $encryptedName);
            $stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'Employee registered successfully!']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
?>