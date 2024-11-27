$(document).ready(function () {
    // Validate "codigo" field on blur
    $('#codigo').on('blur', function () {
        var codigo = $(this).val();

        if (codigo.trim() === "") {
            $('#codigoMessage').text('El código no puede estar vacío.').css('color', 'red');
            return;
        }

        // Check if the code already exists
        $.ajax({
            type: 'POST',
            url: 'validate_codigo.php',
            data: { codigo: codigo },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    $('#codigoMessage').text('Este código ya está en uso.').css('color', 'red');
                    $('.save_btn').hide(); // Hide submit button if invalid
                } else {
                    $('#codigoMessage').text('Este código está disponible.').css('color', 'green');
                    $('.save_btn').show(); // Show submit button if valid
                }
            },
            error: function () {
                $('#codigoMessage').text('Error al validar el código.').css('color', 'red');
            }
        });
    });

    // Handle form submission
    $('#product-form').on('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        $('#message').text('').removeClass('error-message');

        var nombre = $('#nombre').val();
        var codigo = $('#codigo').val();
        var descripcion = $('#descripcion').val();
        var precio = $('#precio').val();
        var stock = $('#stock').val();
        var foto = $('#foto')[0].files[0];

        if (
            nombre.trim() === "" ||
            codigo.trim() === "" ||
            descripcion.trim() === "" ||
            precio.trim() === "" ||
            stock.trim() === ""
        ) {
            $('#message').text('Todos los campos son obligatorios.').css('color', 'red');
            mostrarMensajeTemporal('#message');
            return;
        }

        var formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('codigo', codigo);
        formData.append('descripcion', descripcion);
        formData.append('precio', precio);
        formData.append('stock', stock);
        formData.append('foto', foto);

        // AJAX to save data
        $.ajax({
            type: 'POST',
            url: 'product_store.php',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Redirect to product list if successful
                    window.location.href = 'product_list.php';
                } else {
                    $('#message').text(response.message || 'Error al registrar el producto.').css('color', 'red');
                    mostrarMensajeTemporal('#message');
                }
            },
            error: function () {
                $('#message').text('Error al registrar el producto.').css('color', 'red');
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