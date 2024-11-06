<?php
    require_once "../connectionDB.php";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            $stmt = $conn->prepare("SELECT * FROM empleados WHERE id = :idEmpleado");
            $stmt->bindParam(':idEmpleado', $id, PDO::PARAM_INT);
            $stmt->execute();

            $employee = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$employee) {
                echo "El empleado que estas buscando no se ha encontrado";
                exit();
            }
        } 
        catch (PDOException $e) {
            echo "Error: ". $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_edit.css">
    <title>Editar Empleado</title>
</head>
<body>
    <div class="go_back">
        <button><a href="employees_list.php">List Employees</a></button>
    </div>
    <form id="employeeForm" action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div id="message" style="color: red; display: none;"></div>
        <div class="input">
            <input type="text" name="name" id="name" placeholder="Nombre">
        </div>
        <div class="input">
            <input type="text" name="surname" id="surname" placeholder="Apellido">
        </div>
        <div class="input">
            <input type="text" name="email" id="email" placeholder="Email">
        </div>
        <div class="input">
            <input type="text" name="password" id="password" placeholder="Password">        
        </div>
        <div class="input">
            <select name="rol" id="rol">
                <option value="0">Select Role</option>
                <option value="1">Gerente</option>
                <option value="2">Ejecutivo</option>
            </select>
        </div>
        <div class="input">
            <label for="photo">Foto:</label>
            <input type="file" name="photo" id="photo" accept="image/*">
        </div>
        <div class="save_update">
            <button type="submit" class="save_btn">Actualizar</button>
        </div>
    </form>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#email').on('blur', function() {
            var email = $(this).val();
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                $('#emailMessage').text('Por favor, introduce un correo electrónico válido.').css('color', 'red');
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'validate_email.php',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#emailMessage').text(response.error).css('color', 'red');
                    } else if (response.exists) {
                        $('#emailMessage').text("El correo electrónico " + email + " ya existe").css('color', 'red');
                        $('.save_btn').hide(); // Esconde el botón de enviar si el correo ya existe
                    } else {
                        $('#emailMessage').text('Este correo electrónico está disponible.').css('color', 'green');
                        $('.save_btn').show(); // Muestra el botón de enviar si el correo está disponible
                    }
                },
                error: function() {
                    $('#emailMessage').text('Error al validar el correo electrónico.').css('color', 'red');
                }
            });
        });

        $('#employeeForm').on('submit', function(e) {
            var name = $('#name').val().trim();
            var surname = $('#surname').val().trim();
            var email = $('#email').val().trim();
            var rol = $('#rol').val();

            $('#message').hide().text('');

            if (name === "" || surname === "" || email === "" || rol === "0") {
                e.preventDefault();
                $('#message').text('Todos los campos son obligatorios.').css('color','red').show();
                mostrarMensajeTemporal('#message');
            }
        });

        function mostrarMensajeTemporal(selector) {
            setTimeout(function() {
                $(selector).text('').hide();
            }, 5000);
        }
    });
</script>
</html>

