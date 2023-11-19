CREATE TABLE `fact_credito` (`id` INT NOT NULL AUTO_INCREMENT , `idFactura` INT NOT NULL , `fecha` DATE NOT NULL , `credito` FLOAT NOT NULL , `registro` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `clientes` CHANGE `cliComercial` `cliComercial` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `clientes` CHANGE `cliTelefono` `cliTelefono` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `clientes` CHANGE `cliDomicilio` `cliDomicilio` VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
ALTER TABLE `fact_credito` CHANGE `registro` `registro` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;
