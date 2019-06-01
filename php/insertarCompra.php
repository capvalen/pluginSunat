<?php 

date_default_timezone_set('America/Lima');
include 'conexion.php';

$sqlEProveedor="SELECT * FROM `clientes` where cliRuc = '{$_POST['ruc']}' and esProveedor=1; ";

$resultadoEProveedor=$cadena->query($sqlEProveedor);
if( $resultadoEProveedor->num_rows>=1 ){
	$rowEProveedor=$resultadoEProveedor->fetch_assoc();
	$idProveedor = $rowEProveedor['idCliente'];
}else{
	$sqlInsProveedor="INSERT INTO `clientes`(`idCliente`, `cliRuc`, `cliRazonSocial`, `cliComercial`, `cliDomicilio`, `cliTelefono`, `cliActivo`, `esProveedor`) 
	VALUES (null, '{$_POST['ruc']}','{$_POST['razonSocial']}','', '{$_POST['domicilio']}','',1,1); ";
	$resultadoInsProveedor=$esclavo->query($sqlInsProveedor);
	$idProveedor = $esclavo->insert_id;
}

/**********  Proceso de compra cabecera insert  ******** */
$sql="INSERT INTO `compras`(`idCompra`, `idComprobante`, `compFecha`, `compSerie`, `compFechaRegistro`, `idMoneda`, `compCambioMoneda`, `idProveedor`, `comObs`, `idUsuario`, `compActivo`, `compExonerado`, `compSubTotal`, `compIgv`, `compTotal`)
VALUES (null,{$_POST['idComprobante']}, '{$_POST['compFecha']}','{$_POST['serie']}',now(),{$_POST['idMoneda']}, '{$_POST['monedaCambio']}', {$idProveedor}, '{$_POST['compObs']}', {$_COOKIE['ckidUsuario']}, 1, {$_POST['sumExonerado']},{$_POST['sumSubtotal']},{$_POST['sumIgv']},{$_POST['sumTotal']}); ";
//echo $sql;
$resultado=$cadena->query($sql);
$idCompra= $cadena->insert_id;


/**********  Proceso de compra detalle insert  ******** */

?>