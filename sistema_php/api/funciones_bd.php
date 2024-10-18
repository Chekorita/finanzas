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
            case 'obtener_categoria_ingresos':
                echo json_encode(array("data" => obtener_categoria_ingresos()));
            break;
            case 'guardar_categoria_ingreso':
                echo json_encode(guardar_categoria_ingreso());
            break;
            case 'actualizar_categoria_ingreso':
                echo json_encode(actualizar_categoria_ingreso());
            break;
            case 'obtener_categoria_gastos':
                echo json_encode(array("data" => obtener_categoria_gastos()));
            break;
            case 'guardar_categoria_gasto':
                echo json_encode(guardar_categoria_gasto());
            break;
            case 'actualizar_categoria_gasto':
                echo json_encode(actualizar_categoria_gasto());
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
        try{
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
            }catch(PDOException $e){
                $conPDO->rollBack();
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al guardar el usuario",
                ];
                return $respuesta;
            }
        }catch(Exception $e){
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Error al guardar el usuario, existio un error durante el proceso de guardado",
            ];
            return $respuesta;
        }
    }

    function obtener_categoria_ingresos(){
        $data = [];
        $dato = new stdClass();
        $dato = [
            'tipo' => (int)1,
            'valor' => (int)Crypto::desencriptacion($_SESSION["user"]),
            'nombre' => (string)':usuario',
        ];
        array_push($data, $dato);
        $consultar_cat_ingresos = "SELECT * FROM tipos_ingresos WHERE id_usuario = :usuario";
        $resultados_ingresos = realizar_consulta_array($consultar_cat_ingresos, $data);
        if(!$resultados_ingresos){
            return false;
        }else{
            $arreglo_cat_ingresos = [];
            foreach($resultados_ingresos as $ingreso){
                $ingreso = (object)$ingreso;
                $ingreso->tipo = match($ingreso->tipo){
                    1 => "A DISPOSICIÓN",
                    2 => "CREDITO",
                    default => "No definido",
                };
                $ingreso->requiere_persona = match($ingreso->requiere_persona){
                    1 => "SI",
                    2 => "NO",
                    default => "No definido",
                };
                $ingreso->id_tipo_ingreso = Crypto::encriptacion($ingreso->id_tipo_ingreso);
                $datos_tipo = [
                    "no" => "",
                    "nombre" => $ingreso->nombre,
                    "tipo" => $ingreso->tipo,
                    "requiere_persona" => $ingreso->requiere_persona,
                    "editar" => "<a title='EDITAR REGISTRO' name=\"btn_editar_tipo_ingreso_{$ingreso->id_tipo_ingreso}\" id=\"btnEditar_{$ingreso->id_tipo_ingreso}\" href=\"#\" class = \"btn btn-secondary form-control\" onclick = \"javascript:editar_tipo_ingreso('{$ingreso->id_tipo_ingreso}')\"><i class=\"fa-solid fa-pencil\"></i></a>",
                ];
                array_push($arreglo_cat_ingresos, $datos_tipo);
            }
            return $arreglo_cat_ingresos;
        }
    }

    function guardar_categoria_ingreso(){
        try{
            global $conPDO;
            $parametros = isset($_POST['parametros']) ? $_POST['parametros'] : null;
            if(is_null($parametros)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }
            $parametros = (object)json_decode($parametros);
            $nombre_categoria_ingreso = isset($parametros->nombre) ? limpiar_cadena($parametros->nombre) : null;
            $tipo_categoria_ingreso = isset($parametros->tipo) ? $parametros->tipo : null;
            $requiere_persona = isset($parametros->requiere_persona) ? $parametros->requiere_persona : null;
            $usuario = Crypto::desencriptacion($_SESSION["user"]);
            $consulta_insert = "INSERT INTO tipos_ingresos (id_usuario, nombre, tipo, requiere_persona) 
                VALUES (:id_usuario, :nombre, :tipo, :requiere_persona)";
            if(is_null($nombre_categoria_ingreso) || is_null($tipo_categoria_ingreso) || is_null($requiere_persona)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }else{
                try{
                    $conPDO->beginTransaction();
                    $registro_consulta = $conPDO->prepare($consulta_insert);
                    $registro_consulta->bindParam(":id_usuario", $usuario, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":nombre", $nombre_categoria_ingreso, PDO::PARAM_STR);
                    $registro_consulta->bindParam(":tipo", $tipo_categoria_ingreso, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":requiere_persona", $requiere_persona, PDO::PARAM_INT);
                    if($registro_consulta->execute()){
                        $conPDO->commit();
                        $respuesta = [
                            "estado" =>  1,
                            "mensaje" => "Categoría de ingreso guardada correctamente",
                        ];
                        return $respuesta;
                    }else{
                        $conPDO->rollBack();
                        $respuesta = [
                            "estado" =>  2,
                            "mensaje" => "Error al guardar la categoría de ingreso",
                        ];
                        return $respuesta;
                    }
                }catch(PDOException $e){
                    $conPDO->rollBack();
                    $respuesta = [
                        "estado" =>  2,
                        "mensaje" => "Error al guardar la categoría de ingreso",
                    ];
                    return $respuesta;
                }
            }
        }catch(Exception $e){
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Error al guardar la categoría de ingreso, existio un error durante el proceso de guardado",
            ];
            return $respuesta;
        }
    }

    function actualizar_categoria_ingreso(){
        try{
            global $conPDO;
            $parametros = isset($_POST['parametros']) ? $_POST['parametros'] : null;
            if(is_null($parametros)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }
            $parametros = (object)json_decode($parametros);
            $nombre_categoria_ingreso = isset($parametros->nombre) ? limpiar_cadena($parametros->nombre) : null;
            $tipo_categoria_ingreso = isset($parametros->tipo) ? $parametros->tipo : null;
            $requiere_persona = isset($parametros->requiere_persona) ? $parametros->requiere_persona : null;
            $id_tipo_ingreso = isset($parametros->id) ? Crypto::desencriptacion($parametros->id) : null;
            $consulta_actualizar = "UPDATE tipos_ingresos SET nombre = :nombre, tipo = :tipo, requiere_persona = :requiere_persona 
                WHERE id_tipo_ingreso = :id_tipo_ingreso";
            if(is_null($nombre_categoria_ingreso) || is_null($tipo_categoria_ingreso) || is_null($requiere_persona) || is_null($id_tipo_ingreso)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }else{
                try{
                    $conPDO->beginTransaction();
                    $registro_consulta = $conPDO->prepare($consulta_actualizar);
                    $registro_consulta->bindParam(":nombre", $nombre_categoria_ingreso, PDO::PARAM_STR);
                    $registro_consulta->bindParam(":tipo", $tipo_categoria_ingreso, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":requiere_persona", $requiere_persona, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":id_tipo_ingreso", $id_tipo_ingreso, PDO::PARAM_INT);
                    if($registro_consulta->execute()){
                        $conPDO->commit();
                        $respuesta = [
                            "estado" =>  1,
                            "mensaje" => "Categoría de ingreso actualizada correctamente",
                        ];
                        return $respuesta;
                    }else{
                        $conPDO->rollBack();
                        $respuesta = [
                            "estado" =>  2,
                            "mensaje" => "Error al actualiza la categoría de ingreso",
                        ];
                        return $respuesta;
                    }
                }catch(PDOException $e){
                    $conPDO->rollBack();
                    $respuesta = [
                        "estado" =>  2,
                        "mensaje" => "Error al actualiza la categoría de ingreso",
                    ];
                    return $respuesta;
                }
            }
        }catch(Exception $e){
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Error al actualizar la categoría de ingreso, existio un error durante el proceso de guardado",
            ];
            return $respuesta;
        }
    }

    function obtener_categoria_gastos(){
        $data = [];
        $dato = new stdClass();
        $dato = [
            'tipo' => (int)1,
            'valor' => (int)Crypto::desencriptacion($_SESSION["user"]),
            'nombre' => (string)':usuario',
        ];
        array_push($data, $dato);
        $consultar_cat_gastos = "SELECT * FROM tipos_gastos WHERE id_usuario = :usuario";
        $resultados_gastos = realizar_consulta_array($consultar_cat_gastos, $data);
        if(!$resultados_gastos){
            return false;
        }else{
            $arreglo_cat_gastos = [];
            foreach($resultados_gastos as $gasto){
                $gasto = (object)$gasto;
                $gasto->id_tipo_gasto = Crypto::encriptacion($gasto->id_tipo_gasto);
                $gasto->tipo = match($gasto->tipo){
                    1 => "A DISPOSICIÓN",
                    2 => "CREDITO",
                    default => "No definido",
                };
                $gasto->requiere_persona = match($gasto->requiere_persona){
                    1 => "SI",
                    2 => "NO",
                    default => "No definido",
                };
                $datos_tipo = [
                    "no" => "",
                    "nombre" => $gasto->nombre,
                    "tipo" => $gasto->tipo,
                    "requiere_persona" => $gasto->requiere_persona,
                    "editar" => "<a title='EDITAR REGISTRO' name=\"btn_editar_tipo_gasto_{$gasto->id_tipo_gasto}\" id=\"btnEditar_{$gasto->id_tipo_gasto}\" href=\"#\" class = \"btn btn-secondary form-control\" onclick = \"javascript:editar_tipo_gasto('{$gasto->id_tipo_gasto}')\"><i class=\"fa-solid fa-pencil\"></i></a>",
                ];
                array_push($arreglo_cat_gastos, $datos_tipo);
            }
            return $arreglo_cat_gastos;
        }
    }

    function guardar_categoria_gasto(){
        try{
            global $conPDO;
            $parametros = isset($_POST['parametros']) ? $_POST['parametros'] : null;
            if(is_null($parametros)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }
            $parametros = (object)json_decode($parametros);
            $nombre_categoria_gasto = isset($parametros->nombre) ? limpiar_cadena($parametros->nombre) : null;
            $tipo_categoria_gasto = isset($parametros->tipo) ? $parametros->tipo : null;
            $requiere_persona = isset($parametros->requiere_persona) ? $parametros->requiere_persona : null;
            $usuario = Crypto::desencriptacion($_SESSION["user"]);
            $consulta_insert = "INSERT INTO tipos_gastos (id_usuario, nombre, tipo, requiere_persona) 
                VALUES (:id_usuario, :nombre, :tipo, :requiere_persona)";
            if(is_null($nombre_categoria_gasto) || is_null($tipo_categoria_gasto) || is_null($requiere_persona)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }else{
                try{
                    $conPDO->beginTransaction();
                    $registro_consulta = $conPDO->prepare($consulta_insert);
                    $registro_consulta->bindParam(":id_usuario", $usuario, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":nombre", $nombre_categoria_gasto, PDO::PARAM_STR);
                    $registro_consulta->bindParam(":tipo", $tipo_categoria_gasto, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":requiere_persona", $requiere_persona, PDO::PARAM_INT);
                    if($registro_consulta->execute()){
                        $conPDO->commit();
                        $respuesta = [
                            "estado" =>  1,
                            "mensaje" => "Categoría de gasto guardada correctamente",
                        ];
                        return $respuesta;
                    }else{
                        $conPDO->rollBack();
                        $respuesta = [
                            "estado" =>  2,
                            "mensaje" => "Error al guardar la categoría de gasto",
                        ];
                        return $respuesta;
                    }
                }catch(PDOException $e){
                    $conPDO->rollBack();
                    $respuesta = [
                        "estado" =>  2,
                        "mensaje" => "Error al guardar la categoría de gasto",
                    ];
                    return $respuesta;
                }
            }
        }catch(Exception $e){
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Error al guardar la categoría de gasto, existio un error durante el proceso de guardado",
            ];
            return $respuesta;
        }
    }

    function actualizar_categoria_gasto(){
        try{
            global $conPDO;
            $parametros = isset($_POST['parametros']) ? $_POST['parametros'] : null;
            if(is_null($parametros)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }
            $parametros = (object)json_decode($parametros);
            $nombre_categoria_gasto = isset($parametros->nombre) ? limpiar_cadena($parametros->nombre) : null;
            $tipo_categoria_gasto = isset($parametros->tipo) ? $parametros->tipo : null;
            $requiere_persona = isset($parametros->requiere_persona) ? $parametros->requiere_persona : null;
            $id_tipo_gasto = isset($parametros->id) ? Crypto::desencriptacion($parametros->id) : null;
            $consulta_actualizar = "UPDATE tipos_gastos SET nombre = :nombre, tipo = :tipo, requiere_persona = :requiere_persona 
                WHERE id_tipo_gasto = :id_tipo_gasto";
            if(is_null($nombre_categoria_gasto) || is_null($tipo_categoria_gasto) || is_null($requiere_persona) || is_null($id_tipo_gasto)){
                $respuesta = [
                    "estado" =>  2,
                    "mensaje" => "Error al recibir los datos del usuario",
                ];
                return $respuesta;
            }else{
                try{
                    $conPDO->beginTransaction();
                    $registro_consulta = $conPDO->prepare($consulta_actualizar);
                    $registro_consulta->bindParam(":nombre", $nombre_categoria_gasto, PDO::PARAM_STR);
                    $registro_consulta->bindParam(":tipo", $tipo_categoria_gasto, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":requiere_persona", $requiere_persona, PDO::PARAM_INT);
                    $registro_consulta->bindParam(":id_tipo_gasto", $id_tipo_gasto, PDO::PARAM_INT);
                    if($registro_consulta->execute()){
                        $conPDO->commit();
                        $respuesta = [
                            "estado" =>  1,
                            "mensaje" => "Categoría de gasto actualizada correctamente",
                        ];
                        return $respuesta;
                    }else{
                        $conPDO->rollBack();
                        $respuesta = [
                            "estado" =>  2,
                            "mensaje" => "Error al actualiza la categoría de gasto",
                        ];
                        return $respuesta;
                    }
                }catch(PDOException $e){
                    $conPDO->rollBack();
                    $respuesta = [
                        "estado" =>  2,
                        "mensaje" => "Error al actualiza la categoría de gasto",
                    ];
                    return $respuesta;
                }
            }
        }catch(Exception $e){
            $respuesta = [
                "estado" => 2,
                "mensaje" => "Error al actualizar la categoría de gasto, existio un error durante el proceso de guardado",
            ];
            return $respuesta;
        }
    }
?>