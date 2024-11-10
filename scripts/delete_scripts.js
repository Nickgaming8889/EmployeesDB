function deleteEmployee(id) {
    if (confirm('Seguro que quieres eliminar a este empleado?')) {
        $.ajax({
            type: 'GET',
            url: 'employees_delete.php',
            data: {id: id},
            success: function(response) {
                if (response === 'success') {
                    console.log('Empleado eliminado');
                    location.reload();
                } else {
                    console.log('Error: ' + response);
                }
            },
        })
    }
}