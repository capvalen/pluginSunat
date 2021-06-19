<?php 

include "conexion.php";
include '../generales.php';


/* $comprobantes = json_decode(file_get_contents('php://input')); 
var_dump($comprobantes); */

$current_dir = dirname(__FILE__);
//echo $current_dir;
$directorio="../comprobantes/";
//$path = realpath( $current_dir . '/../comprobantes/' );
$path = realpath( $current_dir . '/'.$directorio );
//echo "Estamos en ". $path;

$_POST = json_decode(file_get_contents('php://input'),true); 
//var_dump($_POST['comprobantes']);

$lineaDetalle='';
foreach ($_POST['comprobantes'] as $comprobante) {
	$sqlCabecera="SELECT * from `fact_cabecera` WHERE `idComprobante` like {$comprobante}; ";
	$resultadoCabecera=$cadena->query($sqlCabecera);
	while($rowCabecera=$resultadoCabecera->fetch_assoc()){

		/* ***************  CABECERA ****************** */
		
		$caso = "-0{$rowCabecera['factTipoDocumento']}-"; // 01 para factura, 03 para boleta
		$serie = $rowCabecera['factSerie'];
		$correlativo = $rowCabecera['factCorrelativo'];
		$tipoDoc = $rowCabecera['tipDocUsuario'];
		$factura =  $serie.'-'.$correlativo;
		$nombreArchivo = $rucEmisor.$caso.$factura ;

		$descuento = $rowCabecera['sumDescTotal'];
		$costo= str_replace (',', '',number_format($rowCabecera['costoFinal'] ,2));
		$igvFin = str_replace (',', '',number_format($rowCabecera['IGVFinal'],2));
		$totFin = str_replace (',', '',number_format($rowCabecera['totalFinal'],2));
		
		$lineaCabeza = $rowCabecera['tipOperacion'].$separador.$rowCabecera['fechaEmision'].$separador.$rowCabecera['horaEmision'].$separador.$rowCabecera['fechaVencimiento'].$separador. $domicilioFiscal.$separador. $tipoDoc.$separador.$rowCabecera['dniRUC'].$separador.$rowCabecera['razonSocial']. $separador.$rowCabecera['tipoMoneda'].$separador. $igvFin.$separador. $costo.$separador. $totFin . $separador. $descuento.$separador. $sumaCargos.$separador.$anticipos. $separador. $totFin.$separador.$versionUbl.$separador. $customizacion.$separador;
		

		
		$archivo = fopen("{$path}/{$nombreArchivo}.cab", "w");
		fwrite($archivo, "{$lineaCabeza}");
		fclose($archivo);


		$tributo = $rowCabecera['ideTributo'] . $separador . $rowCabecera['nomTributo'] . $separador .  $rowCabecera['codTipTributo']  . $separador . $rowCabecera['mtoBaseImponible'] . $separador . $rowCabecera['mtoTributo'] . $separador;
			if( $rowCabecera['factExonerados'] >0){
				$tributo = $tributo . "\n9997|EXO|VAT|".round($exonerados,2)."|0.00|";
			}

			$fTributo = fopen("{$path}/{$nombreArchivo}.tri", "w");
			fwrite($fTributo, "{$tributo}");
			fclose($fTributo);

		/* ************ FIN DE CABECERA *************** */

		/* ************ INICIO DE BAJAS *************** */
		if( $rowCabecera['comprobanteEmitido']=='2'){
			$_POST['boleta'] = $rowCabecera['factTipoDocumento'];
			$_POST['id'] = $comprobante;
			$_POST['concepto'] = $rowCabecera['motivoBaja'];
			require ('darBajas2.php');
		}
		/* ************ FIN DE BAJAS *************** */
		
		}

		/* ************ INICIO DE DETALLE *************** */

		$bolsas = '|-|0|0||';
		$i=1;
		$sqlDetallles="SELECT fd.*, u.undCorto, codLeyenda, desLeyenda FROM `fact_detalle` fd inner join unidades u on u.undSunat = codUnidadMedida
		inner join fact_cabecera fc on concat(fc.factSerie, '-', fc.factCorrelativo) = fd.facSerieCorre
		where fc.idComprobante = {$comprobante};";
		$resultadoDetallles=$esclavo->query($sqlDetallles);
		while($rowDetallles=$resultadoDetallles->fetch_assoc()){ 
			/* ***************  DETALLES ****************** */
			$unidad = $rowDetallles['codUnidadMedida'];

			$valorFin = str_replace (',', '',number_format($rowDetallles['valorUnitario'],2));
			$igvSubFin = str_replace (',', '',number_format($rowDetallles['igvUnitario'],2));
			$valorSubFin = str_replace (',', '',number_format($rowDetallles['valorItem'],2));
			$precProducto = round($rowDetallles['valorUnitario']+$rowDetallles['igvUnitario'],2);
			$letras = $rowDetallles['desLeyenda'];

			
			if( $rowDetallles['idGravado']=='1' ){
				$lineaDetalle =  $lineaDetalle . $unidad.$separador.$rowDetallles['cantidadItem']. $separador.$i.$separador. $rowDetallles['codProductoSUNAT'].$separador.$rowDetallles['descripcionItem'].$separador. $valorFin. $separador. round($igvSubFin*$rowDetallles['cantidadItem'],2) .$separador. $rowDetallles['codTriIGV'] .$separador. $rowDetallles['mtoIgvItem'].$separador. $valorSubFin.$separador. $rowDetallles['nomTributoIgvItem'].$separador. $rowDetallles['codTipTributoIgvItem'] .$separador.$rowDetallles['tipAfeIGV']. $separador. $rowDetallles['porIgvItem'] .$separador. $rowDetallles['codTriISC'] . $separador. $rowDetallles['mtoIscItem'] . $separador. $rowDetallles['mtoBaseIscItem'] . $separador. $rowDetallles['nomTributoIscItem'] .$separador . $rowDetallles['codTipTributoIscItem'] .$separador . $rowDetallles['tipSisISC'] .$separador. $rowDetallles['porIscItem']. $separador. $rowDetallles['codTriOtroItem']. $separador. $tributoOtro .$separador. $tributoOtroItem .$separador.$baseOtroItem .$separador.$rowDetallles['codTipTributoIOtroItem'] . $separador. $rowDetallles['porTriOtroItem'] .$separador. $bolsas.$separador. round($rowDetallles['mtoPrecioVenta']/$rowDetallles['cantidadItem'],2) . $separador. $rowDetallles['mtoValorVenta']. $separador. $rowDetallles['mtoValorReferencialUnitario']. $separador."\n";
			}else{
				$lineaDetalle =  $lineaDetalle . $unidad.$separador.$rowDetallles['cantidadItem']. $separador.$i.$separador. $rowDetallles['codProductoSUNAT'].$separador.$rowDetallles['descripcionItem'].$separador. $valorFin. $separador. "0.00" .$separador. $rowDetallles['codTriIGV'] .$separador. $rowDetallles['mtoIgvItem'].$separador. $valorSubFin .$separador. $rowDetallles['nomTributoIgvItem'].$separador. $rowDetallles['codTipTributoIgvItem'] .$separador.$rowDetallles['tipAfeIGV']. $separador. $rowDetallles['porIgvItem'] .$separador. $rowDetallles['codTriISC'] . $separador. $rowDetallles['mtoIscItem'] . $separador. $rowDetallles['mtoBaseIscItem'] . $separador. $rowDetallles['nomTributoIscItem'] .$separador . $rowDetallles['codTipTributoIscItem'] .$separador . $rowDetallles['tipSisISC'] .$separador. $rowDetallles['porIscItem']. $separador. $rowDetallles['codTriOtroItem']. $separador. $tributoOtro .$separador. $tributoOtroItem .$separador.$baseOtroItem .$separador.$rowDetallles['codTipTributoIOtroItem'] . $separador. $rowDetallles['porTriOtroItem'] .$separador. $bolsas.$separador. $precProducto . $separador. $rowDetallles['valorItem']. $separador. $rowDetallles['mtoValorReferencialUnitario']. $separador."\n";
				
			}
			//echo $lineaDetalle;

			$detalle = fopen("{$path}/{$nombreArchivo}.det", "w");
			fwrite($detalle, "{$lineaDetalle}");
			fclose($detalle);

			$leyenda = $rowDetallles['codLeyenda'].$separador. $letras .$separador;

			$fLeyenda = fopen("{$path}/{$nombreArchivo}.ley", "w");
			fwrite($fLeyenda, "{$leyenda}");
			fclose($fLeyenda);

		/* ************ FIN DE DETALLES *************** */
		$i++;
	}
}



$zip = new ZipArchive();
$baseZip = "datosSunat.zip";
$nombreArchivoZip = $path . "/". $baseZip;
//echo $nombreArchivoZip;
if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
	exit("Error abriendo ZIP en $nombreArchivoZip");
}

/* $rutaAbsoluta = __DIR__ . "/../compras.php";
$nombre = basename($rutaAbsoluta);
$zip->addFile($rutaAbsoluta, $nombre); */






$thefolder = $directorio;
if ($handler = opendir($thefolder)) {
	while (false !== ($file = readdir($handler))) {
		if( $file !='.' && $file !='..' && $file!=$baseZip){
			$rutaAbsoluta = "$path/$file";
			if( file_exists($rutaAbsoluta)){ $zip->addFile($rutaAbsoluta, basename($rutaAbsoluta));}
		}
	}
	closedir($handler);
}


$resultado = $zip->close();
if ($resultado) {
    echo "Archivo Zip creado";
} else {
    echo "Error creando archivo";
}

?>