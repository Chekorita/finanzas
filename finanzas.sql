START TRANSACTION;
#El drop database no es tan necesario, yo lo tengo para limpieza de mi base
DROP DATABASE IF EXISTS `finanzas`;
#Creamos la base de datos
CREATE DATABASE IF NOT EXISTS `finanzas` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `finanzas`;

#Creamos las tablas
CREATE TABLE `cuenta_monetaria` (
  `id_cuenta` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la cuenta, ya sea el nombre del banco o que se diga que es el dinero de tu cartera',
  `fondo` float NOT NULL DEFAULT 0 COMMENT 'Se trata del dinero que contiene esa cuenta, se va sumando o restando según los ingresos y egresos que se registren, en caso de ser a disposición se inicializa en 0, en caso de ser de crédito, se le debe establecer el dinero inicial',
  `tipo` int(11) NOT NULL DEFAULT 1 COMMENT '1 = a disposición (como dinero físico, tarjetas de debito) estas son las que se cuentan para saber cuanto dinero dispones en el momento, 2 = Tarjetas de crédito, estas no se contabilizan para el dinero que tienes, pero si para poder manejar tus gastos de crédito',
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo, No se eliminan ya que quedaran para el registro de anteriores casos de años pasados',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que esta ligada la cuenta',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `cuenta_monetaria_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta que se esta modificando',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la cuenta, ya sea el nombre del banco o que se diga que es el dinero de tu cartera',
  `fondo` float NOT NULL COMMENT 'Se trata del dinero que contiene esa cuenta, se va sumando o restando según los ingresos y egresos que se registren, en caso de ser a disposición se inicializa en 0, en caso de ser de crédito, se le debe establecer el dinero inicial',
  `tipo` int(11) NOT NULL COMMENT '1 = a disposición (como dinero físico, tarjetas de debito) estas son las que se cuentan para saber cuanto dinero dispones en el momento, 2 = Tarjetas de crédito, estas no se contabilizan para el dinero que tienes, pero si para poder manejar tus gastos de crédito',
  `estado` int(11) NOT NULL COMMENT '1 = Activo, 2 = Inactivo, No se eliminan ya que quedaran para el registro de anteriores casos de años pasados',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que esta ligada la cuenta',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `gastos` (
  `id_gasto` int(11) NOT NULL,
  `monto` float NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona a la que se le esta haciendo el gasto en caso de ser necesario',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta desde la que se están gastando sus fondos',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que realizo el gasto',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `gastos_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_gasto` int(11) NOT NULL COMMENT 'Es el ID del gasto que se esta modificando',
  `monto` float NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT NULL COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona a la que se le esta haciendo el gasto en caso de ser necesario',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta desde la que se están gastando sus fondos',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que realizo el gasto',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ingresos` (
  `id_ingreso` int(11) NOT NULL,
  `monto` float NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT '' COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_ingreso` int(11) NOT NULL COMMENT 'ID del tipo de ingreso que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona registrada que te hizo el ingreso, eso en caso de que sea necesaria',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta a la que se esta haciendo el ingreso',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que realizo el ingreso',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `ingresos_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_ingreso` int(11) NOT NULL COMMENT 'Es el ID del ingreso que se esta modificando',
  `monto` float NOT NULL COMMENT 'Es el monto de dinero que estas ingresando',
  `descripcion` varchar(255) DEFAULT '' COMMENT 'Una descripción opcional por si quieres ser mas detallado',
  `id_tipo_ingreso` int(11) NOT NULL COMMENT 'ID del tipo de ingreso que se esta teniendo, en caso de ser 0, significa que es de otro que no esta catalogado',
  `id_persona` int(11) NOT NULL DEFAULT 0 COMMENT 'Es el ID de la persona registrada que te hizo el ingreso, eso en caso de que sea necesaria',
  `id_cuenta` int(11) NOT NULL COMMENT 'Es el ID de la cuenta a la que se esta haciendo el ingreso',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que realizo el ingreso',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre real de la persona',
  `apodo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Solo un apodo para poder reconocerla mejor',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID de usuario al que esta ligada la persona',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `personas_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL COMMENT 'Es el ID de la persona que se esta modificando',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre real de la persona',
  `apodo` varchar(255) NOT NULL DEFAULT '' COMMENT 'Solo un apodo para poder reconocerla mejor',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID de usuario al que esta ligada la persona',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del presupuesto',
  `monto` float NOT NULL COMMENT 'Dinero con el que se cuenta para este presupuesto, no puede exceder el ingreso mensual',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que seria para este presupuesto',
  `estado` int(11) NOT NULL COMMENT '1 = Activo, 2= Inactivo',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que genero este presupuesto',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `presupuestos_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_presupuesto` int(11) NOT NULL COMMENT 'Es el ID del presupuesto que se esta modificando',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del presupuesto',
  `monto` float NOT NULL COMMENT 'Dinero con el que se cuenta para este presupuesto, no puede exceder el ingreso mensual',
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'ID del tipo de gasto que seria para este presupuesto',
  `estado` int(11) NOT NULL COMMENT '1 = Activo, 2= Inactivo',
  `id_usuario` int(11) NOT NULL COMMENT 'ID del usuario que genero este presupuesto',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
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

CREATE TABLE `tipos_gastos_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_tipo_gasto` int(11) NOT NULL COMMENT 'Es el ID del tipo de gasto que se esta modificando',
  `nombre` varchar(255) NOT NULL DEFAULT '' COMMENT 'Es el nombre del tipo de gasto, como transferencia, chucherías, etc., son las categorías de gastos que puedes tener',
  `tipo` int(11) NOT NULL COMMENT '1 = para los de disposición, estos se toman para restar a los montos de cuentas, 2 = crédito, esto descuenta el monto disponible pero sin contar como un gasto real de tu dinero actual',
  `requiere_persona` int(11) NOT NULL COMMENT '1 = Si, con esto hace que se desplieguen las personas y o empresas fijas que hayas registrado, así se despliegan para mantener una mejor control, por ejemplo para las transferencias, 2= No, es una tipo de gasto que no se puede registrar para una persona',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que tiene este tipo de gasto',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `tipos_ingresos` (
  `id_tipo_ingreso` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de ingreso, puede ser tu paga de trabajo, transferencia, pago a tarjeta de crédito, etc.',
  `tipo` int(11) NOT NULL COMMENT '1 = de los de disposición, esto hará que aumente el dinero que tienes en cuentas a disposición, tu dinero real, 2 = es el pago que haces a tus cuentas de crédito',
  `requiere_persona` int(11) NOT NULL COMMENT '1 = Si, con esto hace que se desplieguen las personas y o empresas fijas que hayas registrado, así se despliegan para mantener una mejor control, por ejemplo para las transferencias, 2= No, es una tipo de gasto que no se puede registrar para una persona',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que se le va a ligar este tipo de ingreso',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `tipos_ingresos_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_tipo_ingreso` int(11) NOT NULL COMMENT 'Es el ID del tipo de ingreso que se esta modificando',
  `nombre` varchar(255) NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de ingreso, puede ser tu paga de trabajo, transferencia, pago a tarjeta de crédito, etc.',
  `tipo` int(11) NOT NULL COMMENT '1 = de los de disposición, esto hará que aumente el dinero que tienes en cuentas a disposición, tu dinero real, 2 = es el pago que haces a tus cuentas de crédito',
  `requiere_persona` int(11) NOT NULL COMMENT '1 = Si, con esto hace que se desplieguen las personas y o empresas fijas que hayas registrado, así se despliegan para mantener una mejor control, por ejemplo para las transferencias, 2= No, es una tipo de gasto que no se puede registrar para una persona',
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario al que se le va a ligar este tipo de ingreso',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL COMMENT 'Nombre de usuario con el que se va a acceder',
  `acceso` varchar(255) NOT NULL COMMENT 'Contraseña encriptada con la que se registro',
  `random` varchar(255) NOT NULL COMMENT 'Cadena de texto con caracteres random con el cual se complementa para la contraseña de acceso',
  `paterno` varchar(255) NOT NULL COMMENT 'Apellido paterno',
  `materno` varchar(255) NOT NULL COMMENT 'Apellido materno',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del usuario',
  `ingreso_mensual` float NOT NULL DEFAULT 0 COMMENT 'Es el ingreso mensual que tiene el usuario, será usado para la creación de presupuestos, en caso de estar en 0, no se podrá hacer presupuestos',
  `estado` int(1) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo',
  `onCreate` timestamp NOT NULL DEFAULT current_timestamp(),
  `onUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `usuarios_edit` (
  `id_modificacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL COMMENT 'Es el ID del usuario que se esta modificando',
  `usuario` varchar(255) NOT NULL COMMENT 'Nombre de usuario con el que se va a acceder',
  `acceso` varchar(255) NOT NULL COMMENT 'Contraseña encriptada con la que se registro',
  `random` varchar(255) NOT NULL COMMENT 'Cadena de texto con caracteres random con el cual se complementa para la contraseña de acceso',
  `paterno` varchar(255) NOT NULL COMMENT 'Apellido paterno',
  `materno` varchar(255) NOT NULL COMMENT 'Apellido materno',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre del usuario',
  `ingreso_mensual` float NOT NULL DEFAULT 0 COMMENT 'Es el ingreso mensual que tiene el usuario, será usado para la creación de presupuestos, en caso de estar en 0, no se podrá hacer presupuestos',
  `estado` int(1) NOT NULL DEFAULT 1 COMMENT '1 = Activo, 2 = Inactivo',
  `tipo_modificacion` int(11) NOT NULL COMMENT '1 = Creación, 2 = Modificación, 3 = Eliminación',
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


#Creamos las llaves primarias
ALTER TABLE `cuenta_monetaria`
  ADD PRIMARY KEY (`id_cuenta`);

ALTER TABLE `cuenta_monetaria_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_gasto`);

ALTER TABLE `gastos_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id_ingreso`);

ALTER TABLE `ingresos_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

ALTER TABLE `personas_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`);

ALTER TABLE `presupuestos_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `tipos_gastos`
  ADD PRIMARY KEY (`id_tipo_gasto`);

ALTER TABLE `tipos_gastos_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `tipos_ingresos`
  ADD PRIMARY KEY (`id_tipo_ingreso`);

ALTER TABLE `tipos_ingresos_edit`
  ADD PRIMARY KEY (`id_modificacion`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

ALTER TABLE `usuarios_edit`
  ADD PRIMARY KEY (`id_modificacion`);


#Las llaves autoincrementables
ALTER TABLE `cuenta_monetaria`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cuenta_monetaria_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gastos`
  MODIFY `id_gasto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gastos_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ingresos`
  MODIFY `id_ingreso` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ingresos_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `personas_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `presupuestos_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_gastos`
  MODIFY `id_tipo_gasto` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_gastos_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_ingresos`
  MODIFY `id_tipo_ingreso` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipos_ingresos_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios_edit`
  MODIFY `id_modificacion` int(11) NOT NULL AUTO_INCREMENT;


#Creamos las llaves foraneas
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


#Creamos triggers para las tablas de edición
DELIMITER $$

#Triggers para las tabla cuenta_monetaria
CREATE TRIGGER `cuenta_monetaria_after_insert` AFTER INSERT ON `cuenta_monetaria`
FOR EACH ROW
BEGIN
  INSERT INTO cuenta_monetaria_edit (id_cuenta, nombre, fondo, tipo, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_cuenta, NEW.nombre, NEW.fondo, NEW.tipo, NEW.estado, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `cuenta_monetaria_after_update` AFTER UPDATE ON `cuenta_monetaria`
FOR EACH ROW
BEGIN
  INSERT INTO cuenta_monetaria_edit (id_cuenta, nombre, fondo, tipo, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_cuenta, NEW.nombre, NEW.fondo, NEW.tipo, NEW.estado, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `cuenta_monetaria_after_delete` AFTER DELETE ON `cuenta_monetaria`
FOR EACH ROW
BEGIN
  INSERT INTO cuenta_monetaria_edit (id_cuenta, nombre, fondo, tipo, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_cuenta, OLD.nombre, OLD.fondo, OLD.tipo, OLD.estado, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla gastos
CREATE TRIGGER `gastos_after_insert` AFTER INSERT ON `gastos`
FOR EACH ROW
BEGIN
  INSERT INTO gastos_edit (id_gasto, monto, descripcion, id_tipo_gasto, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_gasto, NEW.monto, NEW.descripcion, NEW.id_tipo_gasto, NEW.id_persona, NEW.id_cuenta, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `gastos_after_update` AFTER UPDATE ON `gastos`
FOR EACH ROW
BEGIN
  INSERT INTO gastos_edit (id_gasto, monto, descripcion, id_tipo_gasto, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_gasto, NEW.monto, NEW.descripcion, NEW.id_tipo_gasto, NEW.id_persona, NEW.id_cuenta, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `gastos_after_delete` AFTER DELETE ON `gastos`
FOR EACH ROW
BEGIN
  INSERT INTO gastos_edit (id_gasto, monto, descripcion, id_tipo_gasto, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_gasto, OLD.monto, OLD.descripcion, OLD.id_tipo_gasto, OLD.id_persona, OLD.id_cuenta, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla ingresos
CREATE TRIGGER `ingresos_after_insert` AFTER INSERT ON `ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO ingresos_edit (id_ingreso, monto, descripcion, id_tipo_ingreso, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_ingreso, NEW.monto, NEW.descripcion, NEW.id_tipo_ingreso, NEW.id_persona, NEW.id_cuenta, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `ingresos_after_update` AFTER UPDATE ON `ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO ingresos_edit (id_ingreso, monto, descripcion, id_tipo_ingreso, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_ingreso, NEW.monto, NEW.descripcion, NEW.id_tipo_ingreso, NEW.id_persona, NEW.id_cuenta, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `ingresos_after_delete` AFTER DELETE ON `ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO ingresos_edit (id_ingreso, monto, descripcion, id_tipo_ingreso, id_persona, id_cuenta, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_ingreso, OLD.monto, OLD.descripcion, OLD.id_tipo_ingreso, OLD.id_persona, OLD.id_cuenta, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla personas
CREATE TRIGGER `personas_after_insert` AFTER INSERT ON `personas`
FOR EACH ROW
BEGIN
  INSERT INTO personas_edit (id_persona, nombre, apodo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_persona, NEW.nombre, NEW.apodo, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `personas_after_update` AFTER UPDATE ON `personas`
FOR EACH ROW
BEGIN
  INSERT INTO personas_edit (id_persona, nombre, apodo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_persona, NEW.nombre, NEW.apodo, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `personas_after_delete` AFTER DELETE ON `personas`
FOR EACH ROW
BEGIN
  INSERT INTO personas_edit (id_persona, nombre, apodo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_persona, OLD.nombre, OLD.apodo, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla presupuestos
CREATE TRIGGER `presupuestos_after_insert` AFTER INSERT ON `presupuestos`
FOR EACH ROW
BEGIN
  INSERT INTO presupuestos_edit (id_presupuesto, nombre, monto, id_tipo_gasto, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_presupuesto, NEW.nombre, NEW.monto, NEW.id_tipo_gasto, NEW.estado, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `presupuestos_after_update` AFTER UPDATE ON `presupuestos`
FOR EACH ROW
BEGIN
  INSERT INTO presupuestos_edit (id_presupuesto, nombre, monto, id_tipo_gasto, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_presupuesto, NEW.nombre, NEW.monto, NEW.id_tipo_gasto, NEW.estado, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `presupuestos_after_delete` AFTER DELETE ON `presupuestos`
FOR EACH ROW
BEGIN
  INSERT INTO presupuestos_edit (id_presupuesto, nombre, monto, id_tipo_gasto, estado, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_presupuesto, OLD.nombre, OLD.monto, OLD.id_tipo_gasto, OLD.estado, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla tipos_gastos
CREATE TRIGGER `tipos_gastos_after_insert` AFTER INSERT ON `tipos_gastos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_gastos_edit (id_tipo_gasto, nombre, tipo, requiere_persona, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_tipo_gasto, NEW.nombre, NEW.tipo, NEW.requiere_persona, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `tipos_gastos_after_update` AFTER UPDATE ON `tipos_gastos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_gastos_edit (id_tipo_gasto, nombre, tipo, requiere_persona, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_tipo_gasto, NEW.nombre, NEW.tipo, NEW.requiere_persona, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `tipos_gastos_after_delete` AFTER DELETE ON `tipos_gastos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_gastos_edit (id_tipo_gasto, nombre, tipo, requiere_persona, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_tipo_gasto, OLD.nombre, OLD.tipo, OLD.requiere_persona, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla tipos_ingresos
CREATE TRIGGER `tipos_ingresos_after_insert` AFTER INSERT ON `tipos_ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_ingresos_edit (id_tipo_ingreso, nombre, tipo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_tipo_ingreso, NEW.nombre, NEW.tipo, NEW.id_usuario, 1, NOW());
END$$

CREATE TRIGGER `tipos_ingresos_after_update` AFTER UPDATE ON `tipos_ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_ingresos_edit (id_tipo_ingreso, nombre, tipo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_tipo_ingreso, NEW.nombre, NEW.tipo, NEW.id_usuario, 2, NOW());
END$$

CREATE TRIGGER `tipos_ingresos_after_delete` AFTER DELETE ON `tipos_ingresos`
FOR EACH ROW
BEGIN
  INSERT INTO tipos_ingresos_edit (id_tipo_ingreso, nombre, tipo, id_usuario, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_tipo_ingreso, OLD.nombre, OLD.tipo, OLD.id_usuario, 3, NOW());
END$$

#Triggers para las tabla usuarios
CREATE TRIGGER `usuarios_after_insert` AFTER INSERT ON `usuarios`
FOR EACH ROW
BEGIN
  INSERT INTO usuarios_edit (id_usuario, usuario, acceso, random, paterno, materno, nombre, ingreso_mensual, estado, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_usuario, NEW.usuario, NEW.acceso, NEW.random, NEW.paterno, NEW.materno, NEW.nombre, NEW.ingreso_mensual, NEW.estado, 1, NOW());
END$$

CREATE TRIGGER `usuarios_after_update` AFTER UPDATE ON `usuarios`
FOR EACH ROW
BEGIN
  INSERT INTO usuarios_edit (id_usuario, usuario, acceso, random, paterno, materno, nombre, ingreso_mensual, estado, tipo_modificacion, fecha_modificacion) VALUES (NEW.id_usuario, NEW.usuario, NEW.acceso, NEW.random, NEW.paterno, NEW.materno, NEW.nombre, NEW.ingreso_mensual, NEW.estado, 2, NOW());
END$$

CREATE TRIGGER `usuarios_after_delete` AFTER DELETE ON `usuarios`
FOR EACH ROW
BEGIN
  INSERT INTO usuarios_edit (id_usuario, usuario, acceso, random, paterno, materno, nombre, ingreso_mensual, estado, tipo_modificacion, fecha_modificacion) VALUES (OLD.id_usuario, OLD.usuario, OLD.acceso, OLD.random, OLD.paterno, OLD.materno, OLD.nombre, OLD.ingreso_mensual, OLD.estado, 3, NOW());
END$$

DELIMITER ;


COMMIT;
