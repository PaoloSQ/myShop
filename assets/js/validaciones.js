// errorMensajes controla los mensajes de error
class errorMensajes{

    constructor(input, Verf, error){
        this.input = input;
        this.Verf = Verf;
        this.error = error;
    }

    errores(){

        let errorHTML = document.createElement("p");
        errorHTML.appendChild(document.createTextNode(this.Verf[1]));
        errorHTML.classList.add("P-error");
    
        let existeError = this.input.parentNode.querySelector(".P-error");
    
        if(!this.error){
            this.Verf[0] = true;
            if(existeError){
                this.input.parentNode.removeChild(existeError);
            }
        } 
        else{
            this.Verf[0] = false;
            if(!existeError){
                this.input.insertAdjacentElement('afterend', errorHTML);
            }
        }
    }
}

// Verificacion de caracteres

const verificarPatron = (texto, patron) => !patron.test(texto);

const verificacionTexto = texto => texto.trim() !== '' && !verificarPatron(texto, /^[a-zA-Z\u00F1\u00D1 ]+$/) || !verificarPatron(texto, /^[a-zA-Z\u00F1\u00D1]+$/);
const verificacionDireccion = texto => texto.trim() !== '' && !verificarPatron(texto, /^[a-zA-Z0-9 ]+$/) || !verificarPatron(texto, /^[a-zA-Z0-9]+$/);
const verificacionMail = correo => correo.trim() !== '' && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo);
const verificacionCodigoPostal = codigoPostal => codigoPostal.trim() !== '' && !verificarPatron(codigoPostal, /^\d{5}$/);

function verificacionTelefono(telefono) {
    telefono = telefono.replace(/\s/g, '');
    if(telefono.trim() !== '' && (telefono.length == 9 || telefono.length == 12)){
        if(telefono.length == 9) telefono = "+34" + telefono;
        const regexTelefono = /^\+34\d{9}$|^\+34\d{12}$/;
        return regexTelefono.test(telefono);
    }
}


let contrasenaParameter = '';

function setContrasena(contrasena){
    contrasenaParameter = contrasena;
}

function verificacionContrasena(contrasena) {
    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;
    setContrasena(contrasena);
    return contrasena.trim() !== '' && pattern.test(contrasena);
}



function verificacionRPTContrasena(constrasenaRPT){
    return constrasenaRPT.trim() !== '' && constrasenaRPT === contrasenaParameter;
}

const verificacionPrecio = precio => {
    precio = parseFloat(precio.replace(",", ".")); // Reemplaza la coma por punto y convierte a número
    return !isNaN(precio) && precio >= 10.00 && precio <= 10000.00;
};

const verificacionExistencia = existencias => {
    const cantidad = parseInt(existencias);
    return !isNaN(cantidad) && cantidad >= 1 && cantidad <= 1000;
};

const verificacionVacio = valor => valor.trim() !== '';

// Agregar eventos a los inputs

function agregarEventos(input, verificacion, validadorFunc) {
    input.addEventListener("input", function () {
        const valor = input.value.trim();
        let mensajeError = new errorMensajes(input, verificacion, !validadorFunc(valor));
        mensajeError.errores();
    });
}

function agregarEventosSelect(input, verificacion, valorInvalido) {
    input.addEventListener("change", function (event) {
        const valor = event.target.value.trim();
        const error = valor === valorInvalido || valor === '';
        let mensajeError = new errorMensajes(input, verificacion, error);
        mensajeError.errores();
    });
}


export {
    errorMensajes,
    agregarEventos,
    agregarEventosSelect,
    verificacionTexto,
    verificacionDireccion,
    verificacionMail,
    verificacionContrasena,
    verificacionCodigoPostal,
    verificacionTelefono,
    setContrasena,
    verificacionRPTContrasena,
    verificacionExistencia,
    verificacionPrecio,
    verificacionVacio
};
