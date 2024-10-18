document.addEventListener("DOMContentLoaded", () => {
    var contenedor_bloqueo = document.getElementById("contenedor-bloquea");
    var contenedor_alertas = document.getElementById("contenedor-alertas");
    contenedor_alertas.innerHTML = "";
    contenedor_alertas.innerHTML += generar_alerta_bootstrap_sin_titulo("warning", "Los campos con * son obligatorios");
    contenedor_bloqueo.classList.remove("cargando");
    contenedor_bloqueo.classList.add("cargando_oculto");
});

//un addventlistener que detecta cuando ya no se esta escribiendo en el input
document.addEventListener("focusout", function(e){
    const evt_nombre = e.target.closest("#nombre_categoria_ingreso");
    if(evt_nombre){
        evt_nombre.value = limpiar_cadena_parcial(evt_nombre.value);
    }
});

function validar_actualizacion(id){
    if(valida_datos_categoria()){
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se actualizarán los datos de la categoría de ingresos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                actualizar_categoria(id);
            }
        });
    }
}

function validar_insercion(){
    if(valida_datos_categoria()){
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se insertará una nueva categoría de ingresos",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                insertar_categoria();
            }
        });
    }
}

function valida_datos_categoria(){
    let campos = [];
    let input_nombre = document.querySelector("#nombre_categoria_ingreso");
    let valor_nombre = input_nombre.value ? limpiar_cadena_parcial(input_nombre.value) : "";
    input_nombre.value = valor_nombre;
    var campo = {
        valor: valor_nombre,
        contenedor: "#nombre_categoria_ingreso",
        ayuda: "#ayuda_nombre_ingreso",
        valido: (valor_nombre.length > 0 && valor_nombre !== "") ? true : false,
        mensaje: "Debe ingresar el nombre del ingreso"
    };
    campos.push(campo);
    let validos = true;
    campos.forEach(function(campo){
		if(!campo.valido){
			if(campo.contenedor !== ""){
				let contenedor = document.querySelector(campo.contenedor);
				let ayuda = document.querySelector(campo.ayuda);
				contenedor.classList.add('error');
				contenedor.classList.remove('exito');
				$(campo.contenedor).fadeIn('slow');
				ayuda.classList.add('text-danger');
				ayuda.classList.remove('text-success');
				ayuda.innerHTML = campo.mensaje;
				$(campo.ayuda).fadeIn('slow');
				validos = false;
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

async function insertar_categoria(){
    let contenedor_status = document.getElementById("contenedor-status");
    var contenedor_bloqueo = document.getElementById("contenedor-bloquea");
    let valor_nombre = document.getElementById("nombre_categoria_ingreso").value;
    let valor_tipo = document.getElementById("sel_tipo_ingreso").value;
    let valor_requiere_persona = document.getElementById("sel_requiere_persona").value;
    let url = "./api/funciones_bd.php";
    let datos = new FormData();
    let parametros = {
        nombre: valor_nombre,
        tipo: valor_tipo,
        requiere_persona: valor_requiere_persona,
    };
    datos.append("funcion", "guardar_categoria_ingreso");
    datos.append("parametros", JSON.stringify(parametros));
    contenedor_status.innerHTML = getAnimacionCarga("Insertando categoria de ingreso...","secondary");
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
                    text: "Categoria registrada correctamente",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.href = "./vista_categorias.php";
                    }
                    if(result.isDismissed){
                        window.location.href = "./vista_categorias.php";
                    }
                    if(result.isDenied){
                        window.location.href = "./vista_categorias.php";
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

async function actualizar_categoria(id){
    let contenedor_status = document.getElementById("contenedor-status");
    var contenedor_bloqueo = document.getElementById("contenedor-bloquea");
    let valor_nombre = document.getElementById("nombre_categoria_ingreso").value;
    let valor_tipo = document.getElementById("sel_tipo_ingreso").value;
    let valor_requiere_persona = document.getElementById("sel_requiere_persona").value;
    let url = "./api/funciones_bd.php";
    let datos = new FormData();
    let parametros = {
        id: id,
        nombre: valor_nombre,
        tipo: valor_tipo,
        requiere_persona: valor_requiere_persona,
    };
    datos.append("funcion", "actualizar_categoria_ingreso");
    datos.append("parametros", JSON.stringify(parametros));
    contenedor_status.innerHTML = getAnimacionCarga("Actualizando categoria de ingreso...","secondary");
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
                    text: "Categoria actualizada correctamente",
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if(result.isConfirmed){
                        window.location.href = "./vista_categorias.php";
                    }
                    if(result.isDismissed){
                        window.location.href = "./vista_categorias.php";
                    }
                    if(result.isDenied){
                        window.location.href = "./vista_categorias.php";
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