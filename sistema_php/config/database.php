<?php
	$dsn = "mysql:dbname=finanzas;host=localhost";
	$fecha_hoy = date('Y-m-d h:i:s');
	$palabra_sitio="finanzas*396";
	try {
		$default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        ];
		$conPDO = new PDO($dsn, 'finanzas_usr', 'icQRCfdh8395', $default_options);
		$conPDO->exec("set names utf8");
	} catch (PDOException $e) {
		echo 'Error al conectarse a la base de datos';
		exit;
	}

	function realizar_consulta(string $sql, array $parametros = []): object | bool{
		global $conPDO;
		$consulta = $conPDO->prepare($sql);
		if(!empty($parametros)):
			foreach($parametros as $parametro):
				$parametro = (object)$parametro;
				switch($parametro->tipo):
					//INT(1), BOOL(2), NULL(3), STRING(4), DEFAULT(STRING)
					case 1:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_INT);
					break;
					case 2:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_BOOL);
					break;
					case 3:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_NULL);
					break;
					case 4:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
					default:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
				endswitch;
			endforeach;
		endif;
		$consulta->execute();
		$resultado = $consulta->fetchObject();
		if($resultado !== null || $resultado !== false){
			return $resultado;
		}else{
			return false;
		}
	}

	function realizar_consulta_column(string $sql, array $parametros = []): int | string | array | bool{
		global $conPDO;
		$consulta = $conPDO->prepare($sql);
		if(!empty($parametros)):
			foreach($parametros as $parametro):
				$parametro = (object)$parametro;
				switch($parametro->tipo):
					//INT(1), BOOL(2), NULL(3), STRING(4), DEFAULT(STRING)
					case 1:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_INT);
					break;
					case 2:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_BOOL);
					break;
					case 3:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_NULL);
					break;
					case 4:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
					default:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
				endswitch;
			endforeach;
		endif;
		$consulta->execute();
		$resultado = $consulta->fetchColumn();
		if($resultado !== null || $resultado !== false){
			return $resultado;
		}else{
			return false;
		}
	}

	function realizar_consulta_id(string $sql, array $parametros = []): int | bool{
		global $conPDO;
		try{
			$conPDO->beginTransaction();
			$consulta = $conPDO->prepare($sql);
			if(!empty($parametros)):
				foreach($parametros as $parametro):
					$parametro = (object)$parametro;
					switch($parametro->tipo):
						//INT(1), BOOL(2), NULL(3), STRING(4), DEFAULT(STRING)
						case 1:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_INT);
						break;
						case 2:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_BOOL);
						break;
						case 3:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_NULL);
						break;
						case 4:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
						break;
						default:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
						break;
					endswitch;
				endforeach;
			endif;
			$consulta->execute();
			$resultado = $consulta->rowCount();
			if($resultado !== null || $resultado !== false || $resultado !== 0){
				$conPDO->commit();
				return $resultado;
			}else{
				$conPDO->rollBack();
				return false;
			}
		}catch(PDOException $e){
			$conPDO->rollBack();
			return false;
		}
	}

	function realizar_consulta_array(string $sql, array $parametros = []): array | bool{
		global $conPDO;
		$consulta = $conPDO->prepare($sql);
		if(!empty($parametros)):
			foreach($parametros as $parametro):
				$parametro = (object)$parametro;
				switch($parametro->tipo):
					//INT(1), BOOL(2), NULL(3), STRING(4), DEFAULT(STRING)
					case 1:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_INT);
					break;
					case 2:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_BOOL);
					break;
					case 3:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_NULL);
					break;
					case 4:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
					default:
						$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
					break;
				endswitch;
			endforeach;
		endif;
		$consulta->execute();
		$resultado = $consulta->fetchAll();
		if($resultado != null || $resultado != false){
			return $resultado;
		}
		else{
			return false;
		}
	}

	function realizar_insert_last_id(string $sql, array $parametros = []): int | bool {
		global $conPDO;
		try{
			$conPDO->beginTransaction();
			$consulta = $conPDO->prepare($sql);
			if(!empty($parametros)):
				foreach($parametros as $parametro):
					$parametro = (object)$parametro;
					switch($parametro->tipo):
						//INT(1), BOOL(2), NULL(3), STRING(4), DEFAULT(STRING)
						case 1:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_INT);
						break;
						case 2:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_BOOL);
						break;
						case 3:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_NULL);
						break;
						case 4:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
						break;
						default:
							$consulta->bindValue($parametro->nombre, $parametro->valor, PDO::PARAM_STR);
						break;
					endswitch;
				endforeach;
			endif;
			$consulta->execute();
			$resultado = $consulta->rowCount();
			if($resultado !== null || $resultado !== false || $resultado !== 0){
				$last_id = $conPDO->lastInsertId();
				$conPDO->commit();
				return $last_id;
			}else{
				$conPDO->rollBack();
				return false;
			}
		}catch(PDOException $e){
			$conPDO->rollBack();
			return false;
		}
	}
?>