<?php
	include './config/variables.php';
    include CONFIG.'database.php';
	include CONFIG.'logueo_seguro.php';
	include FUNCTIONS.'funciones_generales.php';
    include VIEWS.'alta_edicion_categoria_gastos.php';

    $funcion = (isset($_POST['funcion'])) ? $_POST['funcion'] : null;
	$id_encriptado = (isset($_POST['id_categoria_gastos'])) ? $_POST['id_categoria_gastos'] : "";
	if(is_null($funcion)){
        header('Location:'.URL.'vista_categorias.php');
	}

	$config = [
		"nombre" => "ALTA/EDICION CATEGORIAS GASTOS",
		"titulo" => "ALTA/EDICION CATEGORIAS GASTOS",
	];
	$estilos =[
		"estilos_generales" => [
            "nombre" => "estilos_generales",
            "url" => CSS."estilos_generales.css",
        ],
	];
	$breadcrumbs =[
        "menu_opciones" =>[
			"nombre" => "Inicio",
			"url" => URL."vista_menu_opciones.php",
			"status" => '',
			"aria" => '',
			"enlace" => 'true',
		],
		"catalogo_ingresos_gastos" => [
			"nombre" => "Catálogo de ingresos y gastos",
			"url" => URL."vista_categorias.php",
			"status" => '',
			"aria" => '',
			"enlace" => 'true',
		],
        "formulario_catalogo_gasto" => [
			"nombre" => "Alta/Edición de categorias de gastos",
			"url" => URL."vista_alta_edicion_categoria_gastos.php",
			"status" => 'active',
			"aria" => 'aria-current=\"page\"',
			"enlace" => 'false',
		],
    ];
	$scripts = [
        "funciones_alta_edicion_categorias_gastos" => [
            "nombre" => "funciones_alta_edicion_categorias_gastos",
            "url" => JS_FUNCTIONS."funciones_alta_edicion_categorias_gastos.js",
        ],
    ];

	include INCLUDES.'header.php';
    include INCLUDES_M.'cuerpo_general.php';
    include INCLUDES_M.'navbar.php';
    include INCLUDES_M.'sidebar.php';
    include INCLUDES_M.'cabecera_breadcrumbs.php';
?>
	<div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ALTA/EDICION DE CATEGORIA</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button>  </div>
                        </div>
                        <div class="card-body">
							<?php 
                                echo generar_vista($funcion, $id_encriptado);
                            ?>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include INCLUDES.'footer.php'; ?>