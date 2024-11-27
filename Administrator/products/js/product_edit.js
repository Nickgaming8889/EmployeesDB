$(document).ready(function() {
    // Handle form submission
    $('#productForm').on('submit', function(e) {
        e.preventDefault(); // Prevent traditional form submission

        let formData = new FormData(this); // Gather form data, including files

        // Validate required fields
        const codigo = $('#codigo').val().trim();
        const name = $('#name').val().trim();
        const descripcion = $('#descripcion').val().trim();
        const precio = $('#precio').val().trim();
        const stock = $('#stock').val().trim();
        const status = $('#status').val();

        $('#message').hide().text('');

        if (!codigo || !name || !descripcion || !precio || !stock || status === null) {
            $('#message').text('Todos los campos son obligatorios.').css('color', 'red').show();
            mostrarMensajeTemporal('#message');
            return;
        }

        // Send AJAX request
        $.ajax({
            url: 'product_update.php', // PHP script to handle the update
            type: 'POST',
            data: formData,
            contentType: false, // Let jQuery set the Content-Type header
            processData: false, // Prevent jQuery from processing the data
            dataType: 'json',

            success: function(response) {
                if (response.status === 'success') {
                    alert('Producto actualizado correctamente.');
                    window.location.href = 'product_list.php'; // Redirect on success
                } else {
                    $('#message').text(response.message).css('color', 'red').show();
                }
            },

            error: function(xhr, status, error) {
                $('#message').text('Error en la solicitud. Intenta de nuevo.').css('color', 'red').show();
            }
        });
    });

    // Temporary message display
    function mostrarMensajeTemporal(selector) {
        setTimeout(function() {
            $(selector).text('').hide();
        }, 5000);
    }
});
