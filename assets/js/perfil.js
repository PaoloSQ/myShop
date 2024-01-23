function usuarioHTML(datosUsuario) {
    const fields = ['id', 'nombre', 'apellido', 'correo', 'telefono', 'direccion', 'ciudad', 'provincia', 'codigo_postal'];
    fields.forEach(field => {
        const element = document.querySelector(`#${field}_usuario`);
        if (element) element.innerHTML = datosUsuario[`${field}_usuario`];
    });
}

function formatarPrecio(precio) {
    return new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'EUR' }).format(precio);
}

function crearElemento(tag, className = '', textContent = '') {
    const elemento = document.createElement(tag);
    if (className) {
        elemento.classList.add(className);
    }
    elemento.textContent = textContent;
    return elemento;
}


function pedidosHTML(pedidos) {
    const pedidosSection = document.querySelector('#pedidos-section');
    pedidosSection.innerHTML = '';

    if (Array.isArray(pedidos) && pedidos.length > 0) {
        const pedidosContainer = crearElemento('div', 'pedidos-container');
        const pedidosPorCodigo = {};

        pedidos.forEach(pedido => {
            const codigoPedido = pedido.codigo_pedido.toString();
            pedidosPorCodigo[codigoPedido] = pedidosPorCodigo[codigoPedido] || [];
            pedidosPorCodigo[codigoPedido].push(pedido);
        });

        for (const codigoPedido in pedidosPorCodigo) {
            const pedidosGrupo = pedidosPorCodigo[codigoPedido];
            const pedidoElemento = crearElemento('div', 'pedido');
            const detallesPedidoElemento = crearElemento('div', 'detalles-pedido');
            detallesPedidoElemento.appendChild(crearElemento('p', 'codigo-pedido', `COD: #${codigoPedido}`));
            detallesPedidoElemento.appendChild(crearElemento('p', '', `FECHA: ${pedidosGrupo[0].fecha_pedido}`));

            const tablaElemento = document.createElement('table');
            const encabezadoElemento = document.createElement('thead');
            const encabezadoColumnas = ['Imagen', 'Nombre', 'Marca', 'Cantidad', 'Total'];

            encabezadoColumnas.forEach(columna => {
                const th = crearElemento('th', '', columna);
                encabezadoElemento.appendChild(th);
            });

            const tablaCuerpoElemento = document.createElement('tbody');
            pedidosGrupo.forEach(pedido => {
                const filaElemento = document.createElement('tr');
                const columnasPedido = [
                    { tipo: 'imagen', valor: pedido.imagenURL_producto },
                    { tipo: 'texto', valor: pedido.nombre_producto },
                    { tipo: 'texto', valor: pedido.marca_producto },
                    { tipo: 'texto', valor: pedido.cantidad_producto },
                    { tipo: 'precio', valor: pedido.total_pagar }
                ];

                columnasPedido.forEach(columna => {
                    const td = document.createElement('td');
                    if (columna.tipo === 'imagen') {
                        const imagenTag = document.createElement('img');
                        imagenTag.src = columna.valor;
                        imagenTag.alt = 'Imagen del producto';
                        td.appendChild(imagenTag);
                    } else if (columna.tipo === 'precio') {
                        td.classList.add('total_producto');
                        td.textContent = formatarPrecio(columna.valor);
                    } else {
                        td.classList.add(`${columna.tipo}_producto`);
                        td.textContent = columna.valor;
                    }
                    filaElemento.appendChild(td);
                });

                tablaCuerpoElemento.appendChild(filaElemento);
            });

            tablaElemento.appendChild(encabezadoElemento);
            tablaElemento.appendChild(tablaCuerpoElemento);

            const totalContainerElemento = crearElemento('div', 'total-container');
            totalContainerElemento.appendChild(crearElemento('p', '', 'Monto Pagado:'));
            totalContainerElemento.appendChild(crearElemento('p', 'total_pagado', formatarPrecio(
                pedidosGrupo.reduce((total, pedido) => total + parseFloat(pedido.total_pagar), 0)
            )));

            pedidoElemento.appendChild(detallesPedidoElemento);
            pedidoElemento.appendChild(tablaElemento);
            pedidoElemento.appendChild(totalContainerElemento);

            pedidosContainer.appendChild(pedidoElemento);
        }

        pedidosSection.appendChild(pedidosContainer);
    } else {
        pedidosSection.appendChild(crearElemento('p', '', 'No hay pedidos disponibles'));
    }
}

// FORMULARIO EDITAR PERFIL

import {
    errorMensajes,
    agregarEventos,
    agregarEventosSelect,
    verificacionTexto,
    verificacionDireccion,
    verificacionMail,
    verificacionContrasena,
    verificacionCodigoPostal,
    verificacionTelefono,
    verificacionRPTContrasena
} from './validaciones.js';

let verificacionesContrasena = {
    "constrasenaVerf": [ false, "Usa 8 digitos mínimo, una mayúscula y un caracter especial"],
    "constrasenaReptVerf": [ false, "Las contraseñas no coinciden."]
}


function modificarDatosAlert(datosUsuario) {
    let nombreInput, apellidoInput, provinciaSelect, ciudadSelect, direccionInput, codigoPostalInput, telefonoInput, correoInput;

    const verificacionesEditarPerfil = {
        nombreVerf: [true, 'Nombre inválido.'],
        apellidoVerf: [true, 'Apellido inválido.'],
        provinciaVerf: [false, 'Provincia inválida.'],
        ciudadVerf: [false, 'Ciudad inválida.'],
        direccionVerf: [true, 'Dirección inválida.'],
        codigoPostalVerf: [true, 'Código postal inválido.'],
        telefonoVerf: [true, 'Teléfono inválido.'],
        correoVerf: [true, 'Correo inválido.'],
    };

    const miAlerta = Swal.mixin({
        title: 'Editar Perfil',
        html: `
        <form class="formulario-sweetAlert" id="formulario-editar">
                <div class="input-container">
                    <label for="nombre_input">Nombre:</label>
                    <input type="text" id="nombre_input" placeholder="Nombre..." value="${datosUsuario.nombre_usuario}" required>
                </div>
                <div class="input-container">
                    <label for="apellido_input">Apellido:</label>
                    <input type="text" id="apellido_input" placeholder="Apellidos..." value="${datosUsuario.apellido_usuario}" required>
                </div>
                <div class="input-container">
                    <label for="correo_input">Correo:</label>
                    <input type="email" id="correo_input" placeholder="example@example.com" value="${datosUsuario.correo_usuario}" required>
                </div>
                <div class="input-container">
                    <label for="telefono_input">Teléfono:</label>
                    <input type="tel" id="telefono_input" placeholder="+34 654321987" value="${datosUsuario.telefono_usuario}" required>
                </div>
                <div class="input-container">
                    <label for="direccion_input">Dirección:</label>
                    <input type="text" id="direccion_input" placeholder="Calle Nombrecalle N°2 Ciudadcentral..." value="${datosUsuario.direccion_usuario}" required>
                </div>
                <div class="input-container">
                    <label for="provincia_select">Provincia:</label>
                    <select class="input" id="provincia-select">
                        <option>Seleccionar Provincia</option>
                    </select>
                </div>
                <div class="input-container">
                    <label for="ciudad_select">Ciudad:</label>
                    <select class="input" id="ciudad-select">
                        <option>Seleccionar Ciudad</option>
                    </select>    
                </div>
                <div class="input-container">
                    <label for="codigoPostal_input">Código Postal:</label>
                    <input type="text" id="codigoPostal_input" placeholder="23456" minlength="5" maxlength="5" value="${datosUsuario.codigo_postal_usuario}" required>
                </div>
            </form>
        `,    
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        didOpen: () => {
            nombreInput = document.querySelector('#nombre_input');
            apellidoInput = document.querySelector('#apellido_input');
            direccionInput = document.querySelector('#direccion_input');
            codigoPostalInput = document.querySelector('#codigoPostal_input');
            telefonoInput = document.querySelector('#telefono_input');
            correoInput = document.querySelector('#correo_input');
            provinciaSelect = document.querySelector('#provincia-select');
            ciudadSelect = document.querySelector('#ciudad-select');

            cargarProvincias(provinciaSelect);
            cargarCiudades(provinciaSelect, ciudadSelect);

            agregarEventos(nombreInput, verificacionesEditarPerfil.nombreVerf, verificacionTexto);
            agregarEventos(apellidoInput, verificacionesEditarPerfil.apellidoVerf, verificacionTexto);
            agregarEventosSelect(provinciaSelect, verificacionesEditarPerfil.provinciaVerf, 'Seleccionar Provincia');
            agregarEventosSelect(ciudadSelect, verificacionesEditarPerfil.ciudadVerf, 'Seleccionar Ciudad');
            agregarEventos(direccionInput, verificacionesEditarPerfil.direccionVerf, verificacionDireccion);
            agregarEventos(codigoPostalInput, verificacionesEditarPerfil.codigoPostalVerf, verificacionCodigoPostal);
            agregarEventos(telefonoInput, verificacionesEditarPerfil.telefonoVerf, verificacionTelefono);
            agregarEventos(correoInput, verificacionesEditarPerfil.correoVerf, verificacionMail);
        }
    });

    miAlerta.fire().then(result => {
        if (result.isConfirmed) {
            let detenerCodigo = false;

            for (const key in verificacionesEditarPerfil) {
                if (verificacionesEditarPerfil.hasOwnProperty(key)) {
                    const valor = verificacionesEditarPerfil[key][0];
                    if (!valor) {
                        detenerCodigo = true;
                        mensajeSweetAlert(verificacionesEditarPerfil[key][1], 'error');
                        break;
                    }
                }
            }

            if (!detenerCodigo) {
                const formData = {
                    nombre: nombreInput.value.trim(),
                    apellido: apellidoInput.value.trim(),
                    provincia: provinciaSelect.value.trim(),
                    ciudad: ciudadSelect.value.trim(),
                    direccion: direccionInput.value.trim(),
                    codigoPostal: codigoPostalInput.value.trim(),
                    telefono: telefonoInput.value.trim(),
                    correo: correoInput.value.trim(),
                };      
                
                actualizarDatos(formData)
                .then(mensaje => {
                    console.log(mensaje);
                })
                .then(() => cargarDatosUsuario())
                .then(datos => {
                    usuarioHTML(datos.datosUsuario);
                })
                .catch(error => console.error(error));
            }
        }
    });
}


// FORMULARIO CAMBIAR CONTRASEÑA

function cambiarContrasenaAlert() {
    let contrasenaActualInput, nuevaContrasenaInput, contrasenaReptInput;

    const verificacionesCambiarContrasena = {
        contrasenaActualVerf: [false, 'Contraseña no válida.'],
        nuevaContrasenaVerf: [false, 'Usa 8 dígitos mínimo, una mayúscula y un caracter especial.'],
        constrasenaReptVerf: [false, 'Las contraseñas no coinciden.'],
    };

    const miAlerta = Swal.mixin({
        title: 'Cambiar Contraseña',
        html: `
        <form class="formulario-sweetAlert" id="formulario-cambiar-contrasena">
            <div class="input-container">
                <label for="contrasena_actual_input">Contraseña Actual:</label>
                <input type="password" id="contrasena_actual_input" placeholder="Contraseña actual..." required>
            </div>
            <div class="input-container">
                <label for="nueva_contrasena_input">Nueva Contraseña:</label>
                <input type="password" id="nueva_contrasena_input" placeholder="Nueva contraseña..." required>
            </div>
            <div class="input-container">
                <label for="repetir_nueva_contrasena_input">Repetir Nueva Contraseña:</label>
                <input type="password" id="repetir_nueva_contrasena_input" placeholder="Repetir nueva contraseña..." required>
            </div>
        </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        didOpen: () => {
            contrasenaActualInput = document.querySelector('#contrasena_actual_input');
            nuevaContrasenaInput = document.querySelector('#nueva_contrasena_input');
            contrasenaReptInput = document.querySelector('#repetir_nueva_contrasena_input');

            agregarEventos(contrasenaActualInput, verificacionesCambiarContrasena.contrasenaActualVerf, verificacionContrasena);
            agregarEventos(nuevaContrasenaInput, verificacionesCambiarContrasena.nuevaContrasenaVerf, verificacionContrasena);
            agregarEventos(contrasenaReptInput, verificacionesCambiarContrasena.constrasenaReptVerf, verificacionRPTContrasena);
        
            nuevaContrasenaInput.addEventListener("input",function(){
                let mensajeError = new errorMensajes(contrasenaReptInput, verificacionesCambiarContrasena.constrasenaReptVerf, verificacionRPTContrasena);
                mensajeError.errores();
            })
        }
    });

    miAlerta.fire().then(result => {
        if (result.isConfirmed) {
            let detenerCodigo = false;

            for (const key in verificacionesCambiarContrasena) {
                if (verificacionesCambiarContrasena.hasOwnProperty(key)) {
                    const valor = verificacionesCambiarContrasena[key][0];
                    if (!valor) {
                        detenerCodigo = true;
                        mensajeSweetAlert(verificacionesCambiarContrasena[key][1], 'error');
                        break;
                    }
                }
            }

            if (!detenerCodigo) {
                const formData = {
                    contrasenaActual: contrasenaActualInput.value.trim(),
                    nuevaContrasena: nuevaContrasenaInput.value.trim(),
                    repetirNuevaContrasena: contrasenaReptInput.value.trim(),
                };

                cambiarContrasena(formData)
                    .then(mensaje => {
                        console.log(mensaje);
                    })
                    .catch(error => console.error(error));
            }
        }
    });
}


document.addEventListener('DOMContentLoaded', () => {

    cargarDatosUsuario()
        .then(datos => {
            usuarioHTML(datos.datosUsuario);
            pedidosHTML(datos.pedidosUsuario);
        })
        .catch(
            error => console.log(error)
        );

    document.querySelector("#cambiar_contrasena").addEventListener('click', () => {
        cambiarContrasenaAlert();
    })

    document.querySelector('#editar_perfil').addEventListener('click', () => {
        cargarDatosUsuario()
            .then(datos => modificarDatosAlert(datos.datosUsuario))
            .catch(error => SweetAlert(error, 'error'));
    });

    document.querySelector('#eliminar_cuenta').addEventListener('click', () => {
        eliminarCuentaAlert();
    });
});


function eliminarCuentaAlert() {
    Swal.fire({
        title: 'Eliminar Cuenta',
        html: `
            <p>¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.</p>
            <input type="password" id="confirmar_contrasena" placeholder="Ingresa tu contraseña" class="swal2-input">
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar cuenta',
        preConfirm: () => {
            const contrasena = Swal.getPopup().querySelector('#confirmar_contrasena').value;
            return { contrasena: contrasena };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const contrasena = result.value.contrasena;
            eliminarCuenta(contrasena)
                .then(mensaje => {
                    console.log(mensaje);
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
    
    
}
