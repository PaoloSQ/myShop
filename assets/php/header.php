<header>
    <nav>
        <div class="icon-container">
            <div class="icon menu_icon-container">
                <i class="fa-solid fa-bars"></i>
                <p>Menú</p>
            </div>
            <a href='
                <?php 
                    if ($sesion->getID_Usuario() === null) {
                        echo "login.php";
                    } else if ($sesion->getID_Usuario() === '2') {
                        echo "admin.php";
                    } else {
                        echo "perfil.php";
                    }
                ?>' 
            class="icon login_icon-container">
                <i class="fa-regular fa-user"></i>
                <p>
                    <?php
                        if($sesion->getName_Usuario()===null){
                            echo "Login";
                        }else{
                            echo $sesion->getName_Usuario();
                        }
                    ?>
                </p>
            </a>
        </div>
        <a id="icon-logo" href="index.php"><img src="assets/img/icons/logo.webp" alt="Logo Pagina" width="55px"></a>
        <div class="icon-container">
            <div class="icon shopping_ico-container">
                <i class="fa-solid fa-cart-shopping"></i>
                <p>Carrito</p>
            </div>
            <div class="icon contact_ico-container">
                <i class="fa-solid fa-phone"></i>
                <p>Contacto</p>
            </div>
        </div>
    </nav>
    <div class="search-container">
        <div class="search-input-container">
            <input id="search-input" type="text" placeholder="Buscar...">
            <i id="search-button" class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="search_resultado-container-absolute">
            <div id="search_resultado-container"></div>
        </div>
    </div>
    <div class="menu-container">
        <ul class="menu-ul">        
            <li class="titulo-menu"><a href="index.php">HOME</a></li>
            <li class="titulo-menu">CATEGORIAS</li>
            <ul class="link-ul">
                <li class="menu-link"><a href="articulos.php?categorias=camisetas">CAMISETAS</a></li>
                <li class="menu-link"><a href="articulos.php?categorias=pantalones">PANTALONES</a></li>
                <li class="menu-link"><a href="articulos.php?categorias=zapatillas">ZAPATILLAS</a></li>
                <li class="menu-link"><a href="articulos.php?categorias=bolsos">BOLSOS</a></li>
            </ul>
            <li class="titulo-menu">MARCAS</li>
            <ul class="link-ul">
                <li class="menu-link"><a href="articulos.php?marcas=dolce_gabbanna">DOLCE GABBANNA</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=gucci">GUCCI</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=jordan">JORDAN</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=levis">LEVI</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=louis_vuitton">LOUIS VUITTON</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=nike">NIKE</a></li>
                <li class="menu-link"><a href="articulos.php?marcas=polo">POLO</a></li>
            </ul>
            <li class="titulo-menu">SEXO</li>
            <ul class="link-ul">
                <li class="menu-link"><a href="articulos.php?sexo=hombre">HOMBRE</a></li>
                <li class="menu-link"><a href="articulos.php?sexo=mujer">MUJER</a></li>
                <li class="menu-link"><a href="articulos.php?sexo=nino">NIÑO</a></li>
            </ul>
            <li class="titulo-menu">ATENCION AL CLIENTE</li>
            <ul class="link-ul">
                <li class="menu-link"><a href="#">ENTREGAS</a></li>
                <li class="menu-link"><a href="#">BUSCAR PEDIDO</a></li>
                <li class="menu-link"><a href="#">DEVOLUCIONES Y REEMBOLSOS</a></li>
                <li class="menu-link"><a href="#">AYUDA</a></li>
                <li class="menu-link"><a href="#">DONDE NOS ENCONTRAMOS</a></li>
            </ul>
            <?php if($sesion->getName_Usuario()!==null) echo '<a href=?cerrar_sesion class="menu-link menu-link-rojo">CERRAR SESION</a>';?>
        </ul>
        <div id="boton_cerrar-menu" class="boton_cerrar">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div id="sombra"></div>
</header>