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
        url: 'validator.php',
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