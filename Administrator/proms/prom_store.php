<?php
    require_once "../../connectionDB.php";

    $response = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $foto = $_FILES['foto'] ?? null;

        if (empty($nombre)) {
            $response['status'] = 'error';
            $response['message'] = 'The name field is required.';
            echo json_encode($response);
            exit;
        }

        $fotoPath = null;

        if ($foto && $foto['error'] === UPLOAD_ERR_OK) {
            $fotoName = uniqid('', true) . '.' . pathinfo($foto['name'], PATHINFO_EXTENSION);
            $fotoPath = '../photos/' . $fotoName;

            if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
                $response['status'] = 'error';
                $response['message'] = 'Failed to upload image.';
                echo json_encode($response);
                exit;
            }
        }

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("INSERT INTO promocion (nombre, foto_encryp) VALUES (:nombre, :foto_encryp)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':foto_encryp', $fotoName);
            $stmt->execute();

            $response['status'] = 'success';
        } catch (PDOException $e) {
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }
    }

    echo json_encode($response);
?>