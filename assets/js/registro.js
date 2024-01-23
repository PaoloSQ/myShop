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


// declaracion de input

const nombreInput = document.querySelector("#nombre_input");
const apellidoInput = document.querySelector("#apellido_input");
const provinciaInput = document.querySelector("#provincia-select");
const ciudadInput = document.querySelector("#ciudad-select");
const direccionInput = document.querySelector("#direccion_input");
const codigoPostalInput = document.querySelector("#codigoPostal_input");
const telefonoInput = document.querySelector("#telefono_input");
const correoInput = document.querySelector("#correo_input");
const contrasenaInput = document.querySelector("#contrasena_input");
const contrasenaReptInput = document.querySelector("#contrasena_rpt");
const terminosCheck = document.querySelector("#terminos");
const botonSubmitRegistro = document.querySelector("#boton-submit_registro");

const provinciaSelect = document.querySelector('#provincia-select');
const ciudadSelect = document.querySelector('#ciudad-select');
cargarProvincias(provinciaSelect);
cargarCiudades(provinciaSelect, ciudadSelect);

// verificaciones contiene los estatus y errores de los input
let verificaciones = {

    "nombreVerf": [ false , "Nombre inválido." ],

    "apellidoVerf": [ false, "Apellido inválido."],

    "provinciaVerf": [ false, "Provincia inválida."],

    "ciudadVerf": [ false, "Ciudad inválida."],

    "direccionVerf": [ false, "Dirección inválida."],

    "codigoPostalVerf": [ false, "Código postal inválido."],

    "telefonoVerf": [ false, "Teléfono inválido."],
    
    "correoVerf": [ false, "Correo inválido."],
    
    "constrasenaVerf": [ false, "Usa 8 digitos mínimo, una mayúscula y un caracter especial"],
    
    "constrasenaReptVerf": [ false, "Las contraseñas no coinciden."]
}



agregarEventos(nombreInput, verificaciones.nombreVerf, verificacionTexto);
agregarEventos(apellidoInput, verificaciones.apellidoVerf, verificacionTexto);
agregarEventosSelect(provinciaInput, verificaciones.provinciaVerf, "Seleccionar Provincia");
agregarEventosSelect(ciudadInput, verificaciones.ciudadVerf, "Seleccionar Ciudad");
agregarEventos(direccionInput, verificaciones.direccionVerf, verificacionDireccion);
agregarEventos(codigoPostalInput, verificaciones.codigoPostalVerf, verificacionCodigoPostal);
agregarEventos(telefonoInput, verificaciones.telefonoVerf, verificacionTelefono);
agregarEventos(correoInput, verificaciones.correoVerf, verificacionMail);
agregarEventos(contrasenaInput, verificaciones.constrasenaVerf, verificacionContrasena);
agregarEventos(contrasenaReptInput, verificaciones.constrasenaReptVerf, verificacionRPTContrasena);

contrasenaInput.addEventListener("input",function(){
    let mensajeError = new errorMensajes(contrasenaReptInput, verificaciones.constrasenaReptVerf, verificacionRPTContrasena);
    mensajeError.errores();
})


// TERMINOS ACEPTADOS

terminosCheck.addEventListener("change", function(){
    botonSubmitRegistro.classList.toggle("boton_habilitado");
})

// ENVIAR DATOS REGISTRO A API_Conection

botonSubmitRegistro.addEventListener("click", function(event){
    event.preventDefault();
    
    if(terminosCheck.checked){
        
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
            registrarUsuario(nombreInput.value, apellidoInput.value, provinciaInput.value, ciudadInput.value, direccionInput.value, codigoPostalInput.value, telefonoInput.value, correoInput.value, contrasenaInput.value);
        }
    }else{
        mensajeSweetAlert("Acepta los terminos y condiciones", "error");
    }
})

