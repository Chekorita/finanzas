START TRANSACTION;

-- La siguiente linea no es necesaria, ya que solo lo uso para limpieza de mi base, lo importante es el create y el use
DROP TABLE IF EXISTS `finanzas`
CREATE DATABASE IF NOT EXISTS `finanzas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `finanzas`;

-- Se crean las tablas
CREATE TABLE `cuenta_monetaria` (
  `id_cuenta` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la cuenta, ya sea el nombre del banco o que se diga que es el dinero de tu cartera',
  `fondo` decimal(10,0) NOT NULL DEFAULT 0 COMMENT 'Se trata del dinero que contiene esa cuenta, se va sumando o restando según los ingresos y egresos que se registren, en caso de ser a disposición se inicializa en 0, en caso de ser de crédito, se le debe establecer el dinero inicial',
  `tipo` int(11) NOT NULL DEFAULT 1 COMMENT '1 = a disposición (como dinero físico, tarjetas de debito) estas son las que se cuentan para saber cuanto dinero dispones en el momento, 2 = Tarjetas de crédito, estas no se contabilizan para el dinero que tienes, pero si para poder manejar tus gastos de crédito',
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo, No se eliminan ya que quedaran para el registro de anteriores casos de años pasados',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que esta ligada la cuenta',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona a la que se le esta haciendo el gasto en caso de ser necesario',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta desde la que se están gastando sus fondos',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que realizo el gasto',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `monto` decimal(10,0) NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT '' COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_ingreso` int(11) NOT NULL COMMENT 'ID del tipo de ingreso que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona registrada que te hizo el ingreso, eso en caso de que sea necesaria',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta a la que se esta haciendo el ingreso',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que realizo el ingreso',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre real de la persona',
  `apodo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Solo un apodo para poder reconocerla mejor',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID de usuario al que esta ligada la persona',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del presupuesto',
  `monto` decimal(10,0) NOT NULL COMMENT 'Dinero con el que se cuenta para este presupuesto, no puede exceder el ingreso mensual',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que seria para este presupuesto',
  `estado` int(11) NOT NULL COMMENT '1 = Activo, 2= Inactivo',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que genero este presupuesto',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `tipos_gastos` (
  `id_tipo_gasto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '' COMMENT 'Es el nombre del tipo de gasto, como transferencia, chucherías, etc., son las categorías de gastos que puedes tener',
  `tipo` int(11) NOT NULL COMMENT '1 = para los de disposición, estos se toman para restar a los montos de cuentas, 2 = crédito, esto descuenta el monto disponible pero sin contar como un gasto real de tu dinero actual',
  `requiere_persona` int(11) NOT NULL COMMENT '1 = Si, con esto hace que se desplieguen las personas y o empresas fijas que hayas registrado, así se despliegan para mantener una mejor control, por ejemplo para las transferencias, 2= No, es una tipo de gasto que no se puede registrar para una persona',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que tiene este tipo de gasto',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `tipos_ingresos` (
  `id_tipo_ingreso` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de ingreso, puede ser tu paga de trabajo, transferencia, pago a tarjeta de crédito, etc.',
  `tipo` int(11) NOT NULL COMMENT '1 = de los de disposición, esto hará que aumente el dinero que tienes en cuentas a disposición, tu dinero real, 2 = es el pago que haces a tus cuentas de crédito',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que se le va a ligar este tipo de ingreso',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `estado` int(1) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


-- Se declaran las llaves primarias
ALTER TABLE `cuenta_monetaria`
  ADD PRIMARY KEY (`id_cuenta`);

ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gasto`);

ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`);

ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`);

ALTER TABLE `tipos_gastos`
  ADD PRIMARY KEY (`id_tipo_gasto`);

ALTER TABLE `tipos_ingresos`
  ADD PRIMARY KEY (`id_tipo_ingreso`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

-- Es dar el AUTO_INCREMENT a las las llaves primarias 
ALTER TABLE `cuenta_monetaria`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gastos`
  MODIFY `id_gasto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_gastos`
  MODIFY `id_tipo_gasto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_ingresos`
  MODIFY `id_tipo_ingreso` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;


-- Es donde se declaran las llaves foraneas
ALTER TABLE `cuenta_monetaria`
  ADD CONSTRAINT `cuenta_monetaria_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`id_cuenta`) REFERENCES `cuenta_monetaria` (`id_cuenta`);

ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_1` FOREIGN KEY (`id_cuenta`) REFERENCES `cuenta_monetaria` (`id_cuenta`);

ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `personas`
  ADD CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`id_tipo_gasto`) REFERENCES `tipos_gastos` (`id_tipo_gasto`);

ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `tipos_gastos`
  ADD CONSTRAINT `tipos_gastos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `tipos_ingresos`
  ADD CONSTRAINT `tipos_ingresos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

COMMIT;
