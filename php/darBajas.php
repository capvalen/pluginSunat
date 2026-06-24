<?php
date_default_timezone_set('America/Lima');
include __DIR__. "/../generales.php";
include __DIR__ . "/conexion.php";

$lineaBaja ='';


$sqlNum="SELECT LPAD(count(idComprobante)+1,3,0) as contBajas
FROM `fact_cabecera`
where factTipoDocumento = {$_POST['boleta']} and comprobanteEmitido = 2";
$resultadoNum=$cadena->query($sqlNum);
$rowNum=$resultadoNum->fetch_assoc();
//echo $rowNum['contBajas'];




if( $_POST['boleta']=="1" ){ //Bajas para facturas

	$sqlC="SELECT concat(`factSerie`,'-', `factCorrelativo`) as facCorre, `fechaEmision` FROM `fact_cabecera` WHERE `idComprobante`={$_POST['id']}";
	$resultadoC=$cadena->query($sqlC);
	$rowC=$resultadoC->fetch_assoc();

	//echo $nombreArchivo;
	if( $generarArchivo ){
		$nombreArchivo = $rucEmisor."-RA-".date('Ymd')."-001"; //.$rowNum['contBajas']
	
		$lineaBaja = $lineaBaja . $rowC['fechaEmision']. "|".date('Y-m-d')."|01|".$rowC['facCorre']."|".strtoupper($_POST['concepto'])."|";
		$baja = fopen("{$directorio}{$nombreArchivo}.cba", "w");
		fwrite($baja, "{$lineaBaja}");
		fclose($baja);
	}
	
$cadena->query("UPDATE `fact_cabecera` SET `notificadoBaja` = 1 WHERE `idComprobante` = {$_POST['id']}");
		echo "ok";
}

if( $_POST['boleta']=="3" ){ //Bajas para boletas

	$sqlC="SELECT concat(`factSerie`,'-', `factCorrelativo`) as facCorre, `fechaEmision`, tipDocUsuario, dniRUC, costoFinal, IGVFinal, totalFinal FROM `fact_cabecera` WHERE `idComprobante`={$_POST['id']}";
	$resultadoC=$cadena->query($sqlC);
	$rowC=$resultadoC->fetch_assoc();

	/* $lineaBaja = $lineaBaja . $rowC['fechaEmision']. "|". date('Y-m-d') ."|03|".$rowC['facCorre']."|".$rowC['tipDocUsuario']."|".$rowC['dniRUC']."|PEN|".$rowC['costoFinal']."|0|0|0|0|0|". $rowC['totalFinal']."|||||||||3|"; */
	//echo $nombreArchivo;
	
	if( $generarArchivo ){
		$nombreArchivo = $rucEmisor."-RA-".date('Ymd')."-001"; //.$rowNum['contBajas']
		$lineaBaja = $lineaBaja . $rowC['fechaEmision']. "|".date('Y-m-d')."|03|".$rowC['facCorre']."|BAJA DE BOLETA|";

		$baja = fopen("{$directorio}{$nombreArchivo}.cba", "w");
		fwrite($baja, "{$lineaBaja}");
		fclose($baja);
	}
	
/* 	$lineaTributo = '1|1000|IGV|VAT|'.$rowC['costoFinal'].'|'.$rowC['IGVFinal'].'|';
	$tributo = fopen("{$directorio}{$nombreArchivo}.TRD", "w");
	fwrite($tributo, "{$lineaTributo}");
	fclose($tributo); */
	

	
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
}

?>