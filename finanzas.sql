START TRANSACTION;

DROP DATABASE IF EXISTS `finanzas`;
CREATE DATABASE IF NOT EXISTS `finanzas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `finanzas`;

CREATE TABLE `cuenta_monetaria` (
  `id_cuenta` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la cuenta, ya sea el nombre del banco o que se diga que es el dinero de tu cartera',
  `fondo` decimal(10,0) NOT NULL DEFAULT 0 COMMENT 'Se trata del dinero que contiene esa cuenta, se va sumando o restando según los ingresos y egresos que se registren',
  `tipo` int(11) NOT NULL DEFAULT 1 COMMENT '1 = a disposición (como dinero físico, tarjetas de debito) estas son las que se cuentan para saber cuanto dinero dispones en el momento, 2 = Tarjetas de crédito, estas no se contabilizan para el dinero que tienes, pero si para poder manejar tus gastos de crédito',
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que esta ligada la cuenta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre real de la persona',
  `apodo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Solo un apodo para poder reconocerla mejor',
  `contacto` int(11) NOT NULL COMMENT 'Son los diferentes medios que se le registran, ya sea como persona física o cuentas de banco',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID de usuario al que esta ligada la persona'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL COMMENT 'Nombre de usuario con el que se va a acceder',
  `acceso` varchar(255) NOT NULL COMMENT 'Contraseña encriptada con la que se registro',
  `random` varchar(255) NOT NULL COMMENT 'Cadena de texto con caracteres random con el cual se complementa para la contraseña de acceso',
  `paterno` varchar(255) NOT NULL COMMENT 'Apellido paterno',
  `materno` varchar(255) NOT NULL COMMENT 'Apellido materno',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del usuario',
  `ingreso_mensual` decimal(10,0) NOT NULL DEFAULT 0 COMMENT 'Es el ingreso mensual que tiene el usuario, será usado para la creación de presupuestos, en caso de estar en 0, no se podrá hacer presupuestos',
  `estado` int(1) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `cuenta_monetaria`
  ADD PRIMARY KEY (`id_cuenta`);

ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);


ALTER TABLE `cuenta_monetaria`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cuenta_monetaria`
  ADD CONSTRAINT `cuenta_monetaria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

COMMIT;