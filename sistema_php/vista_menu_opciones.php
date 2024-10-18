<?php
	include './config/variables.php';
    include CONFIG.'database.php';
	include CONFIG.'logueo_seguro.php';
	include FUNCTIONS.'funciones_generales.php';
    include VIEWS.'menu_principal.php';

	$config = [
		"nombre" => "Inicio",
		"titulo" => "Inicio",
	];
	$estilos =[
		"menuOpc" => [
            "nombre" => "menuOpc",
            "url" => CSS."estilos_menu_opciones.css",
        ],
		"estilos_generales" => [
            "nombre" => "estilos_generales",
            "url" => CSS."estilos_generales.css",
        ],
	];
	$breadcrumbs =[
        "menu_opciones" => [
            "nombre" => "Inicio",
            "url" => URL."vista_menu_opciones.php",
            "status" => 'active',
            "aria" => 'aria-current=\"page\"',
            "enlace" => 'false',
        ],
    ];
	$scripts = [
        "menuOpc" => [
            "nombre" => "menuOpc",
            "url" => JS."menu_opciones.js",
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
                            <h3 class="card-title">CUENTAS Y PRESUPUESTOS ACTIVOS</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button>  </div>
                        </div>
                        <div class="card-body">
							<?php 
                                echo generar_vista($_SESSION["user"]);
                            ?>
                        </div>
                        <div class="card-footer">Selecciona las opciones disponibles para el perfil</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include INCLUDES.'footer.php'; ?>