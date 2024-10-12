document.addEventListener("DOMContentLoaded", () => {
    var contenedor_bloqueo = document.getElementById("contenedor-bloquea");
    var contenedor_alertas = document.getElementById("contenedor-alertas");
    contenedor_alertas.innerHTML = "";
    contenedor_alertas.innerHTML += generar_alerta_bootstrap_sin_titulo("secondary", "Los campos marcados con * son obligatorios");
    contenedor_alertas.innerHTML += generar_alerta_bootstrap_sin_titulo("secondary", "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un caracter especial de los siguientes: @#$%^&+=-");
    contenedor_bloqueo.classList.remove("cargando");
    contenedor_bloqueo.classList.add("cargando_oculto");
});

//detectar eventos
document.addEventListener("keydown", function(event) {
    if(event.key === "Enter"){
        registrar_usuario();
    }
});

document.addEventListener("change", function(e){
    const evt_contrasena = e.target.closest("#contrasena");
    const evt_confirmar_contrasena = e.target.closest("#confirmar_contrasena");
    if(evt_contrasena){
        let contenedor_ayuda = document.getElementById("ayuda-contrasena");
        let contenedor_contrasena = document.getElementById("contrasena");
        evt_contrasena.value = limpiar_cadena(evt_contrasena.value);
        if(evt_contrasena.value.length > 0){
            if(evt_contrasena.value.length < 8){
                contenedor_ayuda.innerHTML = "<span class=\"text-danger\">LA CONTRASEÑA DEBE TENER AL MENOS 8 CARACTERES</span>";
                contenedor_contrasena.classList.remove("exito");
                contenedor_contrasena.classList.add("error");
                validar_contrasena = false;
                revisar_boton_guardar();
            }
            if(evt_contrasena.value.length >= 8){
                if(revisar_contrasena(evt_contrasena.value)){
                    contenedor_ayuda.innerHTML = "<span class=\"text-success\">CONTRASEÑA VÁLIDA</span>";
                    contenedor_contrasena.classList.remove("error");
                    contenedor_contrasena.classList.add("exito");
                    validar_contrasena = true;
                    revisar_boton_guardar();

                    //debemos revisar si hay algo escrito en el campo de confirmar contraseña, en caso de que si, debemos revisar si son iguales
                    let confirmar_contrasena = document.getElementById("confirmar_contrasena");
                    if(confirmar_contrasena.value.length > 0){
                        if(evt_contrasena.value === confirmar_contrasena.value){
                            let contenedor_confirmar_contrasena = document.getElementById("confirmar_contrasena");
                            let contenedor_ayuda_confirmar_contrasena = document.getElementById("ayuda-confirmar-contrasena");
                            contenedor_ayuda_confirmar_contrasena.innerHTML = "<span class=\"text-success\">CONTRASEÑAS COINCIDEN</span>";
                            contenedor_confirmar_contrasena.classList.remove("error");
                            contenedor_confirmar_contrasena.classList.add("exito");
                            validar_confirmar_contrasena = true;
                            revisar_boton_guardar();
                        }else{
                            let contenedor_confirmar_contrasena = document.getElementById("confirmar_contrasena");
                            let contenedor_ayuda_confirmar_contrasena = document.getElementById("ayuda-confirmar-contrasena");
                            contenedor_ayuda_confirmar_contrasena.innerHTML = "<span class=\"text-danger\">LAS CONTRASEÑAS NO COINCIDEN</span>";
                            contenedor_confirmar_contrasena.classList.remove("exito");
                            contenedor_confirmar_contrasena.classList.add("error");
                            validar_confirmar_contrasena = false;
                            revisar_boton_guardar();
                        }
                    }
                }else{
                    contenedor_ayuda.innerHTML = "<span class=\"text-danger\">LA CONTRASEÑA NO CUMPLE CON LOS REQUISITOS</span>";
                    contenedor_contrasena.classList.remove("exito");
                    contenedor_contrasena.classList.add("error");
                    validar_contrasena = false;
                    revisar_boton_guardar();
                }
            }
        }else{
            contenedor_ayuda.innerHTML = "<span class=\"text-danger\">LA CONTRASEÑA ES OBLIGATORIA</span>";
            contenedor_contrasena.classList.remove("exito");
            contenedor_contrasena.classList.add("error");
            validar_contrasena = false;
            revisar_boton_guardar();
        }
    }
    if(evt_confirmar_contrasena){
        let contenedor_confirmar_contrasena = document.getElementById("confirmar_contrasena");
        let contenedor_ayuda_confirmar_contrasena = document.getElementById("ayuda-confirmar-contrasena");
        evt_confirmar_contrasena.value = limpiar_cadena(evt_confirmar_contrasena.value);
        if(evt_confirmar_contrasena.value.length > 0){
            if(evt_confirmar_contrasena.value === document.getElementById("contrasena").value){
                contenedor_ayuda_confirmar_contrasena.innerHTML = "<span class=\"text-success\">CONTRASEÑAS COINCIDEN</span>";
                contenedor_confirmar_contrasena.classList.remove("error");
                contenedor_confirmar_contrasena.classList.add("exito");
                validar_confirmar_contrasena = true;
                revisar_boton_guardar();
            }else{
                contenedor_ayuda_confirmar_contrasena.innerHTML = "<span class=\"text-danger\">LAS CONTRASEÑAS NO COINCIDEN</span>";
                contenedor_confirmar_contrasena.classList.remove("exito");
                contenedor_confirmar_contrasena.classList.add("error");
                validar_confirmar_contrasena = false;
                revisar_boton_guardar();
            }
        }else{
            contenedor_ayuda_confirmar_contrasena.innerHTML = "<span class=\"text-danger\">CONFIRMAR CONTRASEÑA ES OBLIGATORIO</span>";
            contenedor_confirmar_contrasena.classList.remove("exito");
            contenedor_confirmar_contrasena.classList.add("error");
            validar_confirmar_contrasena = false;
            revisar_boton_guardar();
        }
    }
});

//un addventlistener que detecta cuando ya no se esta escribiendo en el input
document.addEventListener("focusout", function(e){
    const evt_nombre = e.target.closest("#nombre");
    const evt_apellido_paterno = e.target.closest("#apellido_paterno");
    const evt_apellido_materno = e.target.closest("#apellido_materno");
    const evt_usuario = e.target.closest("#usuario");
    if(evt_nombre){
        evt_nombre.value = limpiar_cadena_parcial(evt_nombre.value);
    }
    if(evt_apellido_paterno){
        evt_apellido_paterno.value = limpiar_cadena_parcial(evt_apellido_paterno.value);
    }
    if(evt_apellido_materno){
        evt_apellido_materno.value = limpiar_cadena_parcial(evt_apellido_materno.value);
    }
    if(evt_usuario){
        evt_usuario.value = limpiar_cadena(evt_usuario.value);
        if(evt_usuario.value.length > 0){
            revisar_usuario(evt_usuario.value);
        }else{
            let contenedor_ayuda = document.getElementById("ayuda-usuario");
            contenedor_ayuda.innerHTML = "<span class=\"text-danger\">EL USUARIO ES OBLIGATORIO</span>";
            evt_usuario.classList.remove("exito");
            evt_usuario.classList.add("error");
        }
    }
});

//verificaciones de los campos sin BD
function revisar_contrasena(contrasena){
    var contrasena_valida = new RegExp("^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=-]).*$");
    return contrasena_valida.test(contrasena);
}

//verificaciones de los campos con BD
async function revisar_usuario(usuario){
    let contenedor_usuario = document.getElementById("usuario");
    let contenedor_ayuda = document.getElementById("ayuda-usuario");
    let contenedor_status = document.getElementById("contenedor-status");
    contenedor_status.innerHTML = getAnimacionCarga("Verificando la disponibilidad del nombre de usuario...","secondary");
    let url = "./api/funciones_bd.php";
    let datos = new FormData();
    datos.append("funcion", "verificar_usuario");
    datos.append("usuario", usuario);
    fetch(url, {
        method: "POST",
        body: datos
    }).then(respuesta => respuesta.json())
    .then((respuesta) => {
        switch(respuesta.estado){
            case 1:
                contenedor_status.innerHTML = "";
                contenedor_ayuda.innerHTML = "<span class=\"text-success\">NOMBRE DE USUARIO DISPONIBLE</span>";
                contenedor_usuario.classList.remove("error");
                contenedor_usuario.classList.add("exito");
                validar_usuario = true;
                revisar_boton_guardar();
            break;
            case 2:
                contenedor_status.innerHTML = "";
                contenedor_ayuda.innerHTML = "<span class=\"text-danger\">"+respuesta.mensaje+"</span>";
                contenedor_usuario.classList.remove("exito");
                contenedor_usuario.classList.add("error");
                validar_usuario = false;
                revisar_boton_guardar();
            break;
            default:
                contenedor_status.innerHTML = "";
                obtener_toast(tipo = "error", titulo = "ERROR INTERNO", mensaje = respuesta.mensaje);
                validar_usuario = false;
                revisar_boton_guardar();
            break;
        }
    })
    .catch((error) => {
        contenedor_status.innerHTML = "";
        obtener_toast(tipo = "error", titulo = "ERROR", mensaje = "No se pudo conectar con el servidor");
        validar_usuario = false;
        revisar_boton_guardar();
    });
}

//funciones normales
function regresar_login(){
    window.location.href = "./index.php";
}

function abre_ojito(contenedor_contrasena, contenedor_icono){
    var x = document.getElementById(contenedor_contrasena);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    var icono = document.getElementById(contenedor_icono);
    icono.classList.remove("fa-eye-slash");
    icono.classList.add("fa-eye");
}

function cierra_ojito(contenedor_contrasena, contenedor_icono){
    var x = document.getElementById(contenedor_contrasena);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    var icono = document.getElementById(contenedor_icono);
    icono.classList.remove("fa-eye");
    icono.classList.add("fa-eye-slash");
}

//funciones de registro y verificación
function registrar_usuario(){
    if(verificar_datos()){
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se esta a punto de registrar su usuario, ¿Desea continuar?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if(result.isConfirmed){
                guardar_usuario();
            }
        });
    }
}

function verificar_datos(){
    let campos = [];
    let input_nombre = document.querySelector("#nombre");
    let input_apellido_paterno = document.querySelector("#apellido_paterno");
    let input_apellido_materno = document.querySelector("#apellido_materno");
    let input_ingreso_mensual = document.querySelector("#ingreso_mensual");
    let input_usuario = document.querySelector("#usuario");
    let input_contrasena = document.querySelector("#contrasena");
    let input_confirmar_contrasena = document.querySelector("#confirmar_contrasena");
}

let validar_usuario = false;
let validar_contrasena = false;
let validar_confirmar_contrasena = false;
function revisar_boton_guardar(){
    if(validar_usuario && validar_contrasena && validar_confirmar_contrasena){
        document.getElementById("btn-guardar").disabled = false;
    }else{
        document.getElementById("btn-guardar").disabled = true;
    }
}