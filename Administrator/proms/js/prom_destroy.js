function deleteProm(id) {
    if (confirm('Seguro que quieres eliminar esta promocion?')) {
        $.ajax({
            type: 'GET',
            url: 'prom_destroy.php',
            data: {id: id},
            success: function(response) {
                if (response === 'success') {
                    console.log('Promocion eliminada');
                    location.reload();
                } else {
                    console.log('Error: ' + response);
                }
            },
        })
    }
}