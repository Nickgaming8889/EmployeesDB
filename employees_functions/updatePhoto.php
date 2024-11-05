<?php
require_once "../connectionDB.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "../photos/";
        $fileName = uniqid() . "_" . basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;

        // Comprobar si el archivo es una imagen
        $fileType = mime_content_type($_FILES["photo"]["tmp_name"]);
        if (strpos($fileType, 'image') === false) {
            echo json_encode(["status" => "error", "message" => "El archivo no es una imagen."]);
            exit;
        }

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            // Retornar el nombre del archivo
            echo json_encode(["status" => "success", "fileName" => $fileName]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al mover el archivo al directorio de destino."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Por favor, selecciona una imagen válida."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método de solicitud no permitido."]);
}

$conn = null;
?>
