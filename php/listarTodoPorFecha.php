<?php
date_default_timezone_set('America/Lima');
include "conexion.php";

if( isset($_POST['fecha'])){
	$fecha = $_POST['fecha'];
	if( isset($_POST['fecha2'])){
		$fecha2 = $_POST['fecha2']; 
	}else{ 
		$fecha2 = $_POST['fecha'];
	}

	$sql="SELECT `idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, case when `factTipoDocumento`= 1 then 'Factura' when `factTipoDocumento`= 3 then 'Boleta' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, lower(`razonSocial`) as razonSocial, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`, `cliDireccion` FROM `fact_cabecera` WHERE  `fechaEmision` between '{$fecha}' and '{$fecha2}';";
}else{
	$fecha = date('Y-m-d');

	$sql="SELECT `idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, case when `factTipoDocumento`= 1 then 'Factura' when `factTipoDocumento`= 3 then 'Boleta' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, lower(`razonSocial`) as razonSocial, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`, `cliDireccion` FROM `fact_cabecera` WHERE  `fechaEmision` = '{$fecha}';";
}
echo $sql;




$resultado=$cadena->query($sql);
$numero = $resultado ->num_rows;
if($numero==0){ ?>
<tr>
	<td colspan="6">No hay comprobantes emitidos en ésta fecha.</td>
</tr>
<?php }
$i=1;
while($row=$resultado->fetch_assoc()){ 
	$fEmision1 = new DateTime($row['fechaEmision']);
	$hora = new DateTime($row['horaEmision']);
	?>
	<tr>
		<td><?= $i; ?></td>
		
		<td><?= $row['queDoc']; ?></td>
		<td><?= $row['factSerie']."-".$row['factCorrelativo']; ?></td>
	<?php if( isset($_POST['fecha2'])): ?>
		<td data-sort-value="<?php echo $hora->format('ymd'); ?>"><?php echo $fEmision1->format('d/m/Y')." ". $hora->format('h:i a'); ?></td>
	<?php else: ?>
		<td data-sort-value="<?php echo $hora->format('Hi'); ?>"><?php echo $hora->format('h:i a'); ?></td>
	<?php endif; ?>

		<td class="text-capitalize"><?= $row['razonSocial']; ?></td>
		<td>S/ <?= number_format($row['totalFinal'],2); ?></td>
		<td><?php if($row['comprobanteEmitido']==0){ echo 'Sin emitir'; }else { echo "<span class='text-success'>Emitido</span>";}?></td>
		<td data-caso="<?= $row['factTipoDocumento']; ?>" data-serie="<?= $row['factSerie']; ?>" data-correlativo="<?= $row['factCorrelativo']; ?>" data-ticket="<?= $row['idTicket']; ?>">
			<?php 
			if($row['comprobanteEmitido']==0 && $fecha == date('Y-m-d')){ ?>
			<button class="btn btn-outline-primary btn-sm border border-light btnGenComprobante" data-ticket="<?= $row['idTicket']; ?>" data-toggle="tooltip" data-placement="top" title="Generar comprobante"><i class="icofont-flag"></i></button>
			<?php
			}
			else if($row['comprobanteEmitido']==1){ ?>
			<button class="btn btn-outline-success btn-sm border border-light imprTicketFuera" data-toggle="tooltip" data-placement="top" title="Imprmir ticket"><i class="icofont-paper"></i></button>
			<button class="btn btn-outline-success btn-sm border border-light imprA4Fuera" data-toggle="tooltip" data-placement="top" title="Imprmir A4"><i class="icofont-print"></i></button>
			<?php }
			?>
		</td>
	</tr>
<?php  $i++; }

?>