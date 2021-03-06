<?php
include('phpqrcode/qrlib.php'); 

include 'php/conexion.php';
include 'generales.php';
require "NumeroALetras.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico <?= $_GET['serie']."-".$_GET['correlativo'];?> - Desarrollado por infocatsoluciones.com</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" >
</head>
<body>
<style>
.bordeGrueso{
	border: 4px solid #343a40!important;
}
.bordeDelgado{
	border: 2px solid #343a40!important;
}
.bordeAlgo{
	border-top: 2px solid #343a40!important;
}
</style>
<div class="container">

<?php



$sqlSeries="SELECT `idComprobante`, `factTipoDocumento`, case `factTipoDocumento` when 1 then 'FACTURA ELECTRÓNICA' when 3 then 'BOLETA ELECTRÓNICA' when -1 then 'PROFORMA' when 0 then 'TICKET INTERNO' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado` FROM `fact_cabecera` WHERE factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}'; ";
$resultadoSeries=$esclavo->query($sqlSeries);
$rowSeries=$resultadoSeries->fetch_assoc();


$caso = "-0{$rowSeries['factTipoDocumento']}-"; // 01 para factura, 03 para boleta

$serie = $rowSeries['factSerie'];
$soy = $rowSeries['queDoc'];
$correlativo = $rowSeries['factCorrelativo'];

if( in_array( $rowSeries['queDoc'] , ['PROFORMA', 'TICKET INTERNO']) ){ $factura =  $correlativo; }else{$factura =  $serie.'-'.$correlativo;}
$nombreArchivo = $rucEmisor.$caso.$factura ; 


$sqlBase="select totalFinal from `fact_cabecera` where factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}'; ";
$resultadoBase=$cadena->query($sqlBase);
$rowBase=$resultadoBase->fetch_assoc();
	
$parteEntera = intval($rowBase['totalFinal']);
$parteDecimal = ($rowBase['totalFinal']-$parteEntera)*100;
if($parteDecimal == '0'){
	$parteDecimal='00';
}
//Pedir las letras del monto facturado

$letras = trim(NumeroALetras::convertir($parteEntera)).' SOLES '.$parteDecimal.'/100 MN';



$sqlCabeza="select * from `fact_cabecera` where factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}';";

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
	$descuento = $rowC['sumDescTotal'];
	$costo= str_replace (',', '',number_format($rowC['costoFinal'],2));
	$igvFin = str_replace (',', '',number_format($rowC['IGVFinal'],2));
	$totFin = str_replace (',', '',number_format($rowC['totalFinal'],2));

}

$fecha= new DateTime($rowC['fechaEmision']);

$tempDir = './';
$filename = "qrtemp";
$body =  $rucEmisor .$separador. $rowSeries['factTipoDocumento'] .$separador. $serie .$separador. $correlativo .$separador. $rowC['IGVFinal'] .$separador. $rowC['totalFinal'] . $separador. $fecha->format('d/m/Y') . $separador. $tipoDoc . $separador. $rowC['dniRUC'] . $separador . $rowC['factPlaca']. $separador;
$codeContents = $body; 
QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);

?>


<div class="row">
<div class="col-sm-6 ">
	<img src="images/aliser.jpeg?version=1.0.2" alt="" class="w-75" >
	<p class="mb-0 mt-2"><strong><?= $nombreEmisor;?></strong></p>
	<p><?= $direccionEmisor;?></p>
</div>
<div class="col-sm-6 mt-5 mb-2 text-center " class="">
	<div class="border border-dark bordeGrueso">
		<h3 class="text-uppercase">RUC: <?= $rucEmisor; ?></h3>
		<h2 class="text-uppercase"><?= $soy; ?></h2>
		<h2 class="text-uppercase"><?= $factura; ?></h2>
	</div>
</div>
</div>
<section>
	<div class="border bordeDelgado p-2 container-fluid">
	<div class="row">
		<div class="col-8">
			<p class="text-capitalize">Srs: <?= $rowC['razonSocial']; ?> </p>
			<p  class="text-capitalize">Domicilio Fiscal: <?= $rowC['cliDireccion']; ?></p>
			<p>N° Documento: <?= $rowC['dniRUC']; ?></p>
			
		</div>
		<div class="col">
		<br>
		<p>Fecha de emisión: <?php echo $fecha->format('d/m/Y'); ?></p>
		<p>Tipo Moneda: PEN</p>
		</div>
	</div>
	</div>
</section>
<section class="pt-2">
<table class="table table-bordered">
<thead>
	<tr>
		<th>Item</th>
		<th>Descripción</th>
		<th>Und.</th>
		<th>Cant.</th>
		<th>Prec. Unt.</th>
		<th>SubTotal. <br> (inc. IGV)</th>
	</tr>
</thead>
<tbody>


<?php

$i=1;
$rowProductos = array();

$lineaDetalle ='';
$sqlDetalle="SELECT fd.*, u.undCorto FROM `fact_detalle` fd inner join unidades u on u.undSunat = codUnidadMedida WHERE facSerieCorre = '{$_GET['serie']}-{$_GET['correlativo']}'";
$resultadoDetalle=$cadena->query($sqlDetalle);
while($rowD=$resultadoDetalle->fetch_assoc()){ 

	$unidad = 'NIU';
	
	$valorFin = str_replace (',', '',number_format($rowD['valorUnitario'],2));
	$igvSubFin = str_replace (',', '',number_format($rowD['igvUnitario'],2));
	$valorSubFin = str_replace (',', '',number_format($rowD['valorItem'],2));
	$precProducto = number_format($rowD['valorUnitario']+$rowD['igvUnitario'],2);

	?>
	<tr>
		<td><?= $i;?></td>
		<td class="text-capitalize"><?= $rowD['descripcionItem']; ?></td>
		<td><?= $rowD['undCorto']?></td>
		<td><?= $rowD['cantidadItem']; ?></td>
		<td><?= $precProducto; ?></td>
		<td><?= number_format($rowD['valorItem'],2)?></td>
	</tr>
	<?php 
	$i++;
}


?>

</tbody>
</table>
</section>

<section>
<div class="row">
<div class="col-6">
	<div class="d-flex flex-column text-center">
		<div>
			<img src="qrtemp.png" alt="">
		</div>
	</div>
<p>Representacion Impresa de <br><?= $soy; ?> ELECTRÓNICA N° <?= $factura; ?></p>
<h5>Son: <?= $letras; ?></h5>
</div>
<div class="col-6">
<div class="row">
	<div class="col text-right">
		
		<p>Op. Grabada</p>
		<p>I.G.V.</p>
		<p>Op. Gratuita</p>
		<p>Op. Exonerada</p>
		<p class="d-none">Op. Inafecta</p>
		<h5 class="border-top pt-2 bordeAlgo">Importe Total</h5>
	</div>
	<div class="col">
		<p class="d-none">S/ <?= number_format($rowC['sumDescTotal'],2);?></p>
		<p>S/ <?= number_format($rowC['costoFinal'],2);?></p>
		<p>S/ <?= number_format($rowC['IGVFinal'],2);?></p>
		<p>S/ 0.00</p>
		<p>S/ <?= number_format($rowC['factExonerados'],2);?></p>
		<p class="d-none">S/ 0.00</p>
		<h5 class="border-top pt-2 bordeAlgo">S/ <?= number_format($rowC['totalFinal'],2);?></h5>
	</div>
</div>
</div>
</div>
</section>


</div> <!-- Fin de contariner 1 -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" ></script>
<script src="js/bootstrap.min.js" ></script>

<script>
$(document).ready(function () {
window.print();	//Activa la impresion apenas cargo todo
});
/*Determina si se imprimio o se cancelo, para cerrar la pesataña activa*/
(function () {
	var afterPrint = function () {
	window.top.close();
	};
	if (window.matchMedia) {
		var mediaQueryList = window.matchMedia('print');
		mediaQueryList.addListener(function (mql) {
				//alert($(mediaQueryList).html());
				if (mql.matches) {
				} else { afterPrint(); }
		});
	}
	window.onafterprint = afterPrint;
}());
</script>
</body>
</html>