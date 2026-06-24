<?php
date_default_timezone_set('America/Lima');
include __DIR__. "/../generales.php";
include __DIR__ . "/conexion.php";

	
	$sql="INSERT INTO `fact_cabecera` (
		`idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, `factSerie`, `factCorrelativo`,
		`tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`,
		`tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `factExonerados`, `costoFinal`,
		`IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`,
		`sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`,
		`codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`,
		`comprobanteEmitido`, `comprobanteFechado`, `cliDireccion`, `factPlaca`,
		`motivoBaja`, `fechaBaja`, `serieBaja`, `esContado`, `observaciones`, `adelanto`, `descuentos`
	)
	SELECT
		`idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, `factSerie`, `factCorrelativo`,
		`tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`,
		`tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `factExonerados`, `costoFinal`,
		`IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`,
		`sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`,
		`codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`,
		2, `comprobanteFechado`, `cliDireccion`, `factPlaca`,
		'{$_POST['concepto']}', NOW(), `serieBaja`, `esContado`, `observaciones`, `adelanto`, `descuentos`
	FROM `fact_cabecera`
	WHERE `idComprobante` = {$_POST['id']}";
	$resultado=$cadena->query($sql);
	
	$nuevoId = $cadena->insert_id;
	
	$sqlDetalle="INSERT INTO `fact_detalle` (
		`idNegocio`, `idCabecera`, `idLocal`, `idTicket`, `facSerieCorre`, `codUnidadMedida`,
		`cantidadItem`, `codProductoSUNAT`, `codProducto`, `descripcionItem`, `valorUnitario`,
		`valorExonerado`, `igvUnitario`, `codTriIGV`, `mtoIgvItem`, `valorItem`,
		`nomTributoIgvItem`, `codTipTributoIgvItem`, `tipAfeIGV`, `porIgvItem`, `codTriISC`,
		`mtoIscItem`, `mtoBaseIscItem`, `nomTributoIscItem`, `codTipTributoIscItem`, `tipSisISC`,
		`porIscItem`, `codTriOtroItem`, `mtoTriOtroItem`, `mtoBaseTriOtroItem`, `nomTributoIOtroItem`,
		`codTipTributoIOtroItem`, `porTriOtroItem`, `mtoPrecioVenta`, `mtoValorVenta`,
		`mtoValorReferencialUnitario`, `fechaEmision`, `idGravado`, `idProducto`, `serie`
	)
	SELECT
		`idNegocio`, {$nuevoId}, `idLocal`, `idTicket`, `facSerieCorre`, `codUnidadMedida`,
		`cantidadItem`, `codProductoSUNAT`, `codProducto`, `descripcionItem`, `valorUnitario`,
		`valorExonerado`, `igvUnitario`, `codTriIGV`, `mtoIgvItem`, `valorItem`,
		`nomTributoIgvItem`, `codTipTributoIgvItem`, `tipAfeIGV`, `porIgvItem`, `codTriISC`,
		`mtoIscItem`, `mtoBaseIscItem`, `nomTributoIscItem`, `codTipTributoIscItem`, `tipSisISC`,
		`porIscItem`, `codTriOtroItem`, `mtoTriOtroItem`, `mtoBaseTriOtroItem`, `nomTributoIOtroItem`,
		`codTipTributoIOtroItem`, `porTriOtroItem`, `mtoPrecioVenta`, `mtoValorVenta`,
		`mtoValorReferencialUnitario`, `fechaEmision`, `idGravado`, `idProducto`, `serie`
	FROM `fact_detalle`
	WHERE `idCabecera` = {$_POST['id']}";
	$resultadoDetalle=$cadena->query($sqlDetalle);
	
	$cadena->query("UPDATE `fact_cabecera` SET `notificadoBaja` = 1 WHERE `idComprobante` = {$_POST['id']}");
	echo "ok";

?>