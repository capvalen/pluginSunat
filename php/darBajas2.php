<?php
date_default_timezone_set('America/Lima');
include "conexion.php";
include "../generales.php";


$current_dir = dirname(__FILE__);
//echo $current_dir;
$directorio="../comprobantes/";
//$path = realpath( $current_dir . '/../comprobantes/' );
$path = realpath( $current_dir . '/'.$directorio );

$lineaBaja ='';

//echo "Estamos en ". $path;

$sqlNum="SELECT LPAD(count(idComprobante)+1,3,0) as contBajas
FROM `fact_cabecera`
where factTipoDocumento = {$_POST['boleta']} and comprobanteEmitido = 2";
$resultadoNum=$conf->query($sqlNum);
$rowNum=$resultadoNum->fetch_assoc();
//echo $rowNum['contBajas'];




if( $_POST['boleta']=="1" ){ //Bajas para facturas
	$nombreArchivoBorrar = $rucEmisor."-RA-".date('Ymd')."-".$rowNum['contBajas'];

	$sqlC="SELECT concat(`factSerie`,'-', `factCorrelativo`) as facCorre, `fechaEmision` FROM `fact_cabecera` WHERE `idComprobante`={$_POST['id']}";
	$resultadoC=$conf->query($sqlC);
	$rowC=$resultadoC->fetch_assoc();

	$lineaBaja = $lineaBaja . $rowC['fechaEmision']. "|".date('Y-m-d')."|01|".$rowC['facCorre']."|".strtoupper($_POST['concepto'])."|";
	//echo $nombreArchivoBorrar;

	$baja = fopen("{$path}/{$nombreArchivoBorrar}.cba", "w");
	fwrite($baja, "{$lineaBaja}");
	fclose($baja);
	

	$sql="UPDATE `fact_cabecera` SET 
	`comprobanteEmitido` = 2,
	motivoBaja='{$_POST['concepto']}',
	fechaBaja = now()
	where `idComprobante` = {$_POST['id']}";
	$resultado=$conf->query($sql);
	
	//echo "ok";
}

if( $_POST['boleta']=="3" ){ //Bajas para boletas
	$nombreArchivoBorrar = $rucEmisor."-RC-".date('Ymd')."-".$rowNum['contBajas'];

	$sqlC="SELECT concat(`factSerie`,'-', `factCorrelativo`) as facCorre, `fechaEmision`, tipDocUsuario, dniRUC, costoFinal, IGVFinal, totalFinal FROM `fact_cabecera` WHERE `idComprobante`={$_POST['id']}";
	$resultadoC=$conf->query($sqlC);
	$rowC=$resultadoC->fetch_assoc();

	$lineaBaja = $lineaBaja . $rowC['fechaEmision']. "|". date('Y-m-d') ."|03|".$rowC['facCorre']."|".$rowC['tipDocUsuario']."|".$rowC['dniRUC']."|PEN|".$rowC['costoFinal']."|0|0|0|0|0|". $rowC['totalFinal']."|||||||||3|";
	//echo $nombreArchivoBorrar;
	
	$baja = fopen("{$path}/{$nombreArchivoBorrar}.RDI", "w");
	fwrite($baja, "{$lineaBaja}");
	fclose($baja);

	$lineaTributo = '1|1000|IGV|VAT|'.$rowC['costoFinal'].'|'.$rowC['IGVFinal'].'|';
	$tributo = fopen("{$path}{$nombreArchivoBorrar}.TRD", "w");
	fwrite($tributo, "{$lineaTributo}");
	fclose($tributo);
	

	$sql="UPDATE `fact_cabecera` SET 
	`comprobanteEmitido` = 2,
	motivoBaja='{$_POST['concepto']}',
	fechaBaja = now()
	where `idComprobante` = {$_POST['id']}";
	$resultado=$conf->query($sql);
	
	//echo "ok";
}

?>