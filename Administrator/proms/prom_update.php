<?php
require_once "../../connectionDB.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id']) || empty($_POST['nombre'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID and name are required.']);
        exit;
    }

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    $imgName = null;
    $encryptedName = null;

    // Handle optional photo upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $imgName = $_FILES['foto']['name'];
        $imgTMP = $_FILES['foto']['tmp_name'];
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

    // Build the SQL query dynamically
    $sql = "UPDATE promocion SET nombre = :nombre";
    if ($imgName && $encryptedName) {
        $sql .= ", foto_encryp = :foto_encryp";
    }
    $sql .= " WHERE id = :id";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':id', $id);

        if ($imgName && $encryptedName) {
            $stmt->bindParam(':foto_encryp', $encryptedName);
        }

        $stmt->execute();
        echo json_encode(['status' => 'success', 'message' => 'Promotion updated successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
