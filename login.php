<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="stylesheet" href="assets/css/style_login.css">
</head>
<body>
    <?php require("assets/php/header2.php") ?>
        <section class="form-container">
            <form id="formulario-login">
                <div class="input-container">
                    <p>Correo</p>
                    <input class="input" type="mail" id="correo_input" placeholder="example@example.com">
                </div>
                <div class="input-container">
                    <p>Contraseña</p>
                    <input class="input" type="password" id="contrasena_input">
                </div>
                <p class="dato-admin">Funciones de Administrador: Admin@admin.com / Admin1111@</p>
                <button class="boton-submit" id="boton-submit_login">INICIAR SESION</button>
            </form>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script type="module" src="assets/js/login.js"></script>
</body>
</html>