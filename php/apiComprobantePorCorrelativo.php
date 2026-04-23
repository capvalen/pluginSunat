<?php
date_default_timezone_set('America/Lima');
include 'conexion.php';
include '../generales.php';
require "../NumeroALetras.php";

// Rechazar OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	http_response_code(200);
	exit;
}

$_POST = json_decode(file_get_contents('php://input'),true); 
//var_dump( $_POST); die();

$empresa = [];
$sqlEmpresa = $datab->prepare("SELECT * FROM `configuracion`");
$sqlEmpresa->execute();
while($rowEmpresa = $sqlEmpresa->fetch(PDO::FETCH_ASSOC)){
	if( in_array($rowEmpresa['confVariable'], ['ruc', 'razonSocial', 'direccion', 'celular', 'igvGlobal']) ) 
		$empresa[$rowEmpresa['confVariable']] = $rowEmpresa['confValor'];
}


$filas =null;
$sql = $datab->prepare("SELECT *, case `factTipoDocumento` when 1 then 'FACTURA' when 3 then 'BOLETA' end as 'queDoc' FROM `fact_cabecera` WHERE concat(factSerie, '-', factCorrelativo) = ? and factTipoDocumento in (1,3) limit 1;");
$sql->execute([ $_POST['correlativo'] ]);
$rowCabecera = $sql->fetch(PDO::FETCH_ASSOC);

$productos = [];
$sqlDetalle = $datab->prepare("SELECT * FROM `fact_detalle` WHERE idCabecera = ? limit 1;");
$sqlDetalle->execute([ $rowCabecera['idComprobante'] ]);
while( $rowDetalle = $sqlDetalle->fetch(PDO::FETCH_ASSOC))
	$productos[]=$rowDetalle;

$fechas = [];
$sqlFechas = $datab->prepare("SELECT * FROM `fechasCreditos` WHERE idCabecera = ? limit 1;");
$sqlFechas->execute([ $rowCabecera['idComprobante'] ]);
while( $rowFechas = $sqlFechas->fetch(PDO::FETCH_ASSOC))
	$fechas[]=$rowFechas;

$filas = array(
	'empresa' => $empresa,
	'cabecera' => $rowCabecera,
	'detalles' => $productos,
	'fechas' => $fechas
);

echo json_encode($filas);