$(document).ready(function() {
    $('#promocion-form').on('submit', function(e) {
        e.preventDefault(); // Prevent traditional form submission

        let formData = new FormData(this); // Gather form data, including files

        // Validate required fields
        const nombre = $('#nombre').val().trim();
        $('#message').hide().text('');

        if (!nombre) {
            $('#message').text('The name field is required.').css('color', 'red').show();
            mostrarMensajeTemporal('#message');
            return;
        }

        // Send AJAX request
        $.ajax({
            url: 'prom_update.php', // PHP script to handle the update
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',

            success: function(response) {
                if (response.status === 'success') {
                    alert('Promotion updated successfully.');
                    window.location.href = 'prom_list.php'; // Redirect on success
                } else {
                    $('#message').text(response.message).css('color', 'red').show();
                }
            },

            error: function(xhr, status, error) {
                $('#message').text('An error occurred. Please try again.').css('color', 'red').show();
            }
        });
    });

    function mostrarMensajeTemporal(selector) {
        setTimeout(function() {
            $(selector).text('').hide();
        }, 5000);
    }
});
