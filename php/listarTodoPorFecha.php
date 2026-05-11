<?php
date_default_timezone_set('America/Lima');
include __DIR__. "/conexion.php";

$comprobantes = [1, 3, 12];
$numInterno = 0; $numBoletas =0; $numFacturas = 0; $numDebito=0; $numCredito=0; $sumIgv =0; $sumTotales=0;

$select = "SELECT `idComprobante`, `factTipoDocumento`, case `factTipoDocumento` when 1 then 'Factura' when 3 then 'Boleta' when 4 then 'Nota de Crédito' when 5 then 'Nota de Débito' when 0 then 'Interno' when -1 then 'Proforma' end as 'queDoc', `factSerie`, `factCorrelativo`, `tipOperacion`, `fechaEmision`, `horaEmision`, `fechaVencimiento`, `codLocalEmisor`, `tipDocUsuario`, `dniRUC`, lower(`razonSocial`) as razonSocial, `tipoMoneda`, `costoFinal`, `IGVFinal`, `totalFinal`, `sumDescTotal`, `sumOtrosCargos`, `sumTotalAnticipos`, `sumImpVenta`, `ublVersionId`, `customizationId`, `ideTributo`, `nomTributo`, `codTipTributo`, `mtoBaseImponible`, `mtoTributo`, `codLeyenda`, `desLeyenda`, comprobanteEmitido, case `comprobanteEmitido` when 1 then 'Generar XML' when 0 then 'Sin emitir' when '2' then 'De baja' when '3' then 'Enviado a SUNAT' when 4 then 'Borrado' end as comprobanteEmitidoDescr, `comprobanteFechado`, `cliDireccion`, `motivoBaja`, esContado, adelanto, observaciones FROM `fact_cabecera` ";
if (isset($_POST['texto']) && $_POST['texto']<>'' ):
	$sql = $select . " WHERE concat( `factSerie`,'-',factCorrelativo) like '%{$_POST['texto']}' or dniRUC = '%{$_POST['texto']}' or razonSocial like '%{$_POST['texto']}%';";

else:
	if (isset($_POST['fecha'])) {
		$fecha = $_POST['fecha'];
		if (isset($_POST['fecha2'])) {
			$fecha2 = $_POST['fecha2'];
		} else {
			$fecha2 = $_POST['fecha'];
		}

		$sql = $select . " WHERE  `fechaEmision` between '{$fecha}' and '{$fecha2}';";
	} else {
		$fecha = date('Y-m-d');
		$sql = $select . " WHERE  `fechaEmision` = '{$fecha}';";
	}

endif;

$esReporte = isset($_POST['esReporte']) ? intval($_POST['esReporte']) : 0;

$resultado = $cadena->query($sql);
$numero = $resultado->num_rows;
?>
<table class="table table-hover mt-3 mb-5 pb-5" id="tablaPrincipal" data-ruc="<?= $_COOKIE['ruc'] ?>">
	<thead>
		<tr>
			<th data-sort="int"><i class="bi bi-arrow-down-short"></i> N°</th>
			<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Tipo</th>
			<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Código</th>
			<th data-sort="int"><i class="bi bi-arrow-down-short"></i> Hora</th>
			<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Cliente</th>
			<th data-sort="float"><i class="bi bi-arrow-down-short"></i> I.G.V.</th>
			<th data-sort="float"><i class="bi bi-arrow-down-short"></i> Monto</th>
			<th data-sort="float"><i class="bi bi-arrow-down-short"></i> Tipo Pago</th>
			<th data-sort="float"><i class="bi bi-arrow-down-short"></i> Adelanto</th>
			<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Estado</th>
			<th>@</th>
		</tr>
	</thead>
	<tbody>
<?php
if ($numero == 0) { ?>
	<tr>
		<td id="nada" colspan="6">No hay comprobantes emitidos en ésta fecha.</td>
	</tr>
<?php }
$i = 1;
while ($row = $resultado->fetch_assoc()) {
	$fEmision1 = new DateTime($row['fechaEmision']);
	$hora = new DateTime($row['horaEmision']);
	if( $row['factTipoDocumento']==0) $numInterno++;
	if( $row['factTipoDocumento']==1) $numFacturas++;
	if( $row['factTipoDocumento']==3) $numBoletas++;
	if( $row['factTipoDocumento']==4) $numCredito++;
	if( $row['factTipoDocumento']==5) $numDebito++;
	$sumIgv += $row['IGVFinal'];
	$sumTotales += $row['totalFinal'];
?>
	<tr>
		<td><?= $i; ?></td>

		<td>
			<span class="badge border
			<?= match ((int)$row['factTipoDocumento']) {
				1, 3 => 'text-primary',
				0    => 'text-secondary',
				4, 5 => 'text-warning',
				default => ''
			} ?>"><?= $row['queDoc']; ?></span>
			</td>
		<td class="tdCorrelativo tableexport-string" data-sort-value="<?=  $row['factCorrelativo']; ?>?>"
		data-tipo="<?= $row['factTipoDocumento']?>"
		data-serie="<?= $row['factSerie'] ?>" data-correlativo="<?= $row['factCorrelativo'] ?>">
			<?= ($row['queDoc'] == 'Interno' || $row['queDoc'] == 'Proforma') ? $row['factCorrelativo'] : $row['factSerie'] . "-" . $row['factCorrelativo']; ?>
		</td>
		<?php if (isset($_POST['fecha2']) or isset($_POST['texto'])): ?>
			<td class="fecha" data-sort-value="<?php echo $hora->format('ymd'); ?>"><span class="fechaLatam"><?php echo $fEmision1->format('d/m/Y') ?></span> <?= $hora->format('h:i a'); ?></td>
		<?php else: ?>
			<td class="fecha" data-sort-value="<?php echo $hora->format('Hi'); ?>"><?php echo $hora->format('h:i a'); ?></td>
		<?php endif; ?>

		<td class="text-capitalize"><?= $row['razonSocial']; ?></td>

		<td class="tableexport-string"><?= number_format($row['IGVFinal'], 2); ?></td>
		<td class="tableexport-string"><span class="spTotalPac" data-estado="<?= $row['comprobanteEmitido']; ?>"><?= number_format($row['totalFinal'], 2); ?></span></td>

		<td><?= ($row['esContado'] == '1') ? 'Contado' : 'Crédito'; ?></td>
		<td><?= number_format(($row['esContado'] == '1') ? '0' : $row['totalFinal'] - $row['adelanto'], 2); ?> </td>
		<td class="text-capitalize">
			<?php if ($row['comprobanteEmitido'] == 1) {
			?><span class='badge border border-secondary text-secondary'> <i class="bi bi-hourglass"></i> <?= $row['comprobanteEmitidoDescr'] ?> </span>
			<?php
			} else if (in_array($row['comprobanteEmitido'], [2, 4])) { ?>
				<span class='badge border border-danger text-danger'> <i class="bi bi-x"></i> <?= $row['comprobanteEmitidoDescr'] ?></span> <br><small class='text-danger'><?= $row['motivoBaja'] ?></small> <?php } else if ($row['comprobanteEmitido'] == 3) { ?>
				<span class='badge border border-success text-success'><i class="bi bi-check"></i> <?= $row['comprobanteEmitidoDescr'] ?></span>
				<p class='text-muted mb-0'><?= $row['observaciones'] ?></p>
			<?php	
				} else {
					if ($row['factSerie'] != '') {
						echo "<span class='badge badge-secondary'><i class='icofont-spinner-alt-2'></i> " . $row['comprobanteEmitidoDescr'] . "</span>";
					}
				}
			?>
		</td>
		<?php
		if ($esReporte == 0)
			if (in_array($row['factTipoDocumento'], $comprobantes)) { ?>
			<td data-caso="<?= $row['factTipoDocumento']; ?>" data-serie="<?= $row['factSerie']; ?>" data-correlativo="<?= $row['factCorrelativo']; ?>"  data-tipo="<?= $row['factTipoDocumento'] ?>" style="display: flex;">
				<?php
				if ($row['comprobanteEmitido'] == 0 && $fecha == date('Y-m-d')) { ?>
					<button class="btn btn-outline-primary btn-sm border border-light btnGenComprobante" data-ticket="<?= $row['idTicket']; ?>" data-toggle="tooltip" data-placement="top" title="Generar comprobante"><i class="icofont-flag"></i></button>
				<?php } 
				if ($row['comprobanteEmitido'] == 1) { ?>
					<button class="btn btn-outline-edit btn-sm border border-light" data-toggle="modal" data-target="#modalEditarCampos"
						data-id="<?= $row['idComprobante'] ?>"
						data-ruc="<?= $row['dniRUC'] ?>"
						data-razon="<?= $row['razonSocial'] ?>"
						data-direccion="<?= $row['cliDireccion'] ?>"
						data-tipo="<?= $row['factTipoDocumento'] ?>"
						title="Editar campos"><i class="bi bi-pencil-square"></i></button>
						<?php } 
				if (in_array($row['comprobanteEmitido'], [1, 3])) { ?>
					<button class="btn btn-outline-warning btn-sm border border-light imprTicketFuera" data-toggle="tooltip" data-placement="top" title="Imprimir ticket"><i class="bi bi-sticky-fill"></i></button>
					<button class="btn btn-outline-secondary btn-sm border border-light imprA4Fuera d-none d-sm-block" data-toggle="tooltip" data-placement="top" title="Imprimir A4"><i class="bi bi-printer"></i></button>
					<button class="btn btn-outline-secondary btn-sm border border-light imprPDFFuera d-block d-sm-none" data-toggle="tooltip" data-placement="top" title="Imprimir PDF"><i class="bi bi-printer"></i></button>
					<!-- Boton compartir -->
					<button class="btn btn-outline-primary btn-sm border border-light  d-block d-sm-none" onclick="compartir(`<?= $row['factSerie'] ?>`, `<?= $row['factCorrelativo']; ?>`)" data-toggle="tooltip" data-placement="top" title="Compartir"><i class="bi bi-share"></i></button>
					<button class="btn btn-outline-primary btn-sm border border-light " data-toggle="modal" data-target="#modalCompartirPc" onclick="compartirPc(`<?= $row['factSerie'] ?>`, `<?= $row['factCorrelativo']; ?>`)" data-toggle="tooltip" data-placement="top" title="Compartir Pc"><i class="bi bi-share"></i></button>
					<!-- Fin Boton compartir -->

					<?php if ($_COOKIE['ckPower'] == 1) { ?>
						<button class="btn btn-outline-danger btn-sm border border-light btnDarBajas" data-toggle="tooltip" data-placement="top" title="Dar de baja" data-boleta="<?= $row['factTipoDocumento']; ?>" data-baja="<?= $row['idComprobante']; ?>"><i class="bi bi-box-arrow-in-down"></i></button>

				<?php }
				} else {?>
					<button class="btn btn-outline-secondary btn-sm border border-light imprA4Fuera" data-toggle="tooltip" data-placement="top" title="Imprimir A4"><i class="bi bi-printer"></i></button>
					<?php
				}
				?>
			</td>

		<?php } else { ?>
			<td data-caso="<?= $row['factTipoDocumento']; ?>" data-serie="<?= $row['factSerie']; ?>" data-correlativo="<?= $row['factCorrelativo']; ?>"  data-tipo="<?= $row['factTipoDocumento'] ?>" style="white-space: nowrap;">
				<?php if($row['factTipoDocumento'] <> 4 and $row['factTipoDocumento']<>5): ?>
				<button class="btn btn-outline-warning btn-sm border border-light imprTicketFuera" data-toggle="tooltip" data-placement="top" title="Imprimir ticket"><i class="bi bi-sticky-fill"></i></button>
				<?php endif; ?>
				<button class="btn btn-outline-secondary btn-sm border border-light imprA4Fuera" data-toggle="tooltip" data-placement="top" title="Imprimir A4"><i class="bi bi-printer"></i></button>
				<?php if ($row['comprobanteEmitido'] == 0) { //tipo = interno 
				?>
					<button class="btn btn-outline-warning btn-sm border border-light " onclick="borrarExtra('<?= $row['idComprobante'] ?>')" data-toggle="tooltip" data-placement="top" title="Borrar interno"><i class="bi bi-patch-minus"></i></button>
					<button class="btn btn-outline-primary btn-sm border border-light " onclick="prepararTransformacion('<?= $row['idComprobante'] ?>')" data-toggle="tooltip" data-placement="top" title="Convertir en..."><i class="bi bi-chevron-double-up"></i></button>
				<?php } ?>
				<!-- Boton compartir -->
				<button class="btn btn-outline-primary btn-sm border border-light " data-toggle="modal" data-target="#modalCompartirPc" onclick="compartirPc(`<?= $row['factSerie'] ?>`, `<?= $row['factCorrelativo']; ?>`)" data-toggle="tooltip" data-placement="top" title="Compartir Pc"><i class="bi bi-share"></i></button>
				<!-- Fin Boton compartir -->
			</td>
		<?php } ?>
	</tr>
<?php $i++;
}
?>
	</tbody>
</table>
<div class="my-3 container mx-auto" id="resumenTable" >
	<div class="card">
		<div class="card-body">
			<?php if($numero>0):?>
				<div class="row row-cols-4">
				<div class="col">
					<p class="mb-0"><strong>Comprobantes:</strong> <span class="spanResultado"><?=  $i-1 ?></span></p>
					<p class="mb-0"><strong>Venta interna:</strong> <span class="spanResultado"><?=  $numInterno ?></span></p>
				</div>
				<div class="col">
					<p class="mb-0"><strong>Facturas:</strong> <span class="spanResultado"><?=  $numFacturas ?></span></p>
					<p class="mb-0"><strong>Boletas:</strong> <span class="spanResultado"><?=  $numBoletas ?></span></p>
				</div>
				<div class="col">
					<p class="mb-0"><strong>N. Crédito:</strong> <span class="spanResultado"><?=  $numCredito ?></span></p>
					<p class="mb-0"><strong>N. Débito:</strong> <span class="spanResultado"><?=  $numDebito ?></span></p>
				</div>
				<div class="col">
					<p class="mb-0"><strong>Suma IGV:</strong> <span class="spanResultado">S/ <?=  number_format($sumIgv, 2) ?></span></p>
					<p class="mb-0"><strong>Suma Totales:</strong> <span class="spanResultado">S/ <?=  number_format($sumTotales, 2) ?></span></p>
				</div>
			</div>
			<?php else:?>
				<p><strong>Comprobantes:</strong> 0</p>
			<?php endif;?>
		</div>
	</div>
</div>