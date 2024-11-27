function deleteProduct(id) {
    if (confirm('Seguro que quieres eliminar este producto?')) {
        $.ajax({
            type: 'GET',
            url: 'product_destroy.php',
            data: {id: id},
            success: function(response) {
                if (response === 'success') {
                    console.log('Producto eliminado');
                    location.reload();
                } else {
                    console.log('Error: ' + response);
                }
            },
        })
    }
}