INSERT INTO `configuracion` (`idConf`, `confVariable`, `confValor`) VALUES (NULL, 'igvGlobal', '10'), (NULL, 'ticket', 'automatico');
ALTER TABLE `fact_cabecera` ADD `descuentos` FLOAT NOT NULL DEFAULT '0' AFTER `adelanto`; 
ALTER TABLE `fact_cabecera` CHANGE `osbervaciones` `observaciones` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL; 