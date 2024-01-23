// CUADRICULAS

const articulosContainer = document.querySelector("#articulos-container");
const cuadricula1 = document.querySelector("#cuadricula2-container");
const cuadricula2 = document.querySelector("#cuadricula3-container");

cuadricula1.addEventListener("click", function(){
    articulosContainer.classList.add("grid1");
    articulosContainer.classList.remove("grid2");
});

cuadricula2.addEventListener("click", function(){
    articulosContainer.classList.add("grid2");
    articulosContainer.classList.remove("grid1");
});

// MENU FILTROS

const boton_filtro = document.querySelector("#filtro-container");
const menu_filtros = document.querySelector("#menu_filtros");
const sombra_filtros = document.querySelector("#sombra_filtros");
const boton_menu_cerrar_filtro = document.querySelector('#boton_menu_cerrar_filtro')

boton_filtro.addEventListener("click", function(){
    sombra_filtros.style.display = "initial";
    menu_filtros.style.right = 0;
});

boton_menu_cerrar_filtro.addEventListener("click", function(){
    sombra_filtros.style.display = "none";
    menu_filtros.style.right = menu_filtros.style.right === '0px' ? `-${menuWidth*25}px` : '0px';
});

sombra_filtros.addEventListener("click", function(){
    sombra_filtros.style.display = "none";
    menu_filtros.style.right = menu_filtros.style.right === '0px' ? `-${menuWidth*25}px` : '0px';
})

// CREAR ARTICULO

function crearArticuloHTML(articulo) {
    let enlace = document.createElement('a');
    enlace.href = 'producto.php?id_producto=' + articulo.id_producto;

    let articuloDiv = document.createElement('div');
    articuloDiv.classList.add('articulo');
    articuloDiv.id = articulo.id_producto;

    let imagen = document.createElement('img');
    imagen.src = articulo.imagenURL_producto;
    imagen.alt = articulo.nombre_producto;

    let descripcionArticulo = document.createElement('div');
    descripcionArticulo.classList.add('descripcion_articulo');

    let nombre = document.createElement('p');
    nombre.textContent = articulo.nombre_producto;

    let precio = document.createElement('p');
    precio.textContent = articulo.precio_producto + "€";

    descripcionArticulo.appendChild(nombre);
    descripcionArticulo.appendChild(precio);

    articuloDiv.appendChild(imagen);
    articuloDiv.appendChild(descripcionArticulo);
    enlace.appendChild(articuloDiv);

    enlace.addEventListener('click', function (event) {
        event.preventDefault();
        window.location.href = enlace.href;
    });

    return enlace;
}


// CARGA DE ARTICULOS DINAMICO


function aplicarFiltros(pagina) {
    let categorias = Array.from(document.querySelectorAll('input[name="categoria"]:checked')).map(checkbox => checkbox.value);
    let marcas = Array.from(document.querySelectorAll('input[name="marca"]:checked')).map(checkbox => checkbox.value);
    let sexo = Array.from(document.querySelectorAll('input[name="sexo"]:checked')).map(checkbox => checkbox.value);
    let nombre = document.querySelector("#search-input").value.split(' ');
    console.log(pagina);

    let articulos = cargarArticulosDinamico(categorias, marcas, sexo, nombre, pagina);

    articulos.then(data => {
        articulosContainer.innerHTML = '';

        data.articulos.forEach(articulo => {
            let articuloNodo = crearArticuloHTML(articulo);
            articulosContainer.appendChild(articuloNodo);
        });

        actualizarBotonesPagina(data.totalPaginas);
    });
}


const nombreInput = document.querySelector("#search-input");
nombreInput.removeEventListener("input", searchArticulos);
nombreInput.addEventListener('input', function(){
    aplicarFiltros(1);
});

document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function(){
        aplicarFiltros(1);
    });
});

// CARGA DE ARTICULOS GET

let articulos = cargarArticulosGET();

articulos.then(data => {
    articulosContainer.innerHTML = '';

    data.articulos.forEach(articulo => {
        let articuloNodo = crearArticuloHTML(articulo);
        articulosContainer.appendChild(articuloNodo);
    });

    actualizarBotonesPagina(data.totalPaginas);
});

// BOTONES PARA LA PAGINA

const paginaContainer = document.querySelector("#pagina-container");

function crearBotonPagina(numero) {
    let boton = document.createElement('p');
    boton.classList.add('boton-pagina');
    boton.textContent = numero;
    boton.dataset.pagina = numero;

    boton.addEventListener('click', function () {
        let pagina = parseInt(boton.dataset.pagina, 10);
        aplicarFiltros(pagina);
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    return boton;
}

function actualizarBotonesPagina(totalPaginas) {
    paginaContainer.innerHTML = '';

    for (let i = 1; i <= totalPaginas; i++) {
        let boton = crearBotonPagina(i);
        paginaContainer.appendChild(boton);
    }
}
