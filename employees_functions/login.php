<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../connectionDB.php"; // Include the database connection

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Check if the user exists in the database
        $sql = "SELECT * FROM empleados WHERE correo = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Assuming there is a `clave` (password) field in `empleados`
            if (password_verify($password, $row['contra'])) {
                // Login successful
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['nombre'] = $row['nombre']; // Store user name for reference
                $_SESSION['eliminar'] = $row['eliminar'];
                $_SESSION['ver_detalle'] = $row['ver_detalle'];
                $_SESSION['editar'] = $row['editar'];
                
                // Return a JSON response for successful login
                echo json_encode(['status' => 'success', 'message' => 'Login successful! Redirecting...', 'redirect' => 'dashboard.php']);
            } else {
                // Incorrect password
                echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
            }
        } else {
            // User does not exist
            echo json_encode(['status' => 'error', 'message' => 'User not found.']);
        }
    } catch (Exception $e) {
        // Handle any database errors
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Please enter your email and password.']);
}
?>
