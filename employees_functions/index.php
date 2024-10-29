<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../styles/styles.css"> <!-- Asegúrate de tener un archivo CSS si es necesario -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form id="loginForm">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div id="mensaje" style="color: red;"></div>
        <button type="submit">Iniciar Sesión</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Evita que el formulario se envíe de forma tradicional

                var email = $('#email').val();
                var password = $('#password').val();

                // Validar que los campos no estén vacíos
                if (email === "" || password === "") {
                    $('#mensaje').text('Por favor, complete todos los campos.');
                    return;
                }

                // Enviar la información mediante AJAX
                $.ajax({
                    type: 'POST',
                    url: 'loginValidation.php',
                    data: { email: email, password: password },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'exists') {
                            // Redirigir a la página de bienvenida
                            window.location.href = 'bienvenido.php';
                        } else {
                            $('#mensaje').text(response.message);
                        }
                    },
                    error: function() {
                        $('#mensaje').text('Error en la comunicación con el servidor.');
                    }
                });
            });
        });
    </script>
</body>
</html>