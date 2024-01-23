<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop | Registro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style2.css">
    <link rel="stylesheet" href="assets/css/style_registro.css">
</head>
<body>
    <?php require("assets/php/header2.php") ?>
        <section class="form-container">
            <form id="formulario-registro">
                <div class="input-container">
                    <p>Nombre</p>
                    <input class="input" type="text" id="nombre_input" placeholder="Nombre..." required>
                </div>
                <div class="input-container">
                    <p>Apellidos</p>
                    <input class="input" type="text" id="apellido_input" placeholder="Apellidos..." required>
                </div>
                <div class="input-container">
                    <p>Provincia</p>
                    <select class="input" id="provincia-select">
                        <option>Seleccionar Provincia</option>
                    </select>
                </div>
                <div class="input-container">
                    <p>Ciudad</p>
                    <select class="input" id="ciudad-select">
                        <option>Seleccionar Ciudad</option>
                    </select>
                </div>
                <div class="input-container">
                    <p>Código Postal</p>
                    <input class="input" type="text" id="codigoPostal_input" placeholder="23456" minlength="5" maxlength="5" required>
                </div>
                <div class="input-container">
                    <p>Dirección</p>
                    <input class="input" type="text" id="direccion_input" placeholder="Calle Nombrecalle N°2 Ciudadcentral..." required>
                </div>
                <div class="input-container">
                    <p>Teléfono</p>
                    <input class="input" type="text" id="telefono_input" placeholder="+34 654321987" maxlength="13" required>
                </div>
                <div class="input-container">
                    <p>Correo</p>
                    <input class="input" type="mail" id="correo_input" placeholder="example@example.com" required>
                </div>
                <div class="input-container">
                    <p>Contraseña</p>
                    <input class="input" type="password" id="contrasena_input" required>
                </div>
                <div class="input-container">
                    <p>Repite tu Contraseña</p>
                    <input class="input" type="password" id="contrasena_rpt" required>
                </div>
                <div class="terminos-container">
                    <input id="terminos" type="checkbox" require>
                    <label for="terminos">He leído los <span>Términos y Condiciones.</span></label>
                </div>
                <button class="boton-submit" id="boton-submit_registro">REGISTRARSE</button>
            </form>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script type="module" src="assets/js/registro.js"></script>
    <script src="assets/js/localidades.js"></script>
</body>
</html>