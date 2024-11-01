<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        .error {
            color: red;
        }
        .message {
            margin-top: 10px;
            color: green;
        }
    </style>
</head>
<body>
    <h1>Welcome to Our Application</h1>

    <h2>Login</h2>
    <form id="loginForm" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>

        <input type="submit" value="Login">
    </form>

    <div class="message" id="message"></div>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $('#loginForm').submit(function(event) {
            event.preventDefault();

            const email = $('#email').val();
            const password = $('#password').val();
            const messageDiv = $('#message');

            if (email === "" || password === "") {
            $('#message').text('Todos los campos son obligatorios.').css('color', 'red');
            mostrarMensajeTemporal('#message');
            return;
        }

            $.ajax ({
                url: 'login.php',
                type: 'POST',
                data: {
                    email: email,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    messageDiv.text(response.message);

                    if (response.status === 'success') {
                            window.location.href = response.redirect;
                    }
                },
                error:  function(xhr, status, error) {
                    messageDIV.text('Error: '+ xhr.responseText);
                    console.error("Error details: ", error, xhr.responseText);
                }
            });
        });

        
    </script>
</html>
