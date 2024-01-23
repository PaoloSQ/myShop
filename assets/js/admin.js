// CREAR ARTICULO

function crearArticuloHTML(articulo) {
    let articuloDiv = document.createElement('div');
    articuloDiv.classList.add('articulo');
    articuloDiv.id = articulo.id_producto;

    let imagen = document.createElement('img');
    imagen.src = articulo.imagenURL_producto;
    imagen.alt = articulo.nombre_producto;

    let nombre = document.createElement('p');
    nombre.classList.add('nombreArticulo');
    nombre.textContent = articulo.nombre_producto;

    let precio = document.createElement('p');
    precio.classList.add('precioArticulo');
    precio.textContent = articulo.precio_producto + "€";

    let botonesContainer = document.createElement('div');
    botonesContainer.classList.add('botones_editar-container');

    let botonBorrar = document.createElement('i');
    botonBorrar.classList.add('fa-solid', 'fa-trash', 'borrarArticulo');

    let botonModificar = document.createElement('i');
    botonModificar.classList.add('fa-solid', 'fa-pen', 'modificarArticulo');

    botonesContainer.appendChild(botonBorrar);
    botonesContainer.appendChild(botonModificar);

    articuloDiv.appendChild(imagen);
    articuloDiv.appendChild(nombre);
    articuloDiv.appendChild(precio);
    articuloDiv.appendChild(botonesContainer);
    
    return articuloDiv;
}


// VERIFICACIONES

const botonSubmitArticulo = document.querySelector("#subir_articulo-submit");
const existenciasInput = document.querySelector("#existenciasArticulo_input");
const categoriaInput = document.querySelector("#categoriaArticulo_input");
const marcaInput = document.querySelector("#marcaArticulo_input");
const sexoInput = document.querySelector("#sexoArticulo_input");
const descripcionInput = document.querySelector("#descripcionArticulo_input");
const nombreInput = document.querySelector("#nombreArticulo_input");
const precioInput = document.querySelector("#precioArticulo_input");
const imagenInput = document.querySelector("#imagenArticulo_input");
const formularioEditar = document.querySelector('#insertarArticulo-form');


import {
    agregarEventos,
    verificacionTexto,
    verificacionPrecio,
    verificacionExistencia,
    verificacionVacio
} from './validaciones.js';


let verificaciones = {
    "nombreVerf": [false, "Nombre del artículo inválido."],
    "existenciasVerf": [false, "Cantidad inválida."],
    "categoriaVerf": [false, "Selecciona una categoria correcta"],
    "marcaVerf": [false, "Selecciona una marca correcta"],
    "sexoVerf": [false, "Selecciona un sexo correcto"],
    "precioVerf": [false, "Precio inválido."],
    "descripcionVerf": [false, "Descripción inválida."],
};

agregarEventos(nombreInput, verificaciones.nombreVerf, verificacionTexto);
agregarEventos(existenciasInput, verificaciones.existenciasVerf, verificacionExistencia);
agregarEventos(categoriaInput, verificaciones.categoriaVerf, verificacionVacio);
agregarEventos(marcaInput, verificaciones.marcaVerf, verificacionVacio);
agregarEventos(precioInput, verificaciones.precioVerf, verificacionPrecio);
agregarEventos(sexoInput, verificaciones.sexoVerf, verificacionVacio);
agregarEventos(descripcionInput, verificaciones.descripcionVerf, verificacionVacio);


// VISTA PREVIA 

const imagenVP = document.querySelector("#vp_imagen");
const nombreVP = document.querySelector("#vp_nombre");
const precioVP = document.querySelector("#vp_precio");

function isEmpty(value) {
    return value == null || value.trim() === '';
}

function vistaPrevia(){
    if (imagenInput.files.length > 0) {
        const imagenTemporal = URL.createObjectURL(imagenInput.files[0]);
        imagenVP.setAttribute("src", imagenTemporal);
    } else if (isEmpty(imagenVP.getAttribute("src"))) {
        imagenVP.setAttribute("src", "assets/img/articulos/default.webp");
    }
    
    if (!isEmpty(nombreInput.value.trim())) {
        nombreVP.textContent = nombreInput.value.trim().toUpperCase();
    } else if (isEmpty(nombreVP.textContent.trim())) {
        nombreVP.textContent = "DEFAULT";
    }
    
    if (!isEmpty(precioInput.value.trim())) {
        const precioConDecimales = parseFloat(precioInput.value.trim()).toFixed(2);
        precioVP.textContent = precioConDecimales + "€";
    } else if (isEmpty(precioVP.textContent.trim())) {
        precioVP.textContent = "999€";
    }
}

nombreInput.addEventListener("input", vistaPrevia);
precioInput.addEventListener("input", vistaPrevia);
imagenInput.addEventListener("input", vistaPrevia);
document.addEventListener("DOMContentLoaded", vistaPrevia);


function submitArticulo() {
    let detenerCodigo = false;

    for (const key in verificaciones) {
        if (verificaciones.hasOwnProperty(key) && !verificaciones[key][0]) {
            detenerCodigo = true;
            mensajeSweetAlert(verificaciones[key][1], "error");
            break;
        }
    }

    async function manejarSubida() {
        if (!detenerCodigo) {
            let resultadoSubida = '';
            try {
                idArticulo !== null
                    ? resultadoSubida = await modificarArticulo(idArticulo, nombreInput.value, existenciasInput.value, categoriaInput.value, marcaInput.value, precioInput.value, sexoInput.value, imagenInput.files[0], descripcionInput.value)
                    : resultadoSubida = await subirArticulo(nombreInput.value, existenciasInput.value, categoriaInput.value, marcaInput.value, precioInput.value, sexoInput.value, imagenInput.files[0], descripcionInput.value);
                
                if (resultadoSubida === 'exitoso') {
                    console.log(resultadoSubida);
                    formularioEditar.reset();
                    idArticulo = null;
                    vistaPrevia();
                    cargarArticulosMOD();
                }
            } catch (error) {
                console.error(error);
            }
        }
    }
    manejarSubida();
}

let idArticulo = null;
botonSubmitArticulo.addEventListener("click", submitArticulo);


// CARGA DE ARTICULOS DINAMICO

const searchModificar = document.querySelector("#search-Modificar");
const articulosContainer = document.querySelector("#articulos-container");

function cargarArticulosMOD() {
    let nombre = Array.from([searchModificar.value]).map(valor => valor);
    let articulos = cargarTodosArticulos(nombre);

    articulos.then(data => {
        articulosContainer.innerHTML = '';

        data.articulos.forEach(articulo => {
            let articuloNodo = crearArticuloHTML(articulo);
            articulosContainer.appendChild(articuloNodo);
        });

        let botonesBorrar = document.querySelectorAll('.borrarArticulo');
        let botonesModificar = document.querySelectorAll('.modificarArticulo');

        botonesBorrar.forEach(boton => {
            boton.addEventListener('click', function () {
                let contenedorPadre = boton.closest('.articulo');
                let idArticuloCargar = contenedorPadre.id;

                // SWEETALERT

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, borrarlo'
                }).then((result) => {
                    if (result.isConfirmed) {
                        borrarArticulo(idArticuloCargar);
                        cargarArticulosMOD();
                    }
                });
            });
        });

        botonesModificar.forEach(boton => {
            boton.addEventListener('click', function () {
                let contenedorPadre = boton.closest('.articulo');
                idArticulo = contenedorPadre.id;
        
                cargarProducto(idArticulo)
                    .then(detalles => {

                        document.querySelector('#nombreArticulo_input').value = detalles.nombre_producto;
                        document.querySelector('#existenciasArticulo_input').value = detalles.existencias_producto;
                        document.querySelector('#categoriaArticulo_input').value = detalles.categoria_producto;
                        document.querySelector('#marcaArticulo_input').value = detalles.marca_producto;
                        document.querySelector('#precioArticulo_input').value = detalles.precio_producto;
                        document.querySelector('#sexoArticulo_input').value = detalles.sexo_producto;
                        document.querySelector('#descripcionArticulo_input').value = detalles.descripcion_producto;

                        verificaciones.nombreVerf[0] = true;
                        verificaciones.existenciasVerf[0] = true;
                        verificaciones.precioVerf[0] = true;
                        verificaciones.descripcionVerf[0] = true;

                        const imagenVP = document.querySelector("#vp_imagen");
                        if (detalles.imagenURL_producto) {
                            imagenVP.src = detalles.imagenURL_producto;
                        } else {
                            imagenVP.src = 'assets/img/articulos/default.webp';
                        }

                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                        vistaPrevia();
                    })
                    .catch(error => { console.error('Error al obtener detalles del artículo:', error); })
                });
        });
    });
}

searchModificar.addEventListener("input", cargarArticulosMOD);
document.addEventListener("DOMContentLoaded", cargarArticulosMOD);