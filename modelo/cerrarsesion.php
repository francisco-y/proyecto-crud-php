<?php
    session_start();

    //Eliminar la variable de sesion y destruir la sesion
    unset($_SESSION['usuario_iniciado']);
    session_destroy();

    //Redirigir al usuario de nuevo al menú
    header('Location: ../index.php');
    exit;
?>