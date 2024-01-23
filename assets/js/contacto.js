import {
    agregarEventos,
    verificacionTexto,
    verificacionMail
} from './validaciones.js';

// Declaración de inputs

const nombreInput = document.querySelector("#nombre_input");
const correoInput = document.querySelector("#correo_input");
const asuntoInput = document.querySelector("#asunto_input");
const mensajeInput = document.querySelector("#mensaje_input");
const enviarCorreoBoton = document.querySelector("#enviar_correo-boton");

// Verificaciones de los estatus input
let verificaciones = {
    "nombreVerf": [false, "Nombre inválido."],
    "correoVerf": [false, "Correo inválido."],
}

// Agregar eventos a los inputs
agregarEventos(nombreInput, verificaciones.nombreVerf, verificacionTexto);
agregarEventos(correoInput, verificaciones.correoVerf, verificacionMail);

// Enviar email boton
enviarCorreoBoton.addEventListener("click", async function (event) {
    event.preventDefault();

    let detenerCodigo = false;

    for (const key in verificaciones) {
        if (verificaciones.hasOwnProperty(key)) {
            const valor = verificaciones[key][0];

            if (!valor) {
                detenerCodigo = true;
                mensajeSweetAlert(verificaciones[key][1], "error");
                break;
            }
        }
    }

    if (!detenerCodigo) {
        try {
            await enviarCorreo(nombreInput.value, correoInput.value, asuntoInput.value, mensajeInput.value);
            document.querySelector("#formulario-email").reset();
        } catch (error) {
            console.error("Error al enviar el correo:", error);
        }
    }
});


// REDIRECCION ICONOS

const linkedinIco = document.querySelector(".linkedin_ico");
linkedinIco.addEventListener("click", function () {
    window.open("https://www.linkedin.com/in/tu_linkedin_perfil/", "_blank");
});

const githubIco = document.querySelector(".github_ico");
githubIco.addEventListener("click", function () {
    window.open("https://github.com/PaoloSQ", "_blank");
});

const portfolioIco = document.querySelector(".portfolio_ico");
portfolioIco.addEventListener("click", function () {
    window.open("http://yoursearch.es", "_blank");
});

// Teléfono
const telefonoIco = document.querySelector(".redes_sociales-container .fa-phone");
telefonoIco.parentElement.addEventListener("click", function () {
    window.open("tel:+34624040225", "_blank");
});
