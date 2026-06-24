-- 1.26
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.26');
ALTER TABLE `fact_cabecera` ADD `notificadoBaja` INT(1) NOT NULL DEFAULT '0' COMMENT '0=no notificado, 1=notificado' AFTER `observaciones`;
ALTER TABLE `facturador` CHANGE `estado` `estado` INT(11) NOT NULL DEFAULT '0' COMMENT '0,1 falta enviar, 2 baja por enviar, 3 enviado, 4 baja enviada';

-- 1.25
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.25');


-- 1.24
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'version', '1.24');
ALTER TABLE `compras_detalle`
  ADD `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

ALTER TABLE `compras_detalle`
  ADD `editado` datetime DEFAULT NULL COMMENT 'ultima edicion' AFTER `idUnidad`;

ALTER TABLE `compras`
  ADD `editado` datetime DEFAULT NULL COMMENT 'ultima edicion' AFTER `compTotal`;



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
