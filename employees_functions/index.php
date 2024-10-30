<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <title>Log In</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault(); // Evita que el formulario se envíe de inmediato

                // Obtener los valores de los campos
                var email = $('#email').val();
                var pass = $('#pass').val();
                var messageDiv = $('#message');

                // Limpiar el mensaje anterior
                messageDiv.text('').removeClass('error-message');

                // Validar que los campos no estén vacíos
                if (email === "" || pass === "") {
                    messageDiv.text("Todos los campos son obligatorios.").addClass('error-message');
                    return; // Detener la ejecución si hay un campo vacío
                }

                // Si los campos están llenos, enviar el formulario usando AJAX
                $.ajax({
                    url: 'login.php', // URL del archivo PHP que procesa el inicio de sesión
                    type: 'POST',
                    data: {
                        email: email,
                        password: pass
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus, errorThrown);
                    },
                    success: function(response) {
                        // Manejar la respuesta del servidor
                        alert(response);
                        if (response == 'error') {
                            console.log("zzz");
                            messageDiv.text(response.error).addClass('error-message');
                        }else {
                            // Redirigir o mostrar un mensaje de éxito
                            console.log("as");
                            window.location.href = 'dashboard.php'; // Redirigir a otra página
                            
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1>Log in</h1>

    <form method="POST" id="form">
        <div class="input">
            <input type="email" name="email" id="email" placeholder="Email">
        </div>
        <div class="input">
            <input type="password" name="pass" id="pass" placeholder="Password">
        </div>
        <div class="submit">
            <button type="submit">Log in</button>
        </div>
    </form>

    <div id="message" class="error-message"></div>
</body>
</html>