INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'decimalesSuper', '6');
ALTER TABLE `fact_detalle` ADD `serie` VARCHAR(250) NULL DEFAULT NULL AFTER `idProducto`;
CREATE TABLE `fechasCreditos` (`idFecha` INT NOT NULL AUTO_INCREMENT , `idCabecera` INT NOT NULL , `fecha` DATE NOT NULL , `activo` INT NULL DEFAULT '1' , PRIMARY KEY (`idFecha`));
ALTER TABLE `fact_cabecera` CHANGE `serieBaja` `serieBaja` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '';