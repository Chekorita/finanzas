<?php
    include './config/variables.php';
    include CONFIG.'database.php';
	include FUNCTIONS.'funciones_generales.php';
	$config = [
		"nombre" => "Registro de nuevo usuario",
		"titulo" => "Registro de nuevo usuario",
	];
	$estilos =[];
	$scripts =[
		"funciones_nuevo_usuario" => [
            "nombre" => "funciones_nuevo_usuario",
            "url" => JS_FUNCTIONS."funciones_nuevo_usuario.js",
        ],
	];
	include INCLUDES.'header.php';
?>

<div id="large-header" class="large-header container-fluid contenedor-login">
	<canvas id="demo-canvas"></canvas>
	<div class="row mx-auto" id="tarjeta-login">
		<div class="col">
			<div class="card text-center shadow">
				<div class="card-header">
					<img src="<?php echo ICONS.NOMBRE_LOGOS; ?>LIGHT.png" alt="FINANZAS LOGO" class="img-fluid w-50">
				</div>
				<div class="card-body">
					<div class="row row-cols-1">
					</div>
				</div>
				<div class="card-footer text-muted">
					<?php echo mb_strtoupper(NOMBRE_SISTEMA, 'UTF-8'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	include INCLUDES.'footer_index.php';
?>