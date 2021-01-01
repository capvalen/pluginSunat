ALTER TABLE `productos` ADD `codeSunat` VARCHAR(10) NOT NULL DEFAULT '' AFTER `prodStock`;
CREATE TABLE `consorcio`.`configuracion` ( `idConf` INT NOT NULL AUTO_INCREMENT , `confVariable` VARCHAR(100) NOT NULL , `confValor` VARCHAR(100) NOT NULL , PRIMARY KEY (`idConf`)) ENGINE = InnoDB;
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'facCambiarUnidad', '0'), (NULL, 'facCambiarGravado', '0');
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'precioLibre', '1'), (NULL, 'precioPublico', '0'), (NULL, 'precioMayorista', '0'), (NULL, 'precioDescuento', '0');
INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'limiteFacurado', '500');
