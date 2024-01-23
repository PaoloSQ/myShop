function detallesHTML(productosCarrito) {
    const articulosCarritoContainer = document.querySelector('#articulosCarrito-container');
    const montoTotalElement = document.querySelector('#montoTotal');

    articulosCarritoContainer.innerHTML = '';

    productosCarrito.forEach((producto) => {
        const filaProducto = document.createElement('tr');
        filaProducto.innerHTML = `
            <td><img src="${producto.imagenURL_producto}" alt="${producto.nombre_producto}"></td>
            <td>${producto.nombre_producto}</td>
            <td>${producto.precio_producto ? parseFloat(producto.precio_producto).toFixed(2) + '€' : 'Precio no disponible'}</td>
            <td><input class="input_cantidad" type="number" data-id="${producto.id_producto}" value="${producto.cantidad_producto}" min="1"></td>
            <td>${typeof producto.monto_total === 'string' ? parseFloat(producto.monto_total).toFixed(2) + '€' : 'Total no disponible'}</td>
            <td>${producto.id_producto ? `<button class="eliminarProducto" data-id="${producto.id_producto}"><i class="fa-solid fa-x"></i></button>` : ''}</td>
        `;

        articulosCarritoContainer.appendChild(filaProducto);
    });

    montoTotalElement.textContent = calcularTotal(productosCarrito);
    
    const cantidadInput = articulosCarritoContainer.querySelectorAll('.input_cantidad');
    cantidadInput.forEach((input) => {
        input.addEventListener('change', () => nuevaCantidad(input.dataset.id, input.value));
    });

    const botonesEliminar = document.querySelectorAll('.eliminarProducto');
    botonesEliminar.forEach((boton) => {
        boton.addEventListener('click', () => eliminarProducto(boton.dataset.id));
    });

    const realizarPedidoBoton = document.querySelector('#realizarPedido-boton');
    realizarPedidoBoton.addEventListener('click', hacerPedido);

}

function calcularTotal(productosCarrito) {
    let montoTotal = 0;

    productosCarrito.forEach((producto) => {
        if (producto.monto_total) {
            montoTotal += parseFloat(producto.monto_total);
        }
    });

    return montoTotal.toFixed(2) + '€';
}

function confirmarPedido(montoTotal) {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: 'Procesando pedido...',
            text: 'Espere un momento por favor.',
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            }
        });

        setTimeout(() => {
            Swal.close();

            Swal.fire({
                title: 'Confirmación de Pedido',
                text: `Monto total a pagar: ${montoTotal}`,
                icon: 'success',
                showCancelButton: true,
                showConfirmButton: true,
                cancelButtonText : 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    resolve();
                } else {
                    reject(new Error('Pedido cancelado'));
                }
            });
        }, 2000);
    });
}

function cargarCarrito() {
    detallesCarrito()
        .then((productosCarrito) => {
            detallesHTML(productosCarrito);
            const montoTotalElement = document.querySelector('#montoTotal');
            montoTotalElement.textContent = calcularTotal(productosCarrito);
        })
        .catch((error) => {
            console.error('Error al cargar el carrito:', error);
        });
}

function eliminarProducto(idProducto) {
    eliminarProductoCarrito(idProducto)
        .then(() => cargarCarrito())
        .catch((error) => {
            console.error('Error al eliminar el producto:', error);
        });
}

function hacerPedido() {
    detallesCarrito()
        .then((productosCarrito) => {
            const montoTotal = calcularTotal(productosCarrito);

            if (productosCarrito.length > 0) {
                return confirmarPedido(montoTotal)
                    .then(() => realizarPedido(montoTotal))
                    .then(() => cargarCarrito());
            } else {
                throw new Error('No hay productos en el carrito para realizar el pedido.');
            }
        })
        .catch((error) => {
            console.error('Error al realizar el pedido:', error);
        });
}

function nuevaCantidad(idProducto, cantidad) {
    actualizarCantidad(idProducto, cantidad)
        .then(() => cargarCarrito())
        .catch((error) => {
            console.error('Error al actualizar la cantidad del producto:', error);
        });
}


document.addEventListener('DOMContentLoaded', function () {
    cargarCarrito();
});