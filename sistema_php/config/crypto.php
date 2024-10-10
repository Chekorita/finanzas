<?php
	define('METHOD', 'AES-256-CBC');
	define('SECRET_KEY', 'K2K17iU4ML');
	define('SECRET_IV', '6000456817');
	class Crypto{
		public static function encriptacion($clave){
			$encriptado=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$encriptado=openssl_encrypt($clave, METHOD, $key, 0, $iv);
			$encriptado=base64_encode($encriptado);
			return $encriptado;
		}

		public static function desencriptacion($clave){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$desencriptado=openssl_decrypt(base64_decode($clave), METHOD, $key, 0, $iv);
			return $desencriptado;
		}
	}
?>