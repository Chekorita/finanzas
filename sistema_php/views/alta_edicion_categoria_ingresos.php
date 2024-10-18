<?php
    require CONFIG.'crypto.php';
    function generar_vista(string $funcion, string $id_categoria_ingreso): string | bool {
        $codigo ='';
        switch($funcion){
            case 'agregar_categoria_ingresos':
                $codigo = "
                <div class=\"row row-cols-1 p-3\">
                    <div class=\"col my-2\">
                        <div class=\"row row-cols-3\">
                            <div class=\"col text-start\">
                                <label for=\"nombre_categoria_ingreso\" class=\"form-label\">Nombre de la categoría de ingreso: *</label>
                                <input type=\"text\" class=\"form-control\" id=\"nombre_categoria_ingreso\" name=\"nombre_categoria_ingreso\" aria-describedby=\"ayuda_nombre_ingreso\" required>
                                <div class=\"form-text\">Ejemplo: Salario, Venta de productos, transferencias, etc.</div>
                                <div id=\"ayuda_nombre_ingreso\" class=\"form-text\"></div>
                            </div>
                            <div class=\"col text-start\">
                                <label for=\"sel_tipo_ingreso\" class=\"form-label\">Tipo: *</label>
                                <select class=\"form-select\" id=\"sel_tipo_ingreso\" name=\"sel_tipo_ingreso\" required>
                                    <option value=\"1\">A disposición</option>
                                    <option value=\"2\">Crédito</option>
                                </select>
                                <div class=\"form-text\">Tipo: A disposición es el dinero real que tienes, Crédito es el ingreso para pagos a tarjetas de crédito</div>
                            </div>
                            <div class=\"col text-start\">
                                <label for=\"sel_requiere_persona\" class=\"form-label\">Requiere persona: *</label>
                                <select class=\"form-select\" id=\"sel_requiere_persona\" name=\"sel_requiere_persona\">
                                    <option value=\"1\">SI</option>
                                    <option value=\"2\">NO</option>
                                </select>
                                <div class=\"form-text\">Requiere persona: es para saber si el ingreso proviene de una persona(normal para transferencias), en caso de que no, es por eventos externos</div>
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
            case 'editar_categoria_ingresos':
                if(empty($id_categoria_ingreso) || $id_categoria_ingreso == '') {
                    $codigo = "<div class=\"alert alert-danger\" role=\"alert\">No se ha ingresado con los datos necesarios</div>";
                }else{
                    $id_categoria_ingreso = Crypto::desencriptacion($id_categoria_ingreso);
                    $data = [];
                    $dato = new stdClass();
                    $dato = [
                        'tipo' => (int)1,
                        'valor' => (int)$id_categoria_ingreso,
                        'nombre' => ':id_tipo_ingreso',
                    ];
                    array_push($data, $dato);
                    $consulta = "SELECT * FROM tipos_ingresos WHERE id_tipo_ingreso = :id_tipo_ingreso";
                    $resultado_tipo_ingreso = realizar_consulta($consulta, $data);
                    $resultado_tipo_ingreso->id_encriptado = Crypto::encriptacion($resultado_tipo_ingreso->id_tipo_ingreso);
                    $resultado_tipo_ingreso->sel_tipo_1 = ($resultado_tipo_ingreso->tipo == 1) ? 'selected' : '';
                    $resultado_tipo_ingreso->sel_tipo_2 = ($resultado_tipo_ingreso->tipo == 2) ? 'selected' : '';
                    $resultado_tipo_ingreso->sel_persona_1 = ($resultado_tipo_ingreso->requiere_persona == 1) ? 'selected' : '';
                    $resultado_tipo_ingreso->sel_persona_2 = ($resultado_tipo_ingreso->requiere_persona == 2) ? 'selected' : '';
                    $codigo = "
                    <div class=\"row row-cols-1 p-3\">
                        <div class=\"col my-2\">
                            <div class=\"row row-cols-3\">
                                <div class=\"col text-start\">
                                    <label for=\"nombre_categoria_ingreso\" class=\"form-label\">Nombre de la categoría de ingreso: *</label>
                                    <input type=\"text\" class=\"form-control\" id=\"nombre_categoria_ingreso\" name=\"nombre_categoria_ingreso\" aria-describedby=\"ayuda_nombre_ingreso\" required value=\"{$resultado_tipo_ingreso->nombre}\">
                                    <div class=\"form-text\">Ejemplo: Salario, Venta de productos, transferencias, etc.</div>
                                    <div id=\"ayuda_nombre_ingreso\" class=\"form-text\"></div>
                                </div>
                                <div class=\"col text-start\">
                                    <label for=\"sel_tipo_ingreso\" class=\"form-label\">Tipo: *</label>
                                    <select class=\"form-select\" id=\"sel_tipo_ingreso\" name=\"sel_tipo_ingreso\" required>
                                        <option value=\"1\" {$resultado_tipo_ingreso->sel_tipo_1}>A disposición</option>
                                        <option value=\"2\" {$resultado_tipo_ingreso->sel_tipo_2}>Crédito</option>
                                    </select>
                                    <div class=\"form-text\">Tipo: A disposición es el dinero real que tienes, Crédito es el ingreso para pagos a tarjetas de crédito</div>
                                </div>
                                <div class=\"col text-start\">
                                    <label for=\"sel_requiere_persona\" class=\"form-label\">Requiere persona: *</label>
                                    <select class=\"form-select\" id=\"sel_requiere_persona\" name=\"sel_requiere_persona\">
                                        <option value=\"1\" {$resultado_tipo_ingreso->sel_persona_1}>SI</option>
                                        <option value=\"2\" {$resultado_tipo_ingreso->sel_persona_2}>NO</option>
                                    </select>
                                    <div class=\"form-text\">Requiere persona: es para saber si el ingreso proviene de una persona(normal para transferencias), en caso de que no, es por eventos externos</div>
                                </div>
                            </div>
                        </div>
                        <div class=\"col my-2\">
                            <a type=\"button\" name=\"btn_editar\" id=\"btn_editar\" class=\"btn btn-success form-control\" onClick=\"javascript:validar_actualizacion('{$resultado_tipo_ingreso->id_encriptado}')\">
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