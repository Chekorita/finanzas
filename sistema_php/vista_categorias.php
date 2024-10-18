<?php
	include './config/variables.php';
    include CONFIG.'database.php';
	include CONFIG.'logueo_seguro.php';
	include FUNCTIONS.'funciones_generales.php';
    include VIEWS.'categorias.php';

	$config = [
		"nombre" => "CATEGORIAS",
		"titulo" => "CATEGORIAS",
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
			"status" => 'active',
			"aria" => 'aria-current=\"page\"',
			"enlace" => 'false',
		],
    ];
	$scripts = [
        "funciones_categorias" => [
            "nombre" => "funciones_categorias",
            "url" => JS_FUNCTIONS."funciones_categorias.js",
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
                            <h3 class="card-title">CATEGORIAS DE INGRESOS Y GASTOS</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button>  </div>
                        </div>
                        <div class="card-body">
							<?php 
                                echo generar_vista();
                            ?>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include INCLUDES.'footer.php'; ?>