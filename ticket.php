<?php
include "fpdf/fpdf.php";
include('phpqrcode/qrlib.php');

include 'php/conexion.php';
include 'generales.php';
require "NumeroALetras.php";

$token = base64_encode($_GET['serie'] . '-' . $_GET['correlativo']);
if ($token <> $_GET['token']) {
?>
	<h3>Token inválido</h3>
	<p>No se encontró ningún comprobante</p>
<?php
	die();
}
$esServicio = true;

$sqlSeries = "SELECT fc.`idComprobante`, `factTipoDocumento`, case `factTipoDocumento` when 1 then 'FACTURA ELECTRÓNICA' when 3 then 'BOLETA ELECTRÓNICA' when -1 then 'PROFORMA' when 0 then 'TICKET' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, fc.`fechaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`, count(fd.codItem) as cantFilas, esContado, observaciones
FROM `fact_cabecera` fc
inner join fact_detalle fd on concat(fc.factSerie, '-', fc.factCorrelativo) = fd.facSerieCorre
WHERE fc.factSerie = '{$_GET['serie']}' and fc.factCorrelativo='{$_GET['correlativo']}' and factTipoDocumento in (1,3);"; //group by fd.idCabecera
//echo $sqlSeries; 
$resultadoSeries = $esclavo->query($sqlSeries);

if ($resultadoSeries->num_rows == 0) {
?>
	<h3>Comprobante inválido</h3>
	<p>No se encontró ningún comprobante</p>
<?php
	die();
}

$rowSeries = $resultadoSeries->fetch_assoc();

$sqlCreditos = "SELECT * from fechasCreditos where idCabecera = {$rowSeries['idComprobante']};";
$respCreditos = $esclavo->query($sqlCreditos);

$caso = "-0{$rowSeries['factTipoDocumento']}-"; // 01 para factura, 03 para boleta

$serie = $rowSeries['factSerie'];
$soy = $rowSeries['queDoc'];
$correlativo = $rowSeries['factCorrelativo'];

if (in_array($rowSeries['queDoc'], ['PROFORMA', 'TICKET INTERNO'])) {
	$factura =  $correlativo;
} else {
	$factura =  $serie . '-' . $correlativo;
}
$nombreArchivo = $rucEmisor . $caso . $factura;


/* $sqlBase="SELECT totalFinal from `fact_cabecera` where factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}' and factTipoDocumento = '{$_GET['tipo']}';";
$resultadoBase=$cadena->query($sqlBase);
$rowBase=$resultadoBase->fetch_assoc(); */


$sqlCabeza = "SELECT * from `fact_cabecera` where factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}' and factTipoDocumento in (1,3);";

$resultadoCabeza = $cadena->query($sqlCabeza);
$filasCabeza = $resultadoCabeza->num_rows;
$rowC = $resultadoCabeza->fetch_assoc();

$idCabecera = $rowC['idComprobante'];

$parteEntera = intval($rowC['totalFinal']);
$parteDecimal = ($rowC['totalFinal'] - $parteEntera) * 100;
if ($parteDecimal == '0') {
	$parteDecimal = '00';
}
//Pedir las letras del monto facturado

$letras = trim(NumeroALetras::convertir($parteEntera)) . ' SOLES ' . $parteDecimal . '/100 MN';

if ($filasCabeza == 1) {

	if (strlen($rowC['dniRUC']) == 11) {
		$tipoDoc = '6';
	} else if (strlen($rowC['dniRUC']) == 8) {
		$tipoDoc = '1';
	} else if (strlen($rowC['dniRUC']) == 0) {
		$tipoDoc = '0';
	}
	$descuento = $rowC['sumDescTotal'];
	$costo = str_replace(',', '', number_format($rowC['costoFinal'], 2));
	$igvFin = str_replace(',', '', number_format($rowC['IGVFinal'], 2));
	$totFin = str_replace(',', '', number_format($rowC['totalFinal'], 2));
}

$fecha = new DateTime($rowC['fechaEmision']);

$tempDir = './';
$filename = "qrtemp";
$body =  $rucEmisor . $separador . $rowSeries['factTipoDocumento'] . $separador . $serie . $separador . $correlativo . $separador . $rowC['IGVFinal'] . $separador . $rowC['totalFinal'] . $separador . $fecha->format('d/m/Y') . $separador . $tipoDoc . $separador . $rowC['dniRUC'] . $separador . $rowC['factPlaca'] . $separador;
$codeContents = $body;
QRcode::png($codeContents, $tempDir . '' . $filename . '.png', QR_ECLEVEL_L, 5);


//Extraido de https://evilnapsis.com/2018/04/26/php-formato-de-ticket-basico-para-impresoras-de-tickets-con-fpdf/
$pdf = new FPDF($orientation = 'P', $unit = 'mm', array(75, (20 * (5 + $rowSeries['cantFilas']) + (5 + $respCreditos->num_rows)) + 50)); //N° lineas * 6 + 60 espacio minimo //75 es los mm de ancho
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 9);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 4;
$pdf->setY(2);
$pdf->setX(0);
$anchoImg = 60;
$x = ($pdf->GetPageWidth() - $anchoImg) / 2;
$pdf->Image('bitmap.jpg', $x, 0, $anchoImg, 0);
$pdf->setY(18);

$pdf->Cell(0, $textypos, utf8_decode($soy), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(0, $textypos, $factura, 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(0, $textypos, "R.U.C. " . $rucEmisor, 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(0, $textypos, $nombreEmisor, 0, 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln();
$pdf->MultiCell(0, 3, utf8_decode($direccionEmisor), 0, 'C');
$pdf->Cell(0, $textypos, 'Celular: ' . $celularEmisor, 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(0, $textypos, '-------------', 0, 0, 'C');
$pdf->Ln();
$pdf->setX(2);

$pdf->Cell(0, 3, 'RUC: ' . $rowC['dniRUC'], 0, 0);

$pdf->Ln(3);
$pdf->setX(2);
$pdf->MultiCell(70, 4, utf8_decode('Razón Social: ' . ucwords(strtolower($rowC['razonSocial']))));
$pdf->setX(2);
$pdf->MultiCell(70, 4, utf8_decode('Dirección: ' . ucwords(strtolower($rowC['cliDireccion']))));
//$pdf->Cell( 0, 3, utf8_decode('Razón Social: '. ucwords(strtolower($rowC['razonSocial']))), 0, 0);
$pdf->Ln(2);
$pdf->setX(2);
$pdf->Cell(0, 3, utf8_decode('Fecha emisión: ' . $fecha->format('d/m/Y')), 0, 0);
$pdf->Ln();
$pdf->setX(2);
$pdf->Cell(0, 3, utf8_decode('Moneda: Soles'), 0, 0);
$pdf->Ln();
$pdf->setX(2);
$pdf->Cell(0, 3, utf8_decode('Pago: '  . ($rowC['esContado'] == '1' ? 'Al contado' : 'A crédito')), 0, 0);
$pdf->Ln();
$pdf->Ln();

$pdf->setX(2);
$pdf->SetFont('Arial', 'B', 9);
if (!$esServicio)
	$pdf->Cell(5, $textypos, 'Cant.     Producto                 SubTotal');
else
	$pdf->Cell(5, $textypos, 'Servicio                                          SubTotal');

$pdf->SetFont('Arial', '', 8);

$i = 1;
$rowProductos = array();

$lineaDetalle = '';
$sqlDetalle = "SELECT fd.*, u.undCorto FROM `fact_detalle` fd inner join unidades u on u.undSunat = codUnidadMedida WHERE idCabecera = {$idCabecera};";
$resultadoDetalle = $cadena->query($sqlDetalle);
$pdf->Ln();
while ($rowD = $resultadoDetalle->fetch_assoc()) {

	$unidad = 'NIU';

	$valorFin = str_replace(',', '', number_format($rowD['valorUnitario'], 2));
	$igvSubFin = str_replace(',', '', number_format($rowD['igvUnitario'], 2));
	$valorSubFin = str_replace(',', '', number_format($rowD['valorItem'], 2));
	$precProducto = number_format($rowD['valorUnitario'] + $rowD['igvUnitario'], $decimalesSuper);

	$queSerie = $rowD['serie'] == '' ? '' : "(SN: {$rowD['serie']}) ";

	
	$pdf->setX(2);

	if ($rowD['codUnidadMedida'] == 'ZZ') {
		$pdf->Cell(0, 4, utf8_decode(ucwords(strtolower($rowD['descripcionItem'] . $queSerie))), 0, 1, '');
		$pdf->Cell(0, 4, 'S/ ' . number_format(floatval($precProducto), 2), 0, 1, 'R');
	} else {
		$cantidadProd = $rowD['cantidadItem'];
		$pdf->Cell(0, 4, utf8_decode("{$cantidadProd} [UND] " . ucwords(strtolower($rowD['descripcionItem'] . $queSerie))), 0, 1, '');
		$pdf->setX(2);
		$pdf->Cell(50, 4, "S/ " . $precProducto, 0, 0, '');
		$pdf->Cell(0, 4, 'S/ ' . number_format(floatval($precProducto) * floatval($cantidadProd), 2), 0, 1, '');
	}
	$i++;
}
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$x = $pdf->GetX() + 25;
$y = $pdf->GetY() - 2;
$pdf->Line($x, $y, $x + 30, $y);
$pdf->Cell(0, $textypos, 'Sub total: S/ ' . number_format($rowC['costoFinal'], 2), 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(0, $textypos, 'IGV: S/ ' . number_format($rowC['IGVFinal'], 2), 0, 0, 'R');
$pdf->Ln();
$pdf->Cell(0, $textypos, 'Total: S/ ' . number_format($rowC['totalFinal'], 2), 0, 0, 'R');
$pdf->Ln();
$pdf->setX(2);

$pdf->SetFont('Arial', 'B', 9);
$c = 1;

if ($respCreditos->num_rows > 0) $pdf->Cell(0, $textypos, utf8_decode('Créditos: '), 0, 0, 'B');
$pdf->Ln();
$pdf->SetFont('Arial', '', 8);

while ($rowCreditos = $respCreditos->fetch_assoc()) {
	$pdf->Cell(0, $textypos, utf8_decode("{$c}° {$rowCreditos['fecha']}. Monto: S/ " . number_format($rowCreditos['monto'], 2)), 0, 0);
	$pdf->Ln();
	$c++;
}
$pdf->setX(2);
$pdf->Cell(0, $textypos, 'Son: ' . $letras);
$pdf->Ln();
$pdf->setX(2);
if ($rowC['observaciones']) {
	$pdf->Cell(73, 3, 'Obs.: ' . utf8_decode($rowC['observaciones']));
	$pdf->Ln();
}
$posX = $pdf->GetX();
$posY = $pdf->GetY();
$pdf->Image('qrtemp.png', $posX + 17, $posY, -170);
$pdf->SetY($posY + 25);
$pdf->Ln();
$pdf->setX(2);
$pdf->SetFont('Arial', '', 7);
$pdf->MultiCell(0, 3, utf8_decode('Visble en Sunat a partir de 24-48 horas de la emisión mediante Resolución de Superintendencia N° 0150-2021/SUNAT.'), 0, 'C');

$pdf->output(utf8_decode('Comprobante Electrónico ') . $serie . '-' . $correlativo, 'I');
