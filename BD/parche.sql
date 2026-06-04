-- 1.23
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.23');
UPDATE `unidades` set undDescipcion = 'Servicio', undSunat ='ZZ', undCorto='-' where idUnidad=11;
UPDATE `unidades` SET `undCorto` = 'PK' WHERE `unidades`.`idUnidad` = 7; 

--1.16
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.21');
INSERT INTO `usuario` (`idUsuario`, `usuNombres`, `usuApellido`, `usuNick`, `usuPass`, `token`, `usuPoder`, `usuActivo`) VALUES (NULL, 'operario', 'operario', 'operario', '', '', '3', b'1');

--1.15
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.15');
ALTER TABLE `facturador` CHANGE `estado` `estado` INT(11) NOT NULL DEFAULT '1' COMMENT '1 falta enviar, 3 enviado';

--1.14
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.14');
ALTER TABLE `fact_cabecera` CHANGE `factTipoDocumento` `factTipoDocumento` INT(11) NULL DEFAULT '0' COMMENT 'B(3),F(1),NC(4),ND(5)';

DELIMITER //
DROP TRIGGER IF EXISTS `registroFacturacion`//
CREATE TRIGGER `registroFacturacion` AFTER INSERT ON `fact_cabecera`
FOR EACH ROW
BEGIN
    IF (NEW.factTipoDocumento = 1 OR NEW.factTipoDocumento = 3) THEN
        INSERT INTO `facturador`(`idFacturador`, `idComprobante`)
        VALUES (NULL, NEW.idComprobante);
    END IF;
END//
DELIMITER ;



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
