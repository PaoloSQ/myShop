function API(metodo, accion, datos, callback, contentType = 'application/json') {
    let url = 'assets/php/API/index.php';

    let opciones = {
        method: metodo,
        headers: {},
        body: undefined
    };

    if (metodo === 'GET') {
        url += `?accion=${encodeURIComponent(accion)}`;
        url += '&' + new URLSearchParams(datos).toString();
    } else if (metodo === 'POST') {
        if (contentType === 'multipart/form-data') {
            let formData = new FormData();
            for (let key in datos) {
                formData.append(key, datos[key]);
            }
            formData.append('accion', accion);
            opciones.body = formData;
        } else {
            opciones.headers['Content-Type'] = 'application/json';
            opciones.body = JSON.stringify({ accion, datos });
        }
    }

    fetch(url, opciones)
        .then(response => {
            console.log('Estado de la respuesta:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Respuesta:', data);
            callback(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}





function SweetAlert(mensaje, tipo, redireccion) {
    mensajeSweetAlert(mensaje, tipo);
    if (tipo === 'exitoso' && redireccion) {
        setTimeout(function () {
            window.location.href = redireccion;
        }, 1200);
    }
}

function registrarUsuario(nombre, apellidos, provincia, ciudad, direccion, codigoPostal, telefono, correo, contrasena) {
    const datos = {
        nombre,
        apellidos,
        provincia,
        ciudad,
        direccion,
        codigoPostal,
        telefono,
        correo,
        contrasena
    };
    
    API('POST', 'registro', datos, function (data) {
        SweetAlert(data.mensaje, data.tipo, 'login.php');
    });
}

function loginUsuario(correo, contrasena) {
    const datos = {
        correo,
        contrasena
    };

    API('POST', 'login', datos, function (data) {
        SweetAlert(data.mensaje, data.tipo, 'index.php');
    });
}


function subirArticulo(nombre, existencias, categoria, marca, precio, sexo, imagen, descripcion) {

    precio = precio.toString().replace('.', ',');

    const datos = {
        nombre,
        existencias,
        categoria,
        marca,
        precio,
        sexo,
        imagen,
        descripcion
    };

    API('POST', 'subirArticulo', datos, function (data) {
        SweetAlert(data.mensaje, data.tipo, null);
        return data.tipo;
    }, 'multipart/form-data');
}



function modificarArticulo(idArticulo, nombre, existencias, categoria, marca, precio, sexo, imagen, descripcion) {

    precio = precio.toString().replace('.', ',');
    
    const datos = {
        idArticulo,
        nombre,
        existencias,
        categoria,
        marca,
        precio,
        sexo,
        imagen,
        descripcion
    };

    return new Promise((resolve, reject) => {
        API('POST', 'modificarArticulo', datos, function (data) {
            SweetAlert(data.mensaje, data.tipo, null);

            if (data.tipo === 'exitoso') {
                resolve(data.tipo);
            } else {
                reject(data.tipo);
            }
        }, 'multipart/form-data');
    });
}



function borrarArticulo(idArticulo) {
    const datos = {
        idArticulo
    };

    API('POST', 'borrarArticulo', datos, function (data) {
        SweetAlert(data.mensaje, data.tipo, null);
        return data.tipo;
    }, 'application/x-www-form-urlencoded');
}


function obtenerProducto(idProducto) {
    return new Promise((resolve, reject) => {
        API('GET', 'cargarProductoID', { idProducto }, function (data) {
            if (data.tipo === 'exitoso') {
                resolve(data);
            } else {
                SweetAlert(data.mensaje, data.tipo, 'articulos.php');
                reject(data.mensaje);
            }
        });
    });
}


async function cargarProducto(idProducto) {
    return new Promise((resolve, reject) => {
        const datos = {
            idProducto
        };

        API('POST', 'obtenerDetallesArticulo', datos, function (data) {
            if (data.tipo === 'exitoso') {
                resolve(data.detalles);
            } else {
                SweetAlert(data.mensaje, 'error');
                reject(data.mensaje);
            }
        });
    });
}

function agregarAlCarrito(idProducto) {
    const datos = {
        idProducto
    };

    return new Promise((resolve, reject) => {
        API('POST', 'agregarAlCarrito', datos, function (data) {
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, 'exitoso');
                resolve();
            } else {
                SweetAlert(data.mensaje, 'error');
                reject(data.mensaje);
            }
        });
    });
}


function enviarComentario(idProducto, comentario) {
    const datos = {
        idProducto,
        comentario
    };

    return new Promise((resolve, reject) => {
        API('POST', 'enviarComentario', datos, function (data) {
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, data.tipo);
                resolve({
                    tipo: data.tipo,
                    mensaje: data.mensaje,
                    comentarios: data.comentarios
                });
            } else {
                SweetAlert(data.mensaje, 'error');
                reject(data.mensaje);
            }
        });
    });
}


function detallesCarrito() {
    return new Promise((resolve, reject) => {
        API('POST', 'detallesCarrito', {}, function (data) {
            if (data.tipo === 'exitoso') {
                resolve(data.productosCarrito);
            } else {
                reject('Error al obtener detalles del carrito');
            }
        });
    });
}

function eliminarProductoCarrito(idProducto) {
    return new Promise((resolve, reject) => {
        const datos = {
            idProducto
        };

        API('POST', 'eliminarProductoCarrito', datos, function (data) {
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, 'exitoso');
                resolve('Producto eliminado del carrito');
            } else {
                SweetAlert(data.mensaje, 'error');
                reject('Error al eliminar el producto del carrito');
            }
        });
    });
}


function actualizarCantidad(idProducto, cantidad) {
    return new Promise((resolve, reject) => {
        const datos = {
            idProducto,
            cantidad
        };
        API('POST', 'actualizarCantidadProducto', datos, function (data) {
            if (data.tipo === 'exitoso') {
                resolve('Cantidad actualizada exitosamente');
            } else {
                reject('Error al actualizar la cantidad del producto en el carrito');
            }
        });
    });
}


function realizarPedido(totalPagar) {
    return new Promise((resolve, reject) => {
        const datos = {
            totalPagar
        };

        API('POST', 'realizarPedido', datos, function (data) {
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, 'exitoso');
                resolve('Pedido realizado exitosamente');
            } else {
                SweetAlert(data.mensaje, 'error');
                reject('Error al realizar el pedido');
            }
        });
    });
}


function cargarArticulosGET() {
    return new Promise((resolve, reject) => {
        const urlParametros = new URLSearchParams(window.location.search);
        const marcas = urlParametros.get('marcas');
        const categorias = urlParametros.get('categorias');
        const sexo = urlParametros.get('sexo');
        let pagina = urlParametros.get('pag');
        pagina = pagina !== null ? pagina : 1;

        API('GET', 'cargarArticulosURL', { marcas, categorias, sexo, pagina }, function (data) {
            resolve(data);
        });
    });
}


async function cargarTodosArticulos(nombre) {
    return new Promise((resolve, reject) => {
        const datos = { nombre };

        API('POST', 'cargarTodosArticulos', datos, function (data) {
            resolve(data);
        });
    });
}


async function cargarArticulosDinamico(categorias, marcas, sexo, nombre, pagina) {
    return new Promise((resolve, reject) => {
        const datos = {
            categorias,
            marcas,
            sexo,
            nombre,
            pagina
        };

        API('POST', 'cargarArticulosDinamico', datos, function (data) {
            resolve(data);
        });
    });
}


function cargarDatosUsuario() {
    return new Promise(function(resolve, reject) {
        API('POST', 'cargarDatosUsuario', {}, function (data) {
            if (data.tipo === 'exitoso') {
                resolve(data.datosUsuario);
            } else {
                reject(data.mensaje);
            }
        });
    });
}

function actualizarDatos(nuevosDatos) {
    const datos = { nuevosDatos };

    return new Promise((resolve, reject) => {
        API('POST', 'actualizarDatosUsuario', datos, function (data) {
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, 'exitoso');
                resolve(data.mensaje);
            } else {
                SweetAlert(data.mensaje, 'error');
                reject(data.mensaje);
            }
        });
    });
}

function cambiarContrasena(formData) {
    return new Promise((resolve, reject) => {
        API('POST', 'cambiarContrasena', formData, function (data) {
            SweetAlert(data.mensaje, data.tipo);
            if (data.tipo === 'exitoso') {
                resolve(data.mensaje);
            } else {
                reject(data.mensaje);
            }
        });
    });
}

function eliminarCuenta(contrasena) {
    return new Promise((resolve, reject) => {
        const datos = { contrasena };

        API('POST', 'eliminarCuenta', datos, function (data) {
            SweetAlert(data.mensaje, data.tipo, null);
            if (data.tipo === 'exitoso') {
                SweetAlert(data.mensaje, data.tipo, 'index.php');
                resolve(data.tipo);
            } else {
                reject(data.tipo);
            }
        });
    });
}


function enviarCorreo(nombre, correo, asunto, mensaje) {
    const datos = {
        nombre,
        correo,
        asunto,
        mensaje
    };

    return new Promise((resolve, reject) => {
        API('POST', 'enviarCorreo', datos, function (data) {
            SweetAlert(data.mensaje, data.tipo);

            if (data.tipo === 'exitoso') {
                resolve(data.mensaje);
            } else {
                reject(data.mensaje);
            }
        });
    });
}
