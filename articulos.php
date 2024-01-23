<?php require("assets/php/conexionHead.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Myshop | Articulos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_articulos.css">
</head>
<body>
    <?php require("assets/php/header.php") ?>
    <main>
        <p class="p_descuento">Rebaja del 30%, usando el codigo A1B2C3D4.</p>
        <div id="menu_filtros">
            <ul class="menu-ul">        
                <li class="titulo-menu">FILTROS</li>
                <li class="titulo-menu">CATEGORIAS</li>
                <ul class="link-ul">
                    <li class="menu-link">
                        <input type="checkbox" id="camisetasCheckbox" name="categoria" value="camisetas">
                        <label for="camisetasCheckbox">CAMISETAS</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="pantalonesCheckbox" name="categoria" value="pantalones">
                        <label for="pantalonesCheckbox">PANTALONES</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="zapatillasCheckbox" name="categoria" value="zapatillas">
                        <label for="zapatillasCheckbox">ZAPATILLAS</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="bolsosCheckbox" name="categoria" value="bolsos">
                        <label for="bolsosCheckbox">BOLSOS</label>
                    </li>
                </ul>
                <li class="titulo-menu">MARCAS</li>
                <ul class="link-ul">
                    <li class="menu-link">
                        <input type="checkbox" id="dolceGabbanaCheckbox" name="marca" value="dolce_gabbanna">
                        <label for="dolceGabbanaCheckbox">DOLCE GABBANNA</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="gucciCheckbox" name="marca" value="gucci">
                        <label for="gucciCheckbox">GUCCI</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="jordanCheckbox" name="marca" value="jordan">
                        <label for="jordanCheckbox">JORDAN</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="levisCheckbox" name="marca" value="levis">
                        <label for="levisCheckbox">LEVIS</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="louisVuittonCheckbox" name="marca" value="louis_vuitton">
                        <label for="louisVuittonCheckbox">LOUIS VUITTON</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="nikeCheckbox" name="marca" value="nike">
                        <label for="nikeCheckbox">NIKE</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="poloCheckbox" name="marca" value="polo">
                        <label for="poloCheckbox">POLO</label>
                    </li>
                </ul>
                <li class="titulo-menu">SEXO</li>
                <ul class="link-ul">
                    <li class="menu-link">
                        <input type="checkbox" id="hombreCheckbox" name="sexo" value="hombre">
                        <label for="hombreCheckbox">HOMBRE</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="mujerCheckbox" name="sexo" value="mujer">
                        <label for="mujerCheckbox">MUJER</label>
                    </li>
                    <li class="menu-link">
                        <input type="checkbox" id="ninoCheckbox" name="sexo" value="nino">
                        <label for="ninoCheckbox">NIÑO</label>
                    </li>
                </ul>
            </ul>
            <div id="boton_menu_cerrar_filtro" class="boton_cerrar">
                <i class="fa-solid fa-xmark"></i>
            </div>
        </div>
        <div id="sombra_filtros"></div>

        <section class="opciones-container">
            <div class="opcion" id="cuadricula2-container">
                <i class="fa-solid fa-table-cells-large"></i>
            </div>
            <div class="opcion" id="cuadricula3-container">
                <i class="fa-solid fa-table-cells"></i>
            </div>    
            <div class="opcion" id="filtro-container">
                <i class="fa-solid fa-sliders"></i>
                <p class="boton-p">FILTROS</p>
            </div>
        </section>
        <section class="articulos-container-padre">
            <div id="articulos-container" class="grid1"></div>
            <div id="pagina-container"></div>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script src="assets/js/articulos_grid.js"></script>
</body>
</html>