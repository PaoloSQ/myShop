<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Myshop | Contacto</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/style_contacto.css">
    </head>
    <body>
        <?php require("assets/php/header.php") ?>
        <main>
            <section class="form-section">
                <h2>ENVIANOS UN CORREO!!</h2>
                <form id="formulario-email">
                    <div class="input-container">
                        <label for="nombre_input">NOMBRE</label>
                        <input type="text" id="nombre_input" placeholder="Nombre">
                    </div>
                    <div class="input-container">
                        <label for="correo_input">CORREO</label>
                        <input type="text" id="correo_input" placeholder="example@example.com">
                    </div>
                    <div class="input-container">
                        <label for="asunto_input">ASUNTO</label>
                        <input type="text" id="asunto_input" placeholder="Asunto">
                    </div>
                    <div class="input-container">
                        <label for="mensaje_input">MENSAJE</label>
                        <textarea id="mensaje_input" rows="6" resize="none" placeholder="Redacta tu correo..."></textarea>
                    </div>
                    <p id="enviar_correo-boton">ENVIAR CORREO</p>
                </form>
            </section>
            <section class="redes_sociales-section">
                <div class="redes_sociales-container">
                    <div class="red_social linkedin_ico">
                        <i class="fa-brands fa-linkedin"></i>
                        <p>LINKEDIN</p>
                    </div>
                    <div class="red_social github_ico">
                        <i class="fa-brands fa-github"></i>
                        <p>GITHUB</p>
                    </div>
                    <div class="red_social portfolio_ico">
                        <i class="fa-solid fa-briefcase"></i>
                        <p>PORTFOLIO</p>
                    </div>
                    <div class="red_social">
                        <i class="fa-solid fa-phone"></i>
                        <p>+34 624040225</p>
                    </div>
                </div>
            </section>
        </main>
    <?php require("assets/php/footer.php") ?>
    <script type="module" src="assets/js/contacto.js"></script>
</body>
</html>