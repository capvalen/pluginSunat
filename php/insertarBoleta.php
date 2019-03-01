<?php 
date_default_timezone_set('America/Lima');
include '../conexion.php';
include '../generales.php';
require "../NumeroALetras.php";

if(isset($_POST['jsonCliente'])){

	$sqlCli="INSERT INTO clientes (cliRuc, cliRazonSocial, cliDomicilio, cliActivo)
	SELECT * FROM (SELECT '{$_POST['jsonCliente'][0]['dni']}', '{$_POST['jsonCliente'][0]['razon']}', '{$_POST['jsonCliente'][0]['direccion']}',1) AS tmp
	WHERE NOT EXISTS (
			SELECT cliRuc FROM clientes WHERE cliRuc = '{$_POST['jsonCliente'][0]['dni']}'
	) LIMIT 1;";
	$cadena->query($sqlCli);

}

$caso = "-0{$_POST['emitir']}-"; // 01 para factura, 03 para boleta

switch ($_POST['emitir']) {
	case '1': $soy="FACTURA"; break;
	case '3': $soy="BOLETA"; break;
	default: # code... break;
}
$serie = $_POST['queSerie'];


$productos= $_POST['jsonProductos'];
$sumaTotal =0;
for ($i=0; $i <=1 ; $i++) { 
	$sumaTotal = $sumaTotal + ( $productos[$i]['cantidad']*$productos[$i]['precioProducto'] );
}
$sumaTotal = round($sumaTotal,2);
$baseTotal = round($sumaTotal/1.18,2);
$igvTotal = round($sumaTotal-$baseTotal,2);


$parteEntera = intval($sumaTotal);
$parteDecimal = round(($sumaTotal-$parteEntera)*100,0);

//Pedir las letras del monto facturado
$letras = trim(NumeroALetras::convertir($parteEntera)).' SOLES '.$parteDecimal.'/100 MN';

$sqlCorrelativo="SELECT LPAD(factCorrelativo+1, 8, '0') as contador  FROM `fact_cabecera` where factSerie = '{$serie}' order by factCorrelativo desc limit 1";
$resultadoCorrelativo=$cadena->query($sqlCorrelativo);
$filasCorrelativo = $resultadoCorrelativo->num_rows;
if($filasCorrelativo==0){
	$correlativo='00000001';
}else{
	$rowCorrelativo=$resultadoCorrelativo->fetch_assoc(); 
	$correlativo = $rowCorrelativo['contador'];
}


$factura =  $serie.'-'.$correlativo;

$nombreArchivo = $rucEmisor.$caso.$factura ;

if(strlen($_POST['dniRUC'])==11){
	$tipoDoc = '6';
}else if(strlen($_POST['dniRUC'])==8){
	$tipoDoc = '1';
}else if(strlen($_POST['dniRUC'])<8){
	$tipoDoc = '0';
}

$sql="INSERT INTO `fact_cabecera`(`idComprobante`, `factTipoDocumento`, `factSerie`, `factCorrelativo`, `fechaEmision`, `horaEmision`, `tipDocUsuario`,
 `dniRUC`, `razonSocial`,
 `costoFinal`, `IGVFinal`, `totalFinal`,`sumImpVenta`, `mtoBaseImponible`, `mtoTributo`, `desLeyenda`,
  `comprobanteEmitido`, `comprobanteFechado`, `cliDireccion`, `factPlaca`) 
VALUES (null,{$_POST['emitir']},'{$serie}','{$correlativo}',curdate(),curtime(),{$tipoDoc},
	'{$_POST['dniRUC']}', '{$_POST['razonSocial']}',
	{$baseTotal}, {$igvTotal}, {$sumaTotal}, {$sumaTotal}, {$baseTotal}, {$igvTotal}, '{$letras}',
	1,now(), '{$_POST['cliDireccion']}', '{$_POST['placa']}' )";
$resultado=$cadena->query($sql);

$sqlProd  ='';
for ($i=0; $i <=1 ; $i++) { 
	if( $productos[$i]['subtotal']<>0){
		$canti = $productos[$i]['cantidad'];
		$prec = $productos[$i]['precioProducto'];
		$subTo = round($canti*$prec,2);
		$costoUnit = round($prec/1.18,2);
		$igvUnit= round($prec-$costoUnit,2);
		$valorUnit = round($costoUnit*$canti,2);
		$igvCant=round($igvUnit*$canti,2);
		$sqlProd = "INSERT INTO `fact_detalle`(`codItem`, `facSerieCorre`, `cantidadItem`, `codProducto`, `descripcionItem`,
		`valorUnitario`, `igvUnitario`, `mtoIgvItem`, `valorItem`, `mtoPrecioVenta`, `mtoValorVenta`, `fechaEmision`) VALUES
		 (null,  concat('{$serie}','-','{$correlativo}'), {$canti}, {$i}, '{$productos[$i]['descripcionProducto']}',
		 {$costoUnit}, {$igvUnit}, {$igvCant}, {$valorUnit},{$subTo},{$valorUnit}, now());";	
		 $cadena->query($sqlProd);
	}
}


# Generando los archivos txt para sunat 
$sqlCabeza="select * from `fact_cabecera` where factSerie = '{$serie}' and factCorrelativo='{$correlativo}';";
$resultadoCabeza=$cadena->query($sqlCabeza);
$filasCabeza = $resultadoCabeza->num_rows;
if($filasCabeza==1){
	$rowC=$resultadoCabeza->fetch_assoc();

	$descuento = $rowC['sumDescTotal'];
	$costo= str_replace (',', '',number_format($rowC['costoFinal'],2));
	$igvFin = str_replace (',', '',number_format($rowC['IGVFinal'],2));
	$totFin = str_replace (',', '',number_format($rowC['totalFinal'],2));
	
	$lineaCabeza = $rowC['tipOperacion'].$separador.$rowC['fechaEmision'].$separador.$rowC['horaEmision'].$separador.$rowC['fechaVencimiento'].$separador. $domicilioFiscal.$separador. $tipoDoc.$separador.$rowC['dniRUC'].$separador.$rowC['razonSocial']. $separador.$rowC['tipoMoneda'].$separador. $costo.$separador. $igvFin.$separador. $totFin . $separador. $descuento.$separador. $sumaCargos.$separador.$anticipos. $separador. $totFin.$separador.$versionUbl.$separador. $customizacion.$separador;
	//echo $lineaCabeza;

	$archivo = fopen("{$directorio}{$nombreArchivo}.cab", "w");
	fwrite($archivo, "{$lineaCabeza}");
	fclose($archivo);
}

$rowProductos = array();

$i=1;
$lineaDetalle ='';
$sqlDetalle="SELECT * FROM `fact_detalle` WHERE `facSerieCorre` ='{$serie}-{$correlativo}';";
$resultadoDetalle=$cadena->query($sqlDetalle);
while($rowD=$resultadoDetalle->fetch_assoc()){ 

	$unidad = 'GLI';
	
	$valorFin = str_replace (',', '',number_format($rowD['valorUnitario'],2));
	$igvSubFin = str_replace (',', '',number_format($rowD['igvUnitario'],2));
	$valorSubFin = str_replace (',', '',number_format($rowD['valorItem'],2));

	$lineaDetalle =  $lineaDetalle . $unidad.$separador.$rowD['cantidadItem']. $separador.$i.$separador. $rowD['codProductoSUNAT'].$separador.$rowD['descripcionItem'].$separador. $valorFin.$separador.  $igvSubFin.$separador. $rowD['codTriIGV'] .$separador. $rowD['mtoIgvItem'].$separador. $valorSubFin.$separador. $rowD['nomTributoIgvItem'].$separador. $rowD['codTipTributoIgvItem'] .$separador.$rowD['tipAfeIGV']. $separador. $rowD['porIgvItem'] .$separador. $rowD['codTriISC'] . $separador. $rowD['mtoIscItem'] . $separador. $rowD['mtoBaseIscItem'] . $separador. $rowD['nomTributoIscItem'] .$separador . $rowD['codTipTributoIscItem'] .$separador . $rowD['tipSisISC'] .$separador. $rowD['porIscItem']. $separador. $rowD['codTriOtroItem']. $separador. $tributoOtro .$separador. $tributoOtroItem .$separador.$baseOtroItem .$separador.$rowD['codTipTributoIOtroItem'] . $separador. $rowD['porTriOtroItem'] .$separador. $rowD['mtoPrecioVenta'] . $separador. $rowD['mtoValorVenta']. $separador. $rowD['mtoValorReferencialUnitario']. $separador."\n";

	$rowProductos[$i] = array( 'cantidad'=>$rowD['cantidadItem'], 'descripcion'=> $rowD['descripcionItem'], 'precio'=> $rowD['mtoPrecioVenta'], 'costo'=> $rowD['valorUnitario'] );
	$i++;

	
}
//echo $lineaDetalle ;

$detalle = fopen("{$directorio}{$nombreArchivo}.det", "w");
fwrite($detalle, "{$lineaDetalle}");
fclose($detalle);

$leyenda = $rowC['codLeyenda'].$separador. $letras .$separador;

$fLeyenda = fopen("{$directorio}{$nombreArchivo}.ley", "w");
fwrite($fLeyenda, "{$leyenda}");
fclose($fLeyenda);



$tributo = $rowC['ideTributo'] . $separador . $rowC['nomTributo'] . $separador .  $rowC['codTipTributo']  . $separador . $rowC['mtoBaseImponible'] . $separador . $rowC['mtoTributo'] . $separador;

$fTributo = fopen("{$directorio}{$nombreArchivo}.tri", "w");
fwrite($fTributo, "{$tributo}");
fclose($fTributo);


if($_POST['placa']<>''){
	$placa = "0|-|7000|{$_POST['placa']}|0|-|-|-|-|-|0|0.00|PEN|0|PEN|0";

	$fplaca = fopen("{$directorio}{$nombreArchivo}.ade", "w");
	fwrite($fplaca, "{$placa}");
	fclose($fplaca);
}



//echo $serie."-".$correlativo."-OK";
$filas=array();
$filas = array(array ( 'rucEmisor'=> $rucEmisor, 'tipoComprobante' => $_POST['emitir'], 'serie'=> $serie , 'correlativo'=> $correlativo, 'queSoy'=> $soy, 'letras'=> $letras, 'tipoCliente'=>$tipoDoc, 'ruc'=>$rowC['dniRUC'], 'razonSocial'=>$rowC['razonSocial'], 'fechaEmision'=> $rowC['fechaEmision'], 'descuento'=> $descuento, 'costoFinal'=> $costo, 'igvFinal'=> $igvFin, "totalFinal" => $totFin, 'direccion'=> $rowC['cliDireccion'], "placa"=> $_POST['placa'] ));

array_push ( $filas, $rowProductos);

echo json_encode($filas);


?>