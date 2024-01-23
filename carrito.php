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
    <title>Myshop | Carrito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="icon" href="assets/img/icons/logo_ico.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style_carrito.css">
</head>
<body>
    <?php require("assets/php/header.php") ?>
    <main>
        <section class="detalles_productos-container">
            <h2>Carrito de Compras</h2>
            <table class="tabla-carrito">
                <thead>
                    <tr>
                        <th>Imagen del Producto</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody id="articulosCarrito-container"></tbody>
            </table>
            <div class="totalPagar-container">
                <div class="total-container">
                    <p class="bold">Total a pagar: </p>
                    <p id="montoTotal">0.00€</p>
                </div>
                <p id="realizarPedido-boton" class="boton">Realizar Pedido</p>
            </div>
        </section>
    </main>
    <?php require("assets/php/footer.php") ?>
    <script src="assets/js/carrito.js"></script>
</body>
</html>