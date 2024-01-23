<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_home.css">
</head>
<body>
    <?php require("assets/php/header.php") ?>
    <main>
        <p class="p_descuento">Rebaja del 30%, usando el codigo A1B2C3D4.</p>
        <section class="marcas-container-padre">
            <div class="marcas-container">
                <img class="marca" src="assets/img/marcas/dolce_gabbana.png" alt="">
                <img class="marca" src="assets/img/marcas/gucci.png" alt="">
                <img class="marca" src="assets/img/marcas/jordan.png" alt="">
                <img class="marca" src="assets/img/marcas/levis.png" alt="">
                <img class="marca" src="assets/img/marcas/luisvuitton.png" alt="">
                <img class="marca" src="assets/img/marcas/nike.png" alt="">
                <img class="marca" src="assets/img/marcas/polo.png" alt="">
                <img class="marca" src="assets/img/marcas/dolce_gabbana.png" alt="">
                <img class="marca" src="assets/img/marcas/gucci.png" alt="">
                <img class="marca" src="assets/img/marcas/jordan.png" alt="">
                <img class="marca" src="assets/img/marcas/levis.png" alt="">
                <img class="marca" src="assets/img/marcas/luisvuitton.png" alt="">
            </div>
        </section>
        <h2>MARCAS</h2>
        <section class="novedades-container">
            <a class="articulo-novedad" href="articulos.php?marcas=gucci"><img src="assets/img/articulos_home/gucci_camiseta.webp" alt=""><p>GUCCI</p></a>
            <a class="articulo-novedad" href="articulos.php?marcas=levis"><img src="assets/img/articulos_home/levis_pantalones.webp" alt=""><p>LEVIS</p></a>
            <a class="articulo-novedad" href="articulos.php?marcas=gucci"><img src="assets/img/articulos_home/gucci_camiseta2.webp" alt=""><p>GUCCI</p></a>
            <a class="articulo-novedad" href="articulos.php?marcas=nike"><img src="assets/img/articulos_home/nike-jordan_zapatillas.webp" alt=""><p>NIKE</p></a>
            <a class="articulo-novedad" href="articulos.php?marcas=jordan"><img src="assets/img/articulos_home/nike-jordan_zapatillas3.webp" alt=""><p>JORDAN</p></a>
        </section>
        <h2>CATEGORIAS</h2>
        <section class="categorias-container">
            <a class="articulo-categoria" href="articulos.php?sexo=mujer"><img src="assets/img/articulos_home/mujer.webp" alt=""><p>MUJER</p></a>
            <a class="articulo-categoria" href="articulos.php?sexo=hombre"><img src="assets/img/articulos_home/hombre.webp" alt=""><p>HOMBRE</p></a>
            <a class="articulo-categoria" href="articulos.php?sexo=nino"><img src="assets/img/articulos_home/niños.webp" alt=""><p>NIÑOS</p></a>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script src="assets/js/marcas_animacion.js"></script>
</body>
</html>