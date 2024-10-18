<?php
    require CONFIG.'crypto.php';
    function generar_vista(string $funcion, string $id_categoria_gasto): string | bool {
        $codigo ='';
        switch($funcion){
            case 'agregar_categoria_gastos':
                $codigo = "
                <div class=\"row row-cols-1 p-3\">
                    <div class=\"col my-2\">
                        <div class=\"row row-cols-3\">
                            <div class=\"col text-start\">
                                <label for=\"nombre_categoria_gasto\" class=\"form-label\">Nombre de la categoría de gasto: *</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre_categoria_gasto\" name=\"nombre_categoria_gasto\" aria-describedby=\"ayuda_nombre_gasto\" required>
                                <div class=\"form-text\">Ejemplo: Comida, Chucheria, Transporte, Servicios, etc.</div>
                                <div id=\"ayuda_nombre_gasto\" class=\"form-text\"></div>
                            </div>
                            <div class=\"col text-start\">
                                <label for=\"sel_tipo_gasto\" class=\"form-label\">Tipo: *</label>
                                <select class=\"form-select\" id=\"sel_tipo_gasto\" name=\"sel_tipo_gasto\" required>
                                    <option value=\"1\">A disposición</option>
                                    <option value=\"2\">Crédito</option>
                                </select>
                                <div class=\"form-text\">Tipo: A disposición es el dinero real que tienes, Crédito es el gasto de pagos con tarjetas de crédito</div>
                            </div>
                            <div class=\"col text-start\">
                                <label for=\"sel_requiere_persona\" class=\"form-label\">Requiere persona: *</label>
                                <select class=\"form-select\" id=\"sel_requiere_persona\" name=\"sel_requiere_persona\">
                                    <option value=\"1\">SI</option>
                                    <option value=\"2\">NO</option>
                                </select>
                                <div class=\"form-text\">Requiere persona: es para saber si el gasto va a una persona(normal para transferencias), en caso de que no, es por eventos externos</div>
                            </div>
                        </div>
                    </div>
                    <div class=\"col my-2\">
                        <a type=\"button\" name=\"btn_alta\" id=\"btn_alta\" class=\"btn btn-success form-control\" onClick=\"javascript:validar_insercion()\">
                            <i class=\"fa-solid fa-floppy-disk fa-lg\"></i>
                            <span>GUARDAR</span>
                        </a>
                    </div>
                </div>
                ";
            break;
            case 'editar_categoria_gastos':
                if(empty($id_categoria_gasto) || $id_categoria_gasto == '') {
                    $codigo = "<div class=\"alert alert-danger\" role=\"alert\">No se ha ingresado con los datos necesarios</div>";
                }else{
                    $id_categoria_gasto = Crypto::desencriptacion($id_categoria_gasto);
                    $data = [];
                    $dato = new stdClass();
                    $dato = [
                        'tipo' => (int)1,
                        'valor' => (int)$id_categoria_gasto,
                        'nombre' => ':id_tipo_gasto',
                    ];
                    array_push($data, $dato);
                    $consulta = "SELECT * FROM tipos_gastos WHERE id_tipo_gasto = :id_tipo_gasto";
                    $resultado_tipo_gasto = realizar_consulta($consulta, $data);
                    $resultado_tipo_gasto->id_encriptado = Crypto::encriptacion($resultado_tipo_gasto->id_tipo_gasto);
                    $resultado_tipo_gasto->sel_tipo_1 = ($resultado_tipo_gasto->tipo == 1) ? 'selected' : '';
                    $resultado_tipo_gasto->sel_tipo_2 = ($resultado_tipo_gasto->tipo == 2) ? 'selected' : '';
                    $resultado_tipo_gasto->sel_persona_1 = ($resultado_tipo_gasto->requiere_persona == 1) ? 'selected' : '';
                    $resultado_tipo_gasto->sel_persona_2 = ($resultado_tipo_gasto->requiere_persona == 2) ? 'selected' : '';
                    $codigo = "
                    <div class=\"row row-cols-1 p-3\">
                        <div class=\"col my-2\">
                            <div class=\"row row-cols-3\">
                                <div class=\"col text-start\">
                                    <label for=\"nombre_categoria_gasto\" class=\"form-label\">Nombre de la categoría de gasto: *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre_categoria_gasto\" name=\"nombre_categoria_gasto\" aria-describedby=\"ayuda_nombre_gasto\" required value=\"{$resultado_tipo_gasto->nombre}\">
                                    <div class=\"form-text\">Ejemplo: Comida, Chucheria, Transporte, Servicios, etc.</div>
                                    <div id=\"ayuda_nombre_gasto\" class=\"form-text\"></div>
                                </div>
                                <div class=\"col text-start\">
                                    <label for=\"sel_tipo_gasto\" class=\"form-label\">Tipo: *</label>
                                    <select class=\"form-select\" id=\"sel_tipo_gasto\" name=\"sel_tipo_gasto\" required>
                                        <option value=\"1\" {$resultado_tipo_gasto->sel_tipo_1}>A disposición</option>
                                        <option value=\"2\" {$resultado_tipo_gasto->sel_tipo_2}>Crédito</option>
                                    </select>
                                    <div class=\"form-text\">Tipo: A disposición es el dinero real que tienes, Crédito es el gasto de pagos con tarjetas de crédito</div>
                                </div>
                                <div class=\"col text-start\">
                                    <label for=\"sel_requiere_persona\" class=\"form-label\">Requiere persona: *</label>
                                    <select class=\"form-select\" id=\"sel_requiere_persona\" name=\"sel_requiere_persona\">
                                        <option value=\"1\" {$resultado_tipo_gasto->sel_persona_1}>SI</option>
                                        <option value=\"2\" {$resultado_tipo_gasto->sel_persona_2}>NO</option>
                                    </select>
                                    <div class=\"form-text\">Requiere persona: es para saber si el gasto va a una persona(normal para transferencias), en caso de que no, es por eventos externos</div>
                                </div>
                            </div>
                        </div>
                        <div class=\"col my-2\">
                            <a type=\"button\" name=\"btn_editar\" id=\"btn_editar\" class=\"btn btn-success form-control\" onClick=\"javascript:validar_actualizacion('{$resultado_tipo_gasto->id_encriptado}')\">
                                <i class=\"fa-solid fa-floppy-disk fa-lg\"></i>
                                <span>GUARDAR</span>
                            </a>
                        </div>
                    </div>
                    ";
                }
            break;
            default:
                $codigo = "<div class=\"alert alert-danger\" role=\"alert\">No se ha ingresado con los datos necesarios</div>";
            break;
        }
        return $codigo;
    }
?>