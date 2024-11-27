<?php
require_once "../../connectionDB.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Photo upload handling
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
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded photo.']);
            exit;
        }
    } else {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
        ];
    
        $error = $_FILES['foto']['error'];
        $message = isset($errorMessages[$error]) ? $errorMessages[$error] : 'Unknown file upload error.';
        echo json_encode(['status' => 'error', 'message' => $message]);
        exit;
    }
    

    // Database insert
    try {
        $stmt = $conn->prepare("INSERT INTO producto (nombre, codigo, descripcion, precio, stock, foto_nombre, foto_encryp) 
                                VALUES (:nombre, :codigo, :descripcion, :precio, :stock, :foto_nombre, :foto_encryp)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':foto_nombre', $imgName);
        $stmt->bindParam(':foto_encryp', $encryptedName);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'message' => 'Product registered successfully!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>
