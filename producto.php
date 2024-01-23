<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop | Productos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_producto.css">
</head>
<body>
    <?php require("assets/php/header.php") ?>
    <main>
        <section class="articulo-container">
            <div id="imagen-container">
                <img id="imagen-producto" src="assets/img/articulos/default.webp" alt="Producto por defecto">
            </div>
            <div class="detalles-container">
                <h2 id="nombre_producto">Producto por defecto</h2>
                <p id="stock_producto"><i class="fa-solid fa-box"></i> <span class="bold">Stock:</span> 999</p>
                <p id="categoria_producto"><i class="fa-solid fa-shirt"></i> <span class="bold">Categoría:</span> Default</p>
                <p id="marca_producto"><i class="fa-brands fa-vuejs"></i> <span class="bold">Marca:</span> Default</p>
                <p><span class="bold"><i class="fa-regular fa-clock"></i> Llegada:</span> 48 horas</p>
                <div class="descripcion_producto-container">
                    <span class="bold"><i class="fa-solid fa-pen"></i> Descripción:</span>
                    <p id="descripcion">Descripción por defecto del producto.</p>
                </div>
                <p id="precio_producto">Precio: <span class="bold">999.99€</span></p>
                <p id="comprar_boton" class="boton">AGREGAR AL CARRITO</p>
            </div>
        </section>
        <section class="comentarios-section">
            <h2>COMENTARIOS</h2>
            <div class="hacer_comentario-container">
                <textarea id="comentario-input" placeholder="Escribe un comentario..."></textarea>
                <p id="enviarComentario-boton" class="boton">ENVIAR COMENTARIO</p>
            </div>
            <div class="comentarios-container"></div>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script src="assets/js/producto.js"></script>
</body>
</html>