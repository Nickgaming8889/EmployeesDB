<?php
    require_once "../connectionDB.php"; // Ensure this path is correct

    // Set the content type to JSON
    header('Content-Type: application/json');

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        // Function to validate the email format
        function validate_email($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        // Check if the email is valid
        if (!validate_email($email)) {
            echo json_encode([
                'status' => 'invalid',
                'message' => 'Invalid email format.'
            ]);
            exit;
        }

        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Prepare the SQL statement to check if the email exists
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE correo = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // Check if any record is returned
            if ($stmt->fetch()) {
                echo json_encode([
                    'status' => 'exists',
                    'message' => 'Email address already exists.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'available',
                    'message' => 'Email address is available.'
                ]);
            }
        } catch (PDOException $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No email provided.'
        ]);
    }
?>