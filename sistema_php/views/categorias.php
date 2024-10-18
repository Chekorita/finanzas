<?php
    require CONFIG.'crypto.php';
    function generar_vista(): string | bool {
        $codigo ='
            <div class="row row-cols-2 p-3">
                <div class="col my-2" id="contenedor-ingresos">
                    <h3 class="text-center">CATEGORIAS DE INGRESOS</h3>
                    <button class="btn btn-success form-control" onclick="agregar_categoria_ingresos()">
                        <i class="bi bi-plus"></i> AGREGAR CATEGORIA INGRESO
                    </button>
                    <br><br>
                    <div id="contenedor-tabla-ingresos"></div>
                </div>
                <div class="col my-2" id="contenedor-gastos">
                    <h3 class="text-center">CATEGORIAS DE GASTOS</h3>
                    <button class="btn btn-success form-control" onclick="agregar_categoria_gastos()">
                        <i class="bi bi-plus-lg"></i> AGREGAR CATEGORIA GASTO
                    </button>
                    <br><br>
                    <div id="contenedor-tabla-gastos"></div>
                </div>
            </div>
        ';
        return $codigo;
    }
?>