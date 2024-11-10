$(document).ready(function() {
    // Validación de correo electrónico
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

    // Validación y envío del formulario
    $('#employeeForm').on('submit', function(e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        var name = $('#name').val().trim();
        var surname = $('#surname').val().trim();
        var email = $('#email').val().trim();
        var rol = $('#rol').val();
        var password = $('#password').val().trim();
        var photo = $('#photo')[0].files[0];

        $('#message').hide().text('');

        // Validación de campos obligatorios
        if (name === "" || surname === "" || email === "" || rol === "0") {
            $('#message').text('Todos los campos son obligatorios.').css('color','red').show();
            mostrarMensajeTemporal('#message');
            return;
        }

        // Crear un objeto FormData para manejar la subida del archivo y otros datos
        let formData = new FormData(this);

        var photo = $('#photo')[0].files[0];
        if (photo) {
            formData.append('photo', photo);
        }

        $.ajax({
            url: 'update.php', 
            type: 'POST',
            data: formData,
            contentType: false, 
            processData: false, 
            dataType: 'json',

            success: function(response) {
                if (response.status === 'success') {
                    console.log(response, "Empleado Actualizado");
                    window.location.href = 'employees_list.php';
                } else {
                    $('#message').text(response.message).css('color', 'red').show();
                }
            },

            error: function(xhr, status, error) {
                $('#message').text('Error en la solicitud. Intenta de nuevo.').css('color', 'red').show();
            }
        });
    });

    // Función para mostrar mensajes temporales
    function mostrarMensajeTemporal(selector) {
        setTimeout(function() {
            $(selector).text('').hide();
        }, 5000);
    }
});
