document.addEventListener('keydown', function(event) {
    if(event.key === "Enter"){
        iniciar_sesion();
    }
});

async function iniciar_sesion(){
    let usuario = document.getElementById("username").value;
    let contrasena = document.getElementById("password").value;
    if(usuario === "" || contrasena === ""){
        obtener_toast("warning", "Campos incompletos", "Debes llenar todos los campos");
        return;
    }else{
        let contenedor_status = document.getElementById("contenedor-status");
        let url = "./functions/funciones_login.php";
        let datos = new FormData();
        parametros = {
            "usuario": usuario,
            "contrasena": contrasena
        };
        datos.append("funcion", "iniciar_sesion");
        datos.append("parametros", JSON.stringify(parametros));
        contenedor_status.innerHTML = getAnimacionCarga("Iniciando sesión...","secondary");
        fetch(url, {
            method: 'POST',
            body: datos
        })
        .then( res => res.json())
        .then((respuesta) => {
            switch(respuesta.estado){
                case 1:
                    obtener_toast(tipo = "success", titulo = "Éxito", mensaje = "Sesión iniciada correctamente");
                    postAndRedirect("./vista_menu_opciones.php", {});
                break;
                case 2:
                    contenedor_status.innerHTML = "";
                    obtener_toast(tipo = "error", titulo = "ERROR", mensaje = respuesta.mensaje);
                break;
                default:
                    contenedor_status.innerHTML = "";
                    obtener_toast(tipo = "error", titulo = "ERROR INTERNO", mensaje = respuesta.mensaje);
                break;
            }
        })
        .catch((error) => {
            contenedor_status.innerHTML = "";
            obtener_toast(tipo = "error", titulo = "ERROR INTERNO", mensaje = error);
        });
    }
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