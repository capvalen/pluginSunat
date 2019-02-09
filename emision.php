<?php

include 'conexion.php';
include 'generales.php';


$factura = $_POST['factura'];

$caso = "-0{$_POST['emitir']}-"; // 01 para factura, 03 para boleta

$nombreArchivo = $rucEmisor.$caso.$factura ;

$sqlCabeza="SELECT `codFactura`, `fechaEmision`, `horaEmision`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal` FROM `fact_cabecera` where codFactura = '{$factura}';";
$resultadoCabeza=$cadena->query($sqlCabeza);
$filasCabeza = $resultadoCabeza->num_rows;
if($filasCabeza==1){
	$rowC=$resultadoCabeza->fetch_assoc();

	if(strlen($rowC['dniRUC'])==11){
		$tipoDoc = '6';
	}else if(strlen($rowC['dniRUC'])==8){
		$tipoDoc = '1';
	}else if(strlen($rowC['dniRUC'])==0){
		$tipoDoc = '0';
	}
	$costo= str_replace (',', '',number_format($rowC['costoFinal'],2));
	$igvFin = str_replace (',', '',number_format($rowC['IGVFinal'],2));
	$totFin = str_replace (',', '',number_format($rowC['totalFinal'],2));
	
	$lineaCabeza = $tipoOperacion.$separador.$rowC['fechaEmision'].$separador.$rowC['horaEmision'].$separador.$fechaVencimiento.$separador.$domicilioFiscal.$separador.$tipoDoc.$separador.$rowC['dniRUC'].$separador.$rowC['razonSocial'].$separador.$rowC['tipoMoneda'].$separador. $costo.$separador. $igvFin.$separador. $totFin . $separador.$descuento.$separador.$sumaCargos.$separador.$anticipos. $separador. $totFin.$separador.$versionUbl.$separador. $customizacion.$separador;

	$archivo = fopen("{$directorio}{$nombreArchivo}.cab", "w");
	fwrite($archivo, "{$lineaCabeza}");
	fclose($archivo);

}

$i=1;
$sqlDetalle="SELECT `codFactura`, upper(`unidadMedida`) as `unidadMedida`, `cantidad`, `descripcionProducto`, `valorUnitario`, `igvUnitario`, `valorProducto` FROM `fact_detalle` WHERE codFactura = '{$factura}';";
$resultadoDetalle=$cadena->query($sqlDetalle);
while($rowD=$resultadoDetalle->fetch_assoc()){ 

	switch ($rowD['unidadMedida']) {
		case 'UNIDAD': $unidad = 'NIU'; break;
		case 'CAJA': $unidad = 'BX'; break;
		case 'BOLSA': $unidad = 'BG'; break;
		default: $unidad =''; break;
	}
	
	$valorFin = str_replace (',', '',number_format($rowD['valorUnitario'],2));
	$igvSubFin = str_replace (',', '',number_format($rowD['igvUnitario'],2));
	$valorSubFin = str_replace (',', '',number_format($rowD['valorProducto'],2));

	$lineaDetalle = $unidad.$separador.$rowD['cantidad'].$separador.$i.$separador.$codSunat.$separador.$rowD['descripcionProducto'].$separador. $valorFin.$separador. $igvSubFin.$separador.$tipoTributo.$separador. $igvSubFin.$separador. $valorSubFin.$separador.$nombreTributo.$separador.$tributoExtranjero.$separador.$afectacion.$separador. $porcentajeIGV.$separador.$tributoISC.$separador.$codigoISC.$separador.$montoISC.$separador.$baseISC.$separador.$nombreISC.$separador.$codeISC.$separador. $porcentajeISC. $separador.$tributo99.$separador.$tributoOtro.$separador.$tributoOtroItem.$separador.$baseOtroItem.$separador.$codigoOtroItem. $separador.$porcentajeOtroItem.$separador.$invoce.$separador. $valorVentaInvoce.$separador.$gratuito.$separador;

	
	$i++;

	
}

$detalle = fopen("{$directorio}{$nombreArchivo}.det", "w");
fwrite($detalle, "{$lineaDetalle}");
fclose($detalle);

echo "fin";

?>