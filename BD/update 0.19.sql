ALTER TABLE `fact_cabecera` ADD `serieBaja` VARCHAR(250) NOT NULL AFTER `fechaBaja`;













/* 0.19  */
ALTER TABLE `fact_cabecera` CHANGE `comprobanteEmitido` `comprobanteEmitido` INT(11) NULL DEFAULT '0' COMMENT '1 emitido, 0 sin emitir/2 baja';
ALTER TABLE `fact_cabecera` ADD `motivoBaja` VARCHAR(250) NOT NULL AFTER `factPlaca`, ADD `fechaBaja` DATE NOT NULL AFTER `motivoBaja`;


ALTER TABLE `fact_cabecera` ADD `factExonerados` FLOAT NOT NULL DEFAULT '0' AFTER `tipoMoneda`;
ALTER TABLE `fact_detalle` ADD `idGravado` INT NOT NULL DEFAULT '1' AFTER `fechaEmision`;
ALTER TABLE `fact_detalle` ADD `valorExonerado` INT NOT NULL DEFAULT '0' AFTER `valorUnitario`;