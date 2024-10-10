<?php
    include './config/variables.php';
    include CONFIG.'database.php';
	include FUNCTIONS.'funciones_generales.php';
	$config = [
		"nombre" => "Inicio de sesión",
		"titulo" => "Inicio de sesión",
	];
	$estilos =[];
	$scripts =[
		"funciones_login" => [
            "nombre" => "funciones_login",
            "url" => JS_FUNCTIONS."funciones_login.js",
        ],
	];
	include INCLUDES.'header.php';
?>

<div class="background">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>

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
						<div class="col fw-bold display-6 my-2">
							<?php echo mb_strtoupper($config->nombre, 'UTF-8'); ?>
						</div>
						<div class="col my-2">
							<label for="username" class="form-label fw-bold">Nombre de usuario:</label>
							<input class="form-control" type="text" name="username" id="username" placeholder="Nombre de usuario" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-username" required>
							<div id="ayuda-username" class="form-text">Ingresa el nombre de usuario con el que te registraste.</div>
						</div>
						<div class="col my-2">
							<label for="password" class="form-label fw-bold">Contraseña:</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" autocorrect="off" autocapitalize="off" required>
                                <button class="btn btn-outline-secondary" onmouseover="abre_ojito('password','ico-ojito'); return false;" onmouseout="cierra_ojito('password','ico-ojito'); return false;" type="button" id="btn-editar-usuario"><i id = "ico-ojito" class="fa-solid fa-eye-low-vision"></i></button>
                            </div>
						</div>
						<div class="col my-2">
							<a id="btn-inciar-sesion" href="#" onclick="iniciar_sesion(); return false;" class="btn btn-primary form-control" name="submit">
								<i class="fa-solid fa-user"></i>&nbsp;
								<span>Iniciar sesión</span>
							</a>
						</div>
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