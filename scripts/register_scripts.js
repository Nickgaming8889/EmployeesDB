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
                    $('.save_btn').hide();
                } else {
                    $('#emailMessage').text('Este correo electrónico está disponible.').css('color', 'green');
                    $('.save_btn').show();
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
    var photo = $('#photo')[0].files[0];

    if (name == "" || surname == "" || email == "" || password == "" || rol == "") {
        $('#message').text('Todos los campos son obligatorios.').css('color', 'red');
        mostrarMensajeTemporal('#message');
        return;
    }

    var formData = new FormData();
    formData.append('name', name);
    formData.append('surname', surname);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('rol', rol);
    formData.append('photo', photo);
    
    // Aquí se envían los datos del formulario
    $.ajax({
        type: 'POST',
        url: 'employees_save.php',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
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