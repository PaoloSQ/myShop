import {
    agregarEventos,
    verificacionMail,
    verificacionContrasena
} from './validaciones.js';

// declaracion de input

const correoInput = document.querySelector("#correo_input");
const contrasenaInput = document.querySelector("#contrasena_input");
const botonSubmitLogin = document.querySelector("#boton-submit_login");

//verificaciones contiene los estatus y errores de los inputs

let verificaciones = {

    "correoVerf": [ false, "Correo inválido."],
    "constrasenaVerf": [ false, "Usa 8 digitos mínimo, una mayúscula y un caracter especial"],    
}


agregarEventos(correoInput, verificaciones.correoVerf, verificacionMail);
agregarEventos(contrasenaInput, verificaciones.constrasenaVerf, verificacionContrasena);


// HABILITAR BOTON SUBMIT

correoInput.addEventListener("input", function () {
    botonSubmit();
});

contrasenaInput.addEventListener("input", function () { 
    botonSubmit();
});

function botonSubmit() {
    if (verificaciones.correoVerf[0] && verificaciones.constrasenaVerf[0]) {
        botonSubmitLogin.classList.add("boton_habilitado");
    } else {
        botonSubmitLogin.classList.remove("boton_habilitado");
    }
}


// ENVIAR DATOS LOGIN A API_Conection

botonSubmitLogin.addEventListener("click", function(event){

    event.preventDefault();

    if(botonSubmitLogin.classList.contains("boton_habilitado")){
        if (verificaciones.correoVerf[0] && verificaciones.constrasenaVerf[0]){
        
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
                loginUsuario(correoInput.value, contrasenaInput.value);
            }
            
        }else{
            mensajeSweetAlert("Introduzca un correo y/o contraseña validos", "error");
        }
    }
})
