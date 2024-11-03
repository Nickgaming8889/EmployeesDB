<?php
    session_start();
    require_once "../connectionDB.php";

    // Check if form is submitted with POST method
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve the data from the POST request
        $id = $_POST['id'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rol = $_POST['rol'];

        try {
            // Combine name and surname for full name
            $full_name = $name . ' ' . $surname;
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $stmt = $conn->prepare("UPDATE empleados SET nombre = :fullname, correo = :email, rol = :rol, contra = :password WHERE id = :idEmpleado");

            // Bind the parameters
            $stmt->bindParam(':fullname', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':password', $hashPassword);
            $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Redirect to employees list page after successful update
            header('Location: employees_list.php');
            exit();
        } catch (PDOException $e) {
            // Display error message
            echo "Error: " . $e->getMessage();
        }
    }
?>
