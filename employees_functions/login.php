<?php
    session_start();
    require_once "../connectionDB.php";

    if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $email = $_POST['email'];
            $userPassword = $_POST['password'];

            $stmt = $conn->prepare("SELECT * FROM empleados WHERE correo = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificar si la contraseña está almacenada
                if ($user['contra'] == NULL) {
                    //echo "error";
                    echo json_encode(['error' => 'No se ha establecido una contraseña para este usuario.']);
                    exit();
                }

                // Comprobar la contraseña
                if (password_verify($userPassword, $user['contra'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    echo json_encode(['success' => 'Si.']);
                    //header("Location: dashboard.php");
                    exit();
                } else {
                    //echo "error";
                    echo json_encode(['error' => 'Contraseña incorrecta.']);
                    $conn = null;
                    exit();
                }
            } else {
                //echo "error";
                
                echo json_encode(['error' => 'Correo electrónico no encontrado.']);
                $conn = null;
                exit();
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
            //echo "error";
            exit();
        }
        echo json_encode(['error' => "Error"]);
        $conn = null;
        exit();
    }else{
        echo json_encode(['error' => "Error"]);
        $conn = null;
        exit();
    }
?>