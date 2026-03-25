--1.11
ALTER TABLE `usuario` ADD `token` VARCHAR(250) NOT NULL AFTER `usuPass`;
CREATE TABLE `bajas` (`id` INT NOT NULL AUTO_INCREMENT , `idComprobante` INT NOT NULL , `fecha` DATE NOT NULL , `motivo` VARCHAR(250) NOT NULL , `tipoDocumento` INT NOT NULL , `estado` INT NOT NULL DEFAULT '0' COMMENT '0=no enviado, 1=enviado' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
CREATE TRIGGER `darBaja` AFTER UPDATE ON `fact_cabecera`
 FOR EACH ROW BEGIN
IF NEW.comprobanteEmitido = 2 THEN
    INSERT INTO bajas (idComprobante, fecha, motivo, tipoDocumento)
    VALUES (NEW.idComprobante, NEW.fechaBaja, NEW.motivoBaja, NEW.factTipoDocumento);
END IF;
    
END;

ALTER TABLE `bajas` ADD `bloque` VARCHAR(250) NULL DEFAULT NULL AFTER `estado`, ADD `fechaEnvio` DATE NULL DEFAULT NULL AFTER `bloque`;
ALTER TABLE `bajas` CHANGE `fechaEnvio` `fechaEnvio` DATE NULL DEFAULT NULL AFTER `estado`;