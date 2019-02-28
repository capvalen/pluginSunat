<?php
date_default_timezone_set('America/Lima');
include "conexion.php";

if (isset($_POST['fecha'])){ $fecha = $_POST['fecha'];}else{
	$fecha = date('Y-m-d');
}

$sql="SELECT `idComprobante`, `idNegocio`, `idLocal`, `idTicket`, `factTipoDocumento`, case when `factTipoDocumento`= 1 then 'FACTURA' when `factTipoDocumento`= 3 then 'BOLETA' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, `razonSocial`, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, `comprobanteEmitido`, `comprobanteFechado`, `cliDireccion` FROM `fact_cabecera` WHERE  `fechaEmision` = '{$fecha}';";

$resultado=$cadena->query($sql);
$numero = $resultado ->num_rows;
if($numero==0){ ?>
<tr>
	<td colspan="5">No hay comprobantes emitidos en ésta fecha.</td>
</tr>
<?php }
$i=1;
while($row=$resultado->fetch_assoc()){ 
	$hora = new DateTime($row['horaEmision']);
	?>
	<tr>
		<td><?= $i; ?></td>
		
		<td><?= $row['queDoc']; ?></td>
		<td><?= $row['factSerie']."-".$row['factCorrelativo']; ?></td>
		<td><?= $hora->format('h:m a'); ?></td>
		<td><?= $row['razonSocial']; ?></td>
		<td><?= number_format($row['totalFinal'],2); ?></td>
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
<?php }

?>