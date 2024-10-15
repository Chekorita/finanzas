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
            validar_usuario = false;
            revisar_boton_guardar();
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
    let input_usuario = document.querySelector("#usuario");
    let input_contrasena = document.querySelector("#contrasena");
    let input_confirmar_contrasena = document.querySelector("#confirmar_contrasena");
    let valor_nombre = input_nombre.value ? input_nombre.value : "";
    let valor_apellido_paterno = input_apellido_paterno.value ? input_apellido_paterno.value : "";
    let valor_apellido_materno = input_apellido_materno.value ? input_apellido_materno.value : "";
    let valor_usuario = input_usuario.value ? input_usuario.value : "";
    let valor_contrasena = input_contrasena.value ? input_contrasena.value : "";
    let valor_confirmar_contrasena = input_confirmar_contrasena.value ? input_confirmar_contrasena.value : "";
    var campo = {
        valor: valor_nombre,
        contenedor: "#nombre",
        ayuda: "#ayuda-nombre",
        valido: (valor_nombre.length > 0 && valor_nombre !== "") ? true : false,
        mensaje: "Debe ingresar su nombre"
    };
    campos.push(campo);
    var campo = {
        valor: valor_apellido_paterno,
        contenedor: "#apellido_paterno",
        ayuda: "#ayuda-apellido-paterno",
        valido: (valor_apellido_paterno.length > 0 && valor_apellido_paterno !== "") || (valor_apellido_materno.length > 0 && valor_apellido_materno !== "") ? true : false,
        mensaje: "Debe ingresar su apellido al menos un apellido"
    };
    campos.push(campo);
    var campo = {
        valor: valor_apellido_materno,
        contenedor: "#apellido_materno",
        ayuda: "#ayuda-apellido-materno",
        valido: (valor_apellido_paterno.length > 0 && valor_apellido_paterno !== "") || (valor_apellido_materno.length > 0 && valor_apellido_materno !== "") ? true : false,
        mensaje: "Debe ingresar su apellido al menos un apellido"
    };
    campos.push(campo);
    var campo = {
        valor: valor_usuario,
        contenedor: "#usuario",
        ayuda: "#ayuda-usuario",
        valido: (valor_usuario.length > 0 && valor_usuario !== "") ? true : false,
        mensaje: "Debe ingresar un nombre de usuario válido"
    };
    campos.push(campo);
    var campo = {
        valor: valor_contrasena,
        contenedor: "#contrasena",
        ayuda: "#ayuda-contrasena",
        valido: (valor_contrasena.length > 0 && valor_contrasena !== "" && revisar_contrasena(valor_contrasena)) ? true : false,
        mensaje: "Debe ingresar una contraseña válida"
    };
    campos.push(campo);
    var campo = {
        valor: valor_confirmar_contrasena,
        contenedor: "#confirmar_contrasena",
        ayuda: "#ayuda-confirmar-contrasena",
        valido: (valor_confirmar_contrasena.length > 0 && valor_confirmar_contrasena !== "" && valor_confirmar_contrasena === valor_contrasena) ? true : false,
        mensaje: "Las contraseñas no coinciden"
    };
    campos.push(campo);
    let validos = true;
    campos.forEach(function(campo){
		if(!campo.valido){
			if(campo.contenedor !== ""){
				let contenedor = document.querySelector(campo.contenedor);
				let ayuda = document.querySelector(campo.ayuda);
				let boton = document.querySelector("button#btn-guardar");
				contenedor.classList.add('error');
				contenedor.classList.remove('exito');
				$(campo.contenedor).fadeIn('slow');
				ayuda.classList.add('text-danger');
				ayuda.classList.remove('text-success');
				ayuda.innerHTML = campo.mensaje;
				$(campo.ayuda).fadeIn('slow');
				validos = false;
				boton.disabled = true;
				setTimeout(function(){
					contenedor.classList.remove('error');
					$(campo.contenedor).slideDown('slow', function(){
						contenedor.classList.remove('error');
					});
					$(campo.ayuda).slideUp('slow', function(){
						ayuda.innerHTML = "";
						ayuda.classList.remove("text-danger");
						ayuda.classList.add("text-success");
					});
					$(campo.ayuda).slideUp('slow', function(){
						ayuda.innerHTML = "";
					});
					$(campo.ayuda).slideDown();
				},2500);
				setTimeout(function(){
					boton.disabled = false;
				}, 2500);
			}
		}else{
			if(campo.contenedor !== ""){
				let contenedor = document.querySelector(campo.contenedor);
				let ayuda = document.querySelector(campo.ayuda);
				$(campo.contenedor).fadeIn('slow', function(){
					contenedor.classList.add('exito');
					$(campo.contenedor).show();
				});
				setTimeout(function(){
					$(campo.contenedor).slideDown('slow', function(){
						ayuda.innerHTML = "";
						contenedor.classList.remove('exito');
						$(campo.contenedor).show();
					});
				},2500);
			}
		}
	});
    if(validos){
		return true;
	}else{
		obtener_toast("error", "DATOS NO VÁLIDOS O INCOMPLETOS", "REVISE LOS DATOS INGRESADOS Y CORREGIR LOS ERRORES");
        return false;
	}
}

async function guardar_usuario(){
    let contenedor_status = document.getElementById("contenedor-status");
    var contenedor_bloqueo = document.getElementById("contenedor-bloquea");
    let nombre = document.getElementById("nombre").value;
    let apellido_paterno = document.getElementById("apellido_paterno").value;
    let apellido_materno = document.getElementById("apellido_materno").value;
    let ingreso_mensual = document.getElementById("ingreso_mensual").value;
    let usuario = document.getElementById("usuario").value;
    let contrasena = document.getElementById("contrasena").value;
    let url = "./api/funciones_bd.php";
    let datos = new FormData();
    let parametros = {
        nombre: nombre,
        paterno: apellido_paterno,
        materno: apellido_materno,
        ingreso_mensual: ingreso_mensual,
        usuario: usuario,
        contrasena: contrasena
    };
    datos.append("funcion", "guardar_usuario");
    datos.append("parametros", JSON.stringify(parametros));
    contenedor_status.innerHTML = getAnimacionCarga("Cambiando la contraseña...","secondary");
    contenedor_bloqueo.classList.remove("cargando_oculto");
    contenedor_bloqueo.classList.add("cargando");
    fetch(url, {
        method: "POST",
        body: datos
    }).then(respuesta => respuesta.json())
    .then((respuesta) => {
        switch(respuesta.estado){
            case 1:
                contenedor_bloqueo.classList.remove("cargando");
                contenedor_bloqueo.classList.add("cargando_oculto");
                contenedor_status.innerHTML = "";
                Swal.fire({
                    title: '¡Éxito!',
                    text: "Usuario registrado correctamente",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.href = "./index.php";
                    }
                    if(result.isDismissed){
                        window.location.href = "./index.php";
                    }
                    if(result.isDenied){
                        window.location.href = "./index.php";
                    }
                });
            break;
            case 2:
                contenedor_bloqueo.classList.remove("cargando");
                contenedor_bloqueo.classList.add("cargando_oculto");
                contenedor_status.innerHTML = "";
                obtener_toast(tipo = "error", titulo = "ERROR", mensaje = respuesta.mensaje);
            break;
            default:
                contenedor_bloqueo.classList.remove("cargando");
                contenedor_bloqueo.classList.add("cargando_oculto");
                contenedor_status.innerHTML = "";
                obtener_toast(tipo = "error", titulo = "ERROR", mensaje = "No se pudo conectar con el servidor");
            break;
        }
    })
    .catch((error) => {
        contenedor_bloqueo.classList.remove("cargando");
        contenedor_bloqueo.classList.add("cargando_oculto");
        contenedor_status.innerHTML = "";
        obtener_toast(tipo = "error", titulo = "ERROR", mensaje = "No se pudo conectar con el servidor, favor de intentarlo más tarde");
    });
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