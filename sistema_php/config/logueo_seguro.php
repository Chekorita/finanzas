<?php
	session_name('Finanzas');
	session_start();
	if(isset($_SESSION['sesion_iniciada'])){
		if($_SESSION['sesion_iniciada'] != 'sesion_iniciada'){
			header("Location: ./cerrar_sesion.php");
		}else{
			$inactividad = 3600;
			if(isset($_SESSION["tiempo_logueo"])){
				$sessionTTL = time() - $_SESSION["tiempo_logueo"];
				if($sessionTTL > $inactividad){
					header("Location: ./cerrar_sesion.php");
				}else{
					$_SESSION["tiempo_logueo"]=time();
				}
			}else{
				header("Location: ./cerrar_sesion.php");
			}
		}
	}else{
		header("Location: ./cerrar_sesion.php");
	}
?>