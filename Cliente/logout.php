<?php
    session_start();
    
    // Verifica si hay una sesión antes de intentar destruirla
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }

    // Redirige al usuario a la página de inicio de sesión o a la página principal
    header("Location: index.php");
    exit;
?>
