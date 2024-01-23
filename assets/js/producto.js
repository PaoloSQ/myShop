// CREAR HTML DEL DETALLE DEL PRODUCTO
function detallesHTML(producto) {
    document.querySelector('#nombre_producto').textContent = producto.nombre_producto;
    document.querySelector('#stock_producto').innerHTML = `<i class="fa-solid fa-box"></i> <span class="bold">Stock:</span> ${producto.existencias_producto}`;
    document.querySelector('#categoria_producto').innerHTML = `<i class="fa-solid fa-shirt"></i> <span class="bold">Categoría:</span> ${producto.categoria_producto}`;
    document.querySelector('#marca_producto').innerHTML = `<i class="fa-brands fa-vuejs"></i> <span class="bold">Marca:</span> ${producto.marca_producto}`;
    document.querySelector('#descripcion').innerHTML = `${producto.descripcion_producto}`;
    document.querySelector('#imagen-producto').src = producto.imagenURL_producto;
    document.querySelector('#precio_producto').innerHTML = `Precio: <span class="bold">${producto.precio_producto}€</span>`;
}

// CREAR HTML DE LOS COMENTARIOS
function comentariosHTML(comentarios) {
    const comentariosContainer = document.querySelector('.comentarios-container');
    
    comentariosContainer.innerHTML = '';

    comentarios.forEach((comentario) => {
        const comentarioContainer = document.createElement('div');
        comentarioContainer.classList.add('comentario-container');

        const usuarioP = document.createElement('p');
        usuarioP.classList.add('bold');
        usuarioP.textContent = comentario.nombre_usuario + ':';

        const comentarioDiv = document.createElement('div');
        comentarioDiv.classList.add('comentario');
        comentarioDiv.innerHTML = `<p>${comentario.comentario}</p>`;

        comentarioContainer.appendChild(usuarioP);
        comentarioContainer.appendChild(comentarioDiv);

        comentariosContainer.appendChild(comentarioContainer);
    });
}

// OBTENER ID DE LA URL
const urlParams = new URLSearchParams(window.location.search);
const idProducto = urlParams.get('id_producto');

// COMPRAR PRODUCTO

const comprarBoton = document.querySelector("#comprar_boton");

function comprarProducto() {
    agregarAlCarrito(idProducto)
        .then(() => {
            console.log('Producto agregado al carrito');
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

// CARGAR DETALLES DEL PRODUCTO Y COMENTARIOS
if (idProducto) {
    obtenerProducto(idProducto)
    .then((producto) => {
        detallesHTML(producto.detalleProducto);
        comentariosHTML(producto.comentariosProducto);

        if (producto.detalleProducto.existencias_producto === 0) {
            mensajeSweetAlert('Producto agotado!', 'informativo');
            comprarBoton.removeEventListener('click', comprarProducto);
            comprarBoton.style.pointerEvents = 'none';
        } else {
            comprarBoton.addEventListener('click', comprarProducto);
            comprarBoton.style.pointerEvents = 'auto';
        }
    })
    .catch((error) => {
        console.error('Error al cargar el producto:', error);
        setTimeout(() => {
            window.location.href = "articulos.php";
        }, 1000);
    });
} else {
    console.error('ID de producto no proporcionado en la URL');
    setTimeout(() => {
        window.location.href = "articulos.php";
    }, 1000);
}
    
// HACER COMENTARIO

const comentarioBoton = document.querySelector("#enviarComentario-boton");
comentarioBoton.addEventListener("click", function () {
    const comentarioInput = document.querySelector('#comentario-input');
    const comentario = comentarioInput.value.trim();

    if (comentario !== '') {
        enviarComentario(idProducto, comentario)
            .then((comentarios) => {
                comentariosHTML(comentarios.comentarios);
            })
            .catch((error) => {
                console.error('Error al enviar el comentario:', error);
            });
    } else {
        mensajeSweetAlert('Por favor, ingrese un comentario antes de enviarlo.', "error");
    }
});
