$(document).ready(function () {
    // Handle form submission
    $('#promocion-form').on('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        $('#message').text('').removeClass('error-message');

        var nombre = $('#nombre').val();
        var foto = $('#foto')[0].files[0];

        if (nombre.trim() === "") {
            $('#message').text('The name field is required.').css('color', 'red');
            mostrarMensajeTemporal('#message');
            return;
        }

        var formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('foto', foto);

        // AJAX to save data
        $.ajax({
            type: 'POST',
            url: 'prom_store.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Redirect to promotion list if successful
                    window.location.href = 'prom_list.php';
                } else {
                    $('#message').text(response.message || 'Error registering the promotion.').css('color', 'red');
                    mostrarMensajeTemporal('#message');
                }
            },
            error: function () {
                $('#message').text('Error registering the promotion.').css('color', 'red');
                mostrarMensajeTemporal('#message');
            }
        });
    });

    // Function to temporarily display messages
    function mostrarMensajeTemporal(selector) {
        setTimeout(function () {
            $(selector).text('').removeClass('error-message');
        }, 5000);
    }
});
