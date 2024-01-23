<?php require("assets/php/conexionHead.php") ?>
    <?php
            if ($sesion->getID_Usuario() === null) {
                header("Location: login.php");
                exit();
            } else if ($sesion->getID_Usuario() !== '2') {
                header("Location: perfil.php");
                exit();
            }      
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Myshop | Admin</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
        <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/style_admin.css">
    </head>
    <body>
        <?php require("assets/php/header.php") ?>
    <main>
        <h2>AGREGAR NUEVO ARTICULO</h2>
        <section class="insertar_articulo-container">
            <form id="insertarArticulo-form"  enctype="multipart/form-data">
                <div class="input-container">
                    <p>Nombre Articulo</p>
                    <input class="input" type="text" id="nombreArticulo_input" placeholder="Nombre" required>
                </div>
                <div class="input-container">
                    <p>Stock</p>
                    <input class="input" type="number" id="existenciasArticulo_input" placeholder="Stock" value="1" min="1" max="100">
                </div>
                <div class="input-container">
                    <p>Categoria</p>
                    <select class="input" id="categoriaArticulo_input">
                        <option></option>
                        <option value="camisetas">CAMISETAS</option>
                        <option value="pantalones">PANTALONES</option>
                        <option value="zapatillas">ZAPATILLAS</option>
                        <option value="bolsos">BOLSOS</option>
                    </select>
                </div>
                <div class="input-container">
                    <p>Marca</p>
                    <select class="input" id="marcaArticulo_input">
                        <option></option>
                        <option value="dolce_gabbanna">DOLCE GABANNA</option>
                        <option value="gucci">GUCCI</option>
                        <option value="jordan">JORDAN</option>
                        <option value="levis">LEVIS</option>
                        <option value="louis_vuitton">LOUIS VUITTON</option>
                        <option value="nike">NIKE</option>
                        <option value="polo">POLO</option>
                    </select>
                </div>
                <div class="input-container">
                    <p>Precio</p>
                    <input class="input" type="text" id="precioArticulo_input" placeholder="Precio" required>
                </div>
                <div class="input-container">
                    <p>Sexo</p>
                    <select class="input" id="sexoArticulo_input">
                        <option></option>
                        <option value="hombre">HOMBRE</option>
                        <option value="mujer">MUJER</option>
                    </select>
                </div>
                <div class="input-container imagen-input">
                    <p>Imagen</p>
                    <input type="file" id="imagenArticulo_input" accept="image/*" required>
                </div>
                <div class="input-container">
                    <p>Descripcion del producto</p>
                    <textarea class="input" cols="30" rows="5" id="descripcionArticulo_input" placeholder="Descripcion" required></textarea>
                </div>
                <a id="subir_articulo-submit">CONFIRMAR ARTICULO</a>
            </form>
            <div class="vista_previa-container">
                <img id="vp_imagen">
                <p id="vp_nombre"></p>
                <p id="vp_precio"></p>
            </div>
        </section>
        <section class="modificar_articulos-container">
            <h2>MODIFICAR ARTICULOS</h2>
            <div class="search-containerMod search-container">
                <input id="search-Modificar" type="text" placeholder="Buscar...">
                <i id="search-button" class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div id="articulos-container"></div>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script type="module" src="assets/js/admin.js"></script>
</body>
</html>