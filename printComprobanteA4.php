<?php
include('phpqrcode/qrlib.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico <?= $_GET['serie']."-".$_GET['correlativo'];?> - Desarrollado por https://infocatsoluciones.com</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
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

include 'conexion.php';
include 'generales.php';
require "NumeroALetras.php";


$sqlSeries="SELECT `idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, case when `factTipoDocumento`= 1 then 'FACTURA' when `factTipoDocumento`= 3 then 'BOLETA' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado` FROM `fact_cabecera` WHERE factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}'; ";
$resultadoSeries=$esclavo->query($sqlSeries);
$rowSeries=$resultadoSeries->fetch_assoc();


$caso = "-0{$rowSeries['factTipoDocumento']}-"; // 01 para factura, 03 para boleta

$serie = $rowSeries['factSerie'];
$soy = $rowSeries['queDoc'];
$correlativo = $rowSeries['factCorrelativo'];


$factura =  $serie.'-'.$correlativo;
$nombreArchivo = $rucEmisor.$caso.$factura ; 


$sqlBase="select totalFinal from `fact_cabecera` where factSerie = '{$_GET['serie']}' and factCorrelativo='{$_GET['correlativo']}'; ";
$resultadoBase=$cadena->query($sqlBase);
$rowBase=$resultadoBase->fetch_assoc();
	
$parteEntera = intval($rowBase['totalFinal']);
$parteDecimal = ($rowBase['totalFinal']-$parteEntera)*100;

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
	
	$lineaCabeza = $rowC['tipOperacion'].$separador.$rowC['fechaEmision'].$separador.$rowC['horaEmision'].$separador.$rowC['fechaVencimiento'].$separador. $domicilioFiscal.$separador. $tipoDoc.$separador.$rowC['dniRUC'].$separador.$rowC['razonSocial']. $separador.$rowC['tipoMoneda'].$separador. $costo.$separador. $igvFin.$separador. $totFin . $separador. $descuento.$separador. $sumaCargos.$separador.$anticipos. $separador. $totFin.$separador.$versionUbl.$separador. $customizacion.$separador;

	//echo $lineaCabeza;

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
	<img src="bitmap.jpg?version=1.0.2" alt="" >
	<p class="mb-0 mt-2"><strong><?= $nombreEmisor;?></strong></p>
	<p><?= $direccionEmisor;?></p>
</div>
<div class="col-sm-6 mt-5 mb-2 text-center " class="">
	<div class="border border-dark bordeGrueso">
		<h3 class="text-uppercase">RUC: <?= $rucEmisor; ?></h3>
		<h2 class="text-uppercase"><?= $soy; ?> ELECTRÓNICA</h2>
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

	$lineaDetalle =  $lineaDetalle . $unidad.$separador.$rowD['cantidadItem']. $separador.$i.$separador. $rowD['codProductoSUNAT'].$separador.$rowD['descripcionItem'].$separador. $valorFin.$separador.  $igvSubFin.$separador. $rowD['codTriIGV'] .$separador. $igvSubFin.$separador. $valorSubFin.$separador. $rowD['nomTributoIgvItem'].$separador. $rowD['codTipTributoIgvItem'] .$separador.$rowD['tipAfeIGV']. $separador. $rowD['porIgvItem'] .$separador. $rowD['codTriISC'] . $separador. $rowD['mtoIscItem'] . $separador. $rowD['mtoBaseIscItem'] . $separador. $rowD['nomTributoIscItem'] .$separador . $rowD['codTipTributoIscItem'] .$separador . $rowD['tipSisISC'] .$separador. $rowD['porIscItem']. $separador. $rowD['codTriOtroItem']. $separador. $tributoOtro .$separador. $tributoOtroItem .$separador.$baseOtroItem .$separador.$rowD['codTipTributoIOtroItem'] . $separador. $rowD['porTriOtroItem'] .$separador. $rowD['mtoPrecioVenta'] . $separador. $rowD['mtoValorVenta']. $separador. $rowD['mtoValorReferencialUnitario']. $separador."\n";

	
	
	?>
	<tr>
		<td><?= $i;?></td>
		<td class="text-capitalize"><?= $rowD['descripcionItem']; ?></td>
		<td><?= $rowD['undCorto']?></td>
		<td><?= $rowD['cantidadItem']; ?></td>
		<td><?= $precProducto; ?></td>
		<td><?= number_format($rowD['mtoPrecioVenta'],2)?></td>
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
		<p>Descuento</p>
		<p>Op. Grabada</p>
		<p>I.G.V.</p>
		<p>Op. Gratuita</p>
		<p>Op. Exhonerada</p>
		<p>Op. Inafecta</p>
		<h5 class="border-top pt-2 bordeAlgo">Importe Total</h5>
	</div>
	<div class="col">
		<p><?= number_format($rowC['sumDescTotal'],2);?></p>
		<p><?= number_format($rowC['costoFinal'],2);?></p>
		<p><?= number_format($rowC['IGVFinal'],2);?></p>
		<p>0.00</p>
		<p>0.00</p>
		<p>0.00</p>
		<h5 class="border-top pt-2 bordeAlgo"><?= number_format($rowC['totalFinal'],2);?></h5>
	</div>
</div>
</div>
</div>
</section>


</div> <!-- Fin de contariner 1 -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

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