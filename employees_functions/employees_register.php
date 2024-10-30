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
        <button><a href="employees_list.php">List</a></button>
    </div>
    <form id="formRegistrarEmpleado" action="employees_save.php" method="post">
        <div class="register_inputs">
            <div class="input">
                <input type="text" name="name" id="name" placeholder="First Name" required>
            </div>
            <div class="input">
                <input type="text" name="surname" id="surname" placeholder="Surnames" required>
            </div>
            <div class="input">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div id="emailMessage" class="error-message"></div> <!-- Message for email validation status -->
            </div>
            <div class="input">
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input">
                <select name="rol" id="rol" required>
                    <option value="">Select Role</option>
                    <option value="1">Gerente</option>
                    <option value="2">Ejecutivo</option>
                </select>
            </div>
        </div>
        <div class="save_register">
            <button type="submit" class="save_btn">Guardar</button>
        </div>
        <div id="message" class="error-message"></div>        
    </form>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
$(document).ready(function() {
    $('#email').on('blur', function() {
        var email = $(this).val();
        if (email) {
            $.ajax({
                type: 'POST',
                url: 'email_validation.php',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if (response.exists) {
                        $('#emailMessage').text('Este correo electrónico ya está en uso.').css('color', 'red');
                    } else {
                        $('#emailMessage').text('Este correo electrónico está disponible.').css('color', 'green');
                    }
                },
                error: function() {
                    $('#emailMessage').text('Error al validar el correo electrónico.').css('color', 'red');
                }
            });
        } else {
            $('#emailMessage').text('');
        }
    });
});
</script>
</html>