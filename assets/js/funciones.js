const boton_menu = document.querySelector(".menu_icon-container");
const menuContainer = document.querySelector(".menu-container");
const sombra = document.querySelector("#sombra");
const boton_menu_cerrar = document.querySelector("#boton_cerrar-menu");
const menuWidth = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--widthMenu'));

boton_menu.addEventListener("click", function(){
    sombra.style.display = "initial";
    menuContainer.style.left = 0;
});

boton_menu_cerrar.addEventListener("click", function(){
    sombra.style.display = "none";
    menuContainer.style.left = menuContainer.style.left === '0px' ? `-${menuWidth*25}px` : '0px';
});

sombra.addEventListener("click", function(){
    sombra.style.display = "none";
    menuContainer.style.left = menuContainer.style.left === '0px' ? `-${menuWidth*25}px` : '0px';
})



// REDIRECCION BOTONES

const login_ico = document.querySelector(".login_icon-container");
login_ico.addEventListener("click", function(){
    window.location.href = "login.php";
});

const carrito_ico = document.querySelector(".shopping_ico-container");
carrito_ico.addEventListener("click", function(){
    window.location.href = "carrito.php";
});

const contacto_ico = document.querySelector(".contact_ico-container");
contacto_ico.addEventListener("click", function(){
    window.location.href = "contacto.php"
});



// MENSAJES EMERGENTES
    
function mensajeSweetAlert(mensaje, tipo) {
    if (tipo === 'informativo') {
        Swal.fire('Informativo', mensaje, 'info');
    } else if (tipo === 'error') {
        Swal.fire('Error', mensaje, 'error');
    } else if (tipo === 'exitoso') {
        Swal.fire('Éxito', mensaje, 'success');
    } else {
        console.error('Tipo de mensaje no reconocido');
    }
};


// BUSCADOR 

function crearArticuloHTML(articulo) {
    let enlace = document.createElement('a');
    enlace.href = 'producto.php?id_producto=' + articulo.id_producto;

    let articuloDiv = document.createElement('div');
    articuloDiv.classList.add('articulo');
    articuloDiv.id = articulo.id_producto;

    let imagen = document.createElement('img');
    imagen.src = articulo.imagenURL_producto;
    imagen.alt = articulo.nombre_producto;

    let nombre = document.createElement('p');
    nombre.textContent = articulo.nombre_producto;

    let precio = document.createElement('p');
    precio.textContent = articulo.precio_producto + "€";

    articuloDiv.appendChild(imagen);
    articuloDiv.appendChild(nombre);
    articuloDiv.appendChild(precio);
    enlace.appendChild(articuloDiv);

    enlace.addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = enlace.href;
    });

    return enlace;
}

const buscadorInput = document.querySelector("#search-input");
const resultadoBuscadorContainer = document.querySelector("#search_resultado-container");
const buscadorContainerAbsolute = document.querySelector(".search_resultado-container-absolute");

let articulosSearch = null;

function displayResultado(){
    if(resultadoBuscadorContainer.innerHTML == '' || buscadorInput.value.trim().length == 0){
        buscadorContainerAbsolute.style.display = 'none';
    }else{
        buscadorContainerAbsolute.style.display = 'block';
    }
}

buscadorInput.addEventListener("blur", function(){
    setTimeout(function() {
        buscadorContainerAbsolute.style.display = 'none';
    }, 100);
})

function searchArticulos(){
    let nombre = Array.from([buscadorInput.value]).map(valor => valor);
    articulosSearch = cargarArticulosDinamico([], [], [], nombre);

    articulosSearch.then(data => {
        resultadoBuscadorContainer.innerHTML = '';
    
        data.articulos.forEach(articulo => {
            let articuloNodo = crearArticuloHTML(articulo);
            resultadoBuscadorContainer.appendChild(articuloNodo);
        });
    })
    .catch(error=>{
        console.error('Error al cargar los artículos:', error);
        articulosSearch = null;
    })

    displayResultado();
}

document.addEventListener("DOMContentLoaded", displayResultado);
buscadorInput.addEventListener("input", searchArticulos);


