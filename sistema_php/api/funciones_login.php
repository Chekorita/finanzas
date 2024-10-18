<?php
    include '../config/crypto.php';
    require '../config/database.php';
    $respuesta = new stdClass();
    $funcion = (isset($_POST['funcion'])) ? $_POST['funcion'] : null;
    $parametros = (isset($_POST['parametros'])) ? $_POST['parametros'] : null;
    if(!is_null($parametros)){
        $parametros = json_decode($parametros);
    }

    if($funcion === null){
        $respuesta->estado = 3;
        $respuesta->mensaje = "NO SE ASIGNÓ NINGUNA FUNCIÓN.";
        echo json_encode($respuesta);
    }

    switch ($funcion):
        case "iniciar_sesion":
            echo json_encode(iniciar_sesion($parametros));
        break;
        default:
            $respuesta->estado = 3;
            $respuesta->mensaje = "NO SE ASIGNÓ NINGUNA FUNCIÓN.";
            echo json_encode($respuesta);
        break;
    endswitch;

    function iniciar_sesion(object | bool $parametros): object | bool{
        global $palabra_sitio;
        $respuesta = new stdClass();
        if(is_null($parametros)){
            $respuesta->estado = 2;
            $respuesta->mensaje = "DATOS VACÍOS O INCORRECTOS.";
            return $respuesta;
        }
        if((!is_null($parametros->usuario) && !is_null($parametros->contrasena)) && (isset($parametros->usuario) && isset($parametros->contrasena))){
            $data = [];
            $dato = new stdClass();
            $dato = [
                'tipo' => (int)4,
                'valor' => (string)$parametros->usuario,
                'nombre' => (string)':usuario',
            ];
            array_push($data, $dato);
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario and estado = 1;";
            $usuario = realizar_consulta($sql, $data);
            if(!$usuario){
                $respuesta->estado = 2;
                $respuesta->mensaje = "USUARIO NO EXISTENTE O NO ENCONTRADO.";
                return $respuesta;
            }
            if(!is_object($usuario) || is_null($usuario)){
                $respuesta->estado = 2;
                $respuesta->mensaje = "DATOS DE ACCESO NO ENCONTRADOS.";
                return $respuesta;
            }
            $contrasena_temp = "{$parametros->contrasena}{$palabra_sitio}{$usuario->random}";
            $contrasena_hash = hash('sha256', $contrasena_temp);
            $usuario->nombre_completo = "{$usuario->nombre} {$usuario->paterno} {$usuario->materno}";
            if($contrasena_hash === $usuario->acceso){
                session_name('Finanzas');
                session_start();
                $_SESSION['tiempo_logueo'] = time();
                $_SESSION['sesion_iniciada'] = "sesion_iniciada";
                $_SESSION['user'] = Crypto::encriptacion($usuario->id_usuario);
                $_SESSION['nombre_usuario'] = $usuario->nombre_completo;
                $respuesta->estado = 1;
                $respuesta->mensaje = "SESIÓN INICIADA CORRECTAMENTE.";
                return $respuesta;
            }else{
                $respuesta->estado = 2;
                $respuesta->mensaje = "CONTRASEÑA INCORRECTA.";
                return $respuesta;
            }
        }
    }
?>