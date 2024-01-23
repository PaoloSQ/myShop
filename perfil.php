<?php require("assets/php/conexionHead.php") ?>
<?php
    $idUsuario = $sesion->getID_Usuario();
    if ($idUsuario === null) {
        header("Location: login.php");
        exit();
    } else if ($idUsuario === '2') {
        header("Location: admin.php");
        exit();
    }      
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop | Perfil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_perfil.css">
</head>
<body>
    <?php require("assets/php/header.php") ?>
    <main>
        <h2>DATOS DEL USUARIO</h2>
        <div class="editar_perfil-container">
            <p id="editar_perfil">Editar Pefil <i class="fa-solid fa-pen"></i></p>
        </div>
        <section id="datos-section">
            <p><span class="bold">ID: #</span><span id="id_usuario"></span></p>
            <p><span class="bold">Nombre:</span> <span id="nombre_usuario"></span></p>
            <p><span class="bold">Apellido:</span> <span id="apellido_usuario"></span></p>
            <p><span class="bold">Correo Electrónico:</span> <span id="correo_usuario"></span></p>
            <p><span class="bold">Teléfono:</span> <span id="telefono_usuario"></span></p>
            <p><span class="bold">Dirección:</span> <span id="direccion_usuario"></span></p>
            <p><span class="bold">Ciudad:</span> <span id="ciudad_usuario"></span></p>
            <p><span class="bold">Provincia:</span> <span id="provincia_usuario"></span></p>
            <p><span class="bold">Código Postal:</span> <span id="codigo_postal_usuario"></span></p>
            <p id="cambiar_contrasena">Cambiar contraseña</p>
            <p id="eliminar_cuenta">Eliminar cuenta</p>
        </section>
        <h2>PEDIDOS REALIZADOS</h2>
        <section id="pedidos-section"></section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script type="module" src="assets/js/perfil.js"></script>
    <script src="assets/js/localidades.js"></script>
</body>
</html>