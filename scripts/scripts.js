function deleteEmployee(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este empleado?")) {
        document.getElementById("deleteFormId").value = id;
        document.getElementById("deleteForm").submit();
    }
}