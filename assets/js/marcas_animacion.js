const marcascontainer = document.querySelector(".marcas-container");
let imagenes = marcascontainer.querySelectorAll("img");
let index = 1;

function actualizarIntervalo() {
    let porcentaje = (index * -1.3);

    if (window.innerWidth > 500) {
        if (porcentaje < -3150) index = 1;
    } else {
        if (porcentaje < -2450) index = 1;
    }

    marcascontainer.style.transform = "translateX(" + porcentaje + "px)";
    index++;
}

setInterval(actualizarIntervalo, 0.001);
window.addEventListener("resize", actualizarIntervalo);
