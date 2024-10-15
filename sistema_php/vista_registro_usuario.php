<?php
    include './config/variables.php';
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

<div id="large-header" class="large-header container-fluid">
	<div class="row mx-auto">
		<div class="col">
			<div class="card shadow">
				<div class="card-header">
					<h1 class="card-title">REGISTRO DE USUARIO</h1>
					<div class="card-tools"><button type="button" class="btn btn-tool" onclick="regresar_login(); return false;"><i class="fa-solid fa-arrow-left"></i> REGRESAR</button></div>
				</div>
				<div class="card-body">
					<div class="row row-cols-1 mx-3 rounded bg-light shadow-none" id="contenedor-alertas"></div>
					<div class="row row-cols-1 p-3">
						<div class="col my-2">
							<div class="row row-cols-4">
								<div class="col text-start">
									<label for="nombre" class="form-label fw-bold">Nombre *:</label>
									<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-nombre" required>
									<div id="ayuda-nombre" class="form-text"></div>
								</div>
								<div class="col text-start">
									<label for="apellido_paterno" class="form-label fw-bold">Apellido paterno *:</label>
									<input class="form-control" type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido paterno" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-apellido_paterno" required>
									<div id="ayuda-apellido-paterno" class="form-text"></div>
								</div>
								<div class="col text-start">
									<label for="apellido_materno" class="form-label fw-bold">Apellido materno *:</label>
									<input class="form-control" type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido materno" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-apellido_materno" required>
									<div id="ayuda-apellido-materno" class="form-text"></div>
								</div>
								<div class="col text-start">
									<label for="ingreso_mensual" class="form-label fw-bold">Ingreso mensual:</label>
									<input class="form-control" type="number" name="ingreso_mensual" id="ingreso_mensual" placeholder="Ingreso mensual" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-ingreso-mensual" required>
									<div id="ayuda-ingreso-mensual" class="form-text"></div>
								</div>
							</div>
						</div>
						<div class="col my-2">
							<div class="row row-cols-3">
								<div class="col text-start">
									<label for="usuario" class="form-label fw-bold">Usuario *:</label>
									<input class="form-control" type="text" name="usuario" id="usuario" placeholder="usuario" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-usuario" required>
									<div id="ayuda-usuario" class="form-text"></div>
								</div>
								<div class="col text-start">
									<label for="contrasena" class="form-label fw-bold">Contraseña *:</label>
									<div class="input-group mb-3">
										<input class="form-control" type="password" name="contrasena" id="contrasena" placeholder="Contraseña" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-contrasena" required>
										<button class="btn btn-outline-secondary" onmouseover="abre_ojito('contrasena','ico-ojito-contrasena'); return false;" onmouseout="cierra_ojito('contrasena','ico-ojito-contrasena'); return false;" type="button" id="btn-ver-contrasena"><i id = "ico-ojito-contrasena" class="fa-solid fa-eye-low-vision"></i></button>
									</div>
									<div id="ayuda-contrasena" class="form-text"></div>
								</div>
								<div class="col text-start">
									<label for="confirmar_contrasena" class="form-label fw-bold">Confirmar contraseña *:</label>
									<div class="input-group mb-3">
										<input class="form-control" type="password" name="confirmar_contrasena" id="confirmar_contrasena" placeholder="Confirmar contraseña" autocorrect="off" autocapitalize="off" aria-describedby="ayuda-confirmar-contrasena" required>
										<button class="btn btn-outline-secondary" onmouseover="abre_ojito('confirmar_contrasena','ico-ojito-confirmar-contrasena'); return false;" onmouseout="cierra_ojito('confirmar_contrasena','ico-ojito-confirmar-contrasena'); return false;" type="button" id="btn-ver-confirmar-contrasena"><i id = "ico-ojito-confirmar-contrasena" class="fa-solid fa-eye-low-vision"></i></button>
									</div>
									<div id="ayuda-confirmar-contrasena" class="form-text"></div>
								</div>
							</div>
						</div>
						<div class="col my-2">
							<button id="btn-guardar" onclick="registrar_usuario(); return false;" class="btn btn-primary form-control">
								<i class="fa-solid fa-floppy-disk"></i>&nbsp;
								<span>Registrar</span>
							</button>
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