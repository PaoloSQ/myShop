<?php 
    require_once ("API/index.php");
    $sesion = new SesionUsuario();

    if (isset($_GET['cerrar_sesion'])) {
        $sesion->cerrarSesion();
        header('Location: index.php');
        exit();
    }
?>