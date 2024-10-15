<?php
    include "../config/database.php";
    include "./funciones_generales.php";
    include "../config/crypto.php";

    session_name("Finanzas");
    session_start();

    $funcion = isset($_POST['funcion']) ? $_POST['funcion'] : null;

    if(is_null($funcion)){
        $respuesta = [
            "estado" => 3,
            "mensaje" => "No se ha recibido la función a ejecutar",
        ];
        echo json_encode($respuesta);
    }else{
        switch($funcion){
            case 'verificar_usuario':
                echo json_encode(verificar_usuario());
            break;
            case 'guardar_usuario':
                echo json_encode(guardar_usuario());
            break;
            default:
                $respuesta = [
                    "estado" => 3,
                    "mensaje" => "Función no encontrada",
                ];
                echo json_encode($respuesta);
            break;
        }
    }

    function verificar_usuario(){
        $data_consulta = [];
        $consulta_usuario = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
        $nombre_usuario = isset($_POST['usuario']) ? limpiar_cadena($_POST['usuario']) : null;
        $dato = [
            "tipo" => (int)4,
            "valor" => (string)$nombre_usuario,
            "nombre" => (string)":usuario",
        ];
        array_push($data_consulta, $dato);
        $respuesta_consulta = realizar_consulta($consulta_usuario, $data_consulta);
        if(!$respuesta_consulta){
            $respuesta = [
                "estado" => 1,
                "mensaje" => "Nombre de usuario disponible",
                "datos" => $respuesta_consulta,
            ];
        }else{
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Nombre de usuario no disponible",
                "datos" => $respuesta_consulta,
            ];
        }
        return $respuesta;
    }

    function guardar_usuario(){
        global $conPDO;
        global $palabra_sitio;
        $parametros = isset($_POST['parametros']) ? $_POST['parametros'] : null;
        if(is_null($parametros)){
            $respuesta = [
                "estado" =>  2,
                "mensaje" => "Error al recibir los datos del usuario",
            ];
            return $respuesta;
        }
        $parametros = (object)json_decode($parametros);
        $usuario = limpiar_cadena($parametros->usuario);
        $random = obtener_string_random(30);
        $cadena_encriptacion = "{$parametros->contrasena}{$palabra_sitio}{$random}";
        $acceso = obtener_string_hash($cadena_encriptacion);
        $paterno = $parametros->paterno ? limpiar_cadena($parametros->paterno, "Con") : "";
        $materno = $parametros->materno ? limpiar_cadena($parametros->materno, "Con") : "";
        $nombre = $parametros->nombre ? limpiar_cadena($parametros->nombre, "Con") : "";
        $ingreso_mensual = $parametros->ingreso_mensual ? $parametros->ingreso_mensual : 0;

        $consulta_insert = "INSERT INTO usuarios (usuario, acceso, random, paterno, materno, nombre, ingreso_mensual) 
            VALUES (:usuario, :acceso, :random, :paterno, :materno, :nombre, :ingreso_mensual)";
        try{
            $conPDO->beginTransaction();
            $registro_consulta = $conPDO->prepare($consulta_insert);
            $registro_consulta->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $registro_consulta->bindParam(":acceso", $acceso, PDO::PARAM_STR);
            $registro_consulta->bindParam(":random", $random, PDO::PARAM_STR);
            $registro_consulta->bindParam(":paterno", $paterno, PDO::PARAM_STR);
            $registro_consulta->bindParam(":materno", $materno, PDO::PARAM_STR);
            $registro_consulta->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $registro_consulta->bindParam(":ingreso_mensual", $ingreso_mensual, PDO::PARAM_STR);
            if($registro_consulta->execute()){
                $conPDO->commit();
                $respuesta = [
                    "estado" =>  1,
                    "mensaje" => "Usuario guardado correctamente",
                ];
                return $respuesta;
            }else{
                $conPDO->rollBack();
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al guardar el usuario",
                ];
                return $respuesta;
            }
        }catch(Exception $e){
            $conPDO->rollBack();
            $respuesta = [
                "estado" =>  2,
                "mensaje" => "Error al guardar el usuario",
            ];
            return $respuesta;
        }
    }
?>