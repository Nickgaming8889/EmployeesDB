<?php
    require_once "../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/employees_register.css">
    <title>Employee Registration</title>
</head>
<body>
    <h1>Register Employee</h1>
    <div class="go_back">
        <button><a href="employees_list.php">List Employees</a></button>
    </div>
    <form id="formRegistrarEmpleado" action="employees_save.php" method="post" enctype="multipart/form-data">
        <div class="register_inputs">
            <div class="input">
                <input type="text" name="name" id="name" placeholder="First Name">
            </div>
            <div class="input">
                <input type="text" name="surname" id="surname" placeholder="Surnames">
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email">
                <div id="emailMessage" class="error-message"></div>
            </div>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="input">
                <select name="rol" id="rol">
                    <option value="">Select Role</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
            <div class="input">
                <label for="photo">Foto:</label>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>
        </div>
        <div class="save_register">
            <button type="submit" class="save_btn">Guardar</button>
        </div>
        <div id="message" class="error-message"></div>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                        $('#emailMessage').text('Este correo electrónico ya está en uso.').css('color', 'red');
                    } else {
                        $('#emailMessage').text('Este correo electrónico está disponible.').css('color', 'green');
                    }
                },
                error: function() {
                    $('#emailMessage').text('Error al validar el correo electrónico.').css('color', 'red');
                }
            });
        });

        $('#formRegistrarEmpleado').on('submit', function(event) {
        event.preventDefault();

        $('#message').text('').removeClass('error-message');

        var name = $('#name').val();
        var surname = $('#surname').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var rol = $('#rol').val();

        if (name === "" || surname === "" || email === "" || password === "" || rol === "") {
            $('#message').text('Todos los campos son obligatorios.').css('color', 'red');
            mostrarMensajeTemporal('#message');
            return;
        }

        

        // Aquí se envían los datos del formulario
        $.ajax({
            type: 'POST',
            url: 'employees_save.php',
            data: {
                name: name,
                surname: surname,
                email: email,
                password: password,
                rol: rol
            },
            success: function(response) {
                // Si el registro es exitoso, redirigir a employees_list.php
                window.location.href = 'employees_list.php';
            },
            error: function() {
                $('#message').text('Error al registrar el empleado.').css('color', 'red');
                mostrarMensajeTemporal('#message');
            }
        });
    });

    function mostrarMensajeTemporal(selector) {
        setTimeout(function() {
            $(selector).text('').removeClass('error-message');
        }, 5000);
    }
    });
    </script>
</body>
</html>