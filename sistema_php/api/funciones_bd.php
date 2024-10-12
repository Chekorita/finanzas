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
        $consulta_usuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $nombre_usuario = isset($_POST['usuario']) ? limpiar_cadena($_POST['usuario']) : null;
        $dato = [
            "tipo" => (int)1,
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
            ];
        }
        return $respuesta;
    }
?>