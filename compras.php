<?php
include 'php/conexion.php';
include "generales.php";

if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.php");
	die(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Compras - Facturador electrónico</title>
	<?php include 'headers.php'; ?>
</head>
<body class="pb-5">
<style>
.bg-dark {
	background-color: #7531d4!important;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance:textfield;
}
.bootstrap-select .dropdown-toggle .filter-option, .iconPlaceholder{font-family:'Icofont', 'Segoe UI';}
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
#imgLogo{max-width:250px;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
    border-radius: .25rem;}
thead tr th{cursor: pointer;}
.dropdown-item .text, .bootstrap-select button{text-transform: capitalize;}
.inputValido{border-color: #45c763!important;}
.inputInvalido{border-color: #ff1d1d!important;}
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.75);
    z-index: 1051;
}
#overlay .text{position: absolute;
    top: 50%;
    left: 50%;
    font-size: 18px;
    color: white;
    user-select: none;
    transform: translate(-50%,-50%);
}
</style>

<?php include 'menu-wrapper.php'; ?>

<section id="seccionPrincipal">
	<div class="container-fluid mt-5 px-5">
		<div class="row">
		<div class="col-md-3 text-center">
			<img src="<?= $_COOKIE['logo'];?>" class='img-fluid mx-auto'>
		</div>
		<div class="col ml-4">
			<h3 class="display-4" style="font-size: 2.5rem;">Gestión de compras</h3>
			<small class="text-muted"><i class="bi bi-person"></i> Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
		</div></div>
		<div class="d-flex justify-content-between">
		<div>
			<span><i class="bi bi-funnel"></i> Filtro: </span>
			<select class="selectpicker" data-live-search="false" id="sltFiltroMes" title="&#xed12; Mes">
					<option value="01">Enero</option>
					<option value="02">Febrero</option>
					<option value="03">Marzo</option>
					<option value="04">Abril</option>
					<option value="05">Mayo</option>
					<option value="06">Junio</option>
					<option value="07">Julio</option>
					<option value="08">Agosto</option>
					<option value="09">Septiembre</option>
					<option value="10">Octubre</option>
					<option value="11">Noviembre</option>
					<option value="12">Diciembre</option>
				</select>
				<select class="selectpicker" data-live-search="false" id="sltFiltroAnio" title="&#xed12; Año">
				<?php for($i=2019; $i<= date('Y'); $i++ ){ ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
				<?php } ?>
				</select>
				<button class="btn btn-outline-primary " id="buscarCompraFecha" ><i class="bi bi-search"></i></button>
		</div>
			<a class="btn btn-outline-primary " href="nueva-compra.php"><i class="bi bi-cart-plus"></i> Generar nueva compra</a>
		</div>

		<div class="table-responsive">
		<table class="table table-hover mt-3" id="tblCompras">
			<thead>
				<tr>
					<th data-sort="int"><i class="bi bi-arrows-expand"></i> N°</th>
					<th data-sort="string"><i class="bi bi-arrows-expand"></i> Proveedor</th>
					<th data-sort="string"><i class="bi bi-arrows-expand"></i> Tipo</th>
					<th data-sort="string"><i class="bi bi-arrows-expand"></i> Serie</th>
					<th data-sort="string"><i class="bi bi-arrows-expand"></i> Fecha</th>
					<th data-sort="float"><i class="bi bi-arrows-expand"></i> Exonerado</th>
					<th data-sort="float"><i class="bi bi-arrows-expand"></i> SubTotal</th>
					<th data-sort="float"><i class="bi bi-arrows-expand"></i> I.G.V.</th>
					<th data-sort="float"><i class="bi bi-arrows-expand"></i> Total</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if(!isset($_GET['fecha'])){$fecha = "date_format(now(), '%Y-%m')";}else{ $fecha = "'".$_GET['fecha']."'";}
				$i=1;
				$sqlCompr="SELECT c.`idCompra`, cli.cliRazonSocial, co.compDescripcion, date_format(`compFecha`, '%d/%m/%Y') as compFecha, `compSerie`, `compFechaRegistro`, c.`idMoneda`, `compCambioMoneda`, `idProveedor`, `comObs`, `idUsuario`, `compActivo`,
				concat(m.monSimbolo, ' ', round(`compExonerado`,2)) as compExonerado, concat(m.monSimbolo, ' ',round(`compSubTotal`,2)) as compSubTotal, concat(m.monSimbolo, ' ', round(`compIgv`,2)) as compIgv, concat(m.monSimbolo, ' ', round(`compTotal`,2)) as compTotal
				FROM `compras` c inner join moneda m on m.idMoneda = c.`idMoneda`
				inner join comprobante co on co.idComprobante = c.idComprobante
				inner join clientes cli on cli.idCliente = c.idProveedor
				where date_format(compFecha, '%Y-%m') = $fecha and c.compActivo = 1
				order by compFechaRegistro desc";
				$resultadoCompr=$cadena->query($sqlCompr);
				while($rowCompr=$resultadoCompr->fetch_assoc()){ ?>
					<tr data-id="<?= $rowCompr['idCompra']; ?>">
						<td><?= $i;?></td>
						<td class="text-capitalize"><?= $rowCompr['cliRazonSocial']; ?></td>
						<td><?= $rowCompr['compDescripcion']; ?></td>
						<td><?= $rowCompr['compSerie']; ?></td>
						<td><?= $rowCompr['compFecha']; ?></td>
						<td><?= $rowCompr['compExonerado']; ?></td>
						<td><?= $rowCompr['compSubTotal']; ?></td>
						<td><?= $rowCompr['compIgv']; ?></td>
						<td><?= $rowCompr['compTotal']; ?></td>
						<td>
							<button class="btn btn-outline-info btn-sm border-0 btnVerCompra" title="Ver detalle"><i class="bi bi-eye"></i></button>
							<button class="btn btn-outline-primary btn-sm border-0 btnEditarCompra" title="Editar"><i class="bi bi-pencil"></i></button>
							<button class="btn btn-outline-danger btn-sm border-0 btnBorrarCompra" title="Eliminar"><i class="bi bi-trash"></i></button>
						</td>
					</tr>
				<?php $i++; }
			?>
			</tbody>
		</table>
		</div>
	</div>
</section>

<footer class="bg-dark p-3 text-white text-center mt-1 fixed-bottom">
	<p class="mb-0"><i class="bi bi-bookmark"></i>  <small><?php include 'php/version.php';?></small></p>
	<p class="mb-1"><i class="bi bi-bookmark"></i> Facturador Sunat 2.1</p>
</footer>

<!-- Modal para ver detalle de compra -->
<div class="modal fade" id="modalVerCompra" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bi bi-eye"></i> Detalle de Compra</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row mb-3">
					<div class="col-sm-6"><strong>Proveedor:</strong> <span id="detRazonSocial"></span></div>
					<div class="col-sm-6"><strong>RUC:</strong> <span id="detRuc"></span></div>
					<div class="col-sm-6"><strong>Dirección:</strong> <span id="detDireccion"></span></div>
					<div class="col-sm-6"><strong>Documento:</strong> <span id="detDocumento"></span></div>
					<div class="col-sm-4"><strong>Serie:</strong> <span id="detSerie"></span></div>
					<div class="col-sm-4"><strong>Fecha:</strong> <span id="detFecha"></span></div>
					<div class="col-sm-4"><strong>Moneda:</strong> <span id="detMoneda"></span></div>
					<div class="col-12"><strong>Observaciones:</strong> <span id="detObs"></span></div>
				</div>
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Producto</th>
								<th>Cant.</th>
								<th>Unidad</th>
								<th>P.Unit</th>
								<th>SubTotal</th>
							</tr>
						</thead>
						<tbody id="detTbody"></tbody>
					</table>
				</div>
				<div class="text-right">
					<p>Exonerado: <strong><span id="detExonerado"></span></strong></p>
					<p>SubTotal: <strong><span id="detSubTotal"></span></strong></p>
					<p>IGV: <strong><span id="detIgv"></span></strong></p>
					<p>Total: <strong><span id="detTotal"></span></strong></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal para editar compra -->
<div class="modal fade" id="modalEditarCompra" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bi bi-pencil"></i> Editar Compra</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="editIdCompra">
				<div class="row">
					<div class="col-sm-6 form-group">
						<label>Comprobante:</label>
						<select class="selectpicker" id="editDocumento" title="Comprobante">
							<option value="1">Factura</option>
							<option value="3">Boleta de venta</option>
							<option value="7">Nota de crédito</option>
							<option value="12">Ticket</option>
							<option value="9">Guía de Remisión</option>
						</select>
					</div>
					<div class="col-sm-6 form-group">
						<label>Serie y correlativo:</label>
						<input type="text" class="form-control text-uppercase" id="editSerie" style="text-transform:uppercase" oninput="this.value=this.value.toUpperCase()">
					</div>
					<div class="col-sm-6 form-group">
						<label>Fecha:</label>
						<input type="date" class="form-control" id="editFecha">
					</div>
					<div class="col-sm-6 form-group">
						<label>Moneda:</label>
						<select class="selectpicker" id="editMoneda" title="Moneda">
							<option value="1">Soles</option>
							<option value="2">Dólares</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 form-group">
						<label>RUC:</label>
						<input type="text" class="form-control" id="editRuc">
					</div>
					<div class="col-sm-6 form-group">
						<label>Razón Social:</label>
						<input type="text" class="form-control" id="editRazonSocial">
					</div>
					<div class="col-sm-6 form-group">
						<label>Dirección:</label>
						<input type="text" class="form-control" id="editDireccion">
					</div>
					<div class="col-sm-6 form-group">
						<label>Observaciones:</label>
						<input type="text" class="form-control" id="editObs">
					</div>
				</div>
				<hr>
				<h6>Detalle de productos</h6>
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<thead>
							<tr>
								<th>Producto</th>
								<th>Cant.</th>
								<th>P.Unit</th>
								<th>SubTotal</th>
								<th>@</th>
							</tr>
						</thead>
						<tbody id="editDetTbody"></tbody>
					</table>
				</div>
				<div class="text-right mt-2">
					<p>Total: <strong><span id="editTotalText">0.00</span></strong></p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-success" id="btnGuardarEdicion"><i class="bi bi-save"></i> Guardar cambios</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal confirmar borrar -->
<div class="modal fade" id="modalBorrarCompra" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><i class="bi bi-trash"></i> Eliminar compra</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>¿Está seguro que desea eliminar esta compra?</p>
				<p class="text-danger">Los registros de stock asociados se mantendrán.</p>
				<input type="hidden" id="deleteIdCompra">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-outline-danger" id="btnConfirmarBorrar"><i class="bi bi-trash"></i> Eliminar</button>
			</div>
		</div>
	</div>
</div>

<?php include 'modals-emision.php'; ?>
<?php include "php/modal.php"; ?>
<?php include "footer.php"; ?>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	$('[data-toggle="tooltip"]').tooltip();
	$('table').stupidtable();
});

$('#buscarCompraFecha').click(()=>{
	var mes = $('#sltFiltroMes').selectpicker('val');
	var anio = $('#sltFiltroAnio').selectpicker('val');
	window.location.href = 'compras.php?fecha='+anio+'-'+mes;
});

/* =========== VER DETALLE =========== */
$('#tblCompras').on('click', '.btnVerCompra', function() {
	var idCompra = $(this).closest('tr').attr('data-id');
	$.ajax({url: 'php/compras.php', type: 'POST', data: {action: 'obtener', idCompra: idCompra}}).done(function(resp) {
		var data = JSON.parse(resp);
		var c = data.cabecera;
		$('#detRazonSocial').text(c.cliRazonSocial);
		$('#detRuc').text(c.cliRuc);
		$('#detDireccion').text(c.cliDomicilio || '-');
		$('#detDocumento').text(c.compDescripcion);
		$('#detSerie').text(c.compSerie);
		$('#detFecha').text(c.compFecha);
		$('#detMoneda').text(c.monSimbolo);
		$('#detObs').text(c.comObs || '-');
		$('#detExonerado').text(c.monSimbolo + ' ' + parseFloat(c.compExonerado).toFixed(2));
		$('#detSubTotal').text(c.monSimbolo + ' ' + parseFloat(c.compSubTotal).toFixed(2));
		$('#detIgv').text(c.monSimbolo + ' ' + parseFloat(c.compIgv).toFixed(2));
		$('#detTotal').text(c.monSimbolo + ' ' + parseFloat(c.compTotal).toFixed(2));

		var tbody = '';
		$.each(data.detalle, function(i, d) {
			tbody += '<tr>' +
				'<td>' + (i+1) + '</td>' +
				'<td class="text-capitalize">' + d.prodDescripcion + '</td>' +
				'<td>' + parseFloat(d.comdCantidad) + '</td>' +
				'<td>' + d.undCorto + '</td>' +
				'<td>' + parseFloat(d.comdPrecioUnit).toFixed(2) + '</td>' +
				'<td>' + parseFloat(d.comdSubTotal).toFixed(2) + '</td>' +
				'</tr>';
		});
		$('#detTbody').html(tbody);
		$('#modalVerCompra').modal('show');
	});
});

/* =========== EDITAR =========== */
$('#tblCompras').on('click', '.btnEditarCompra', function() {
	var idCompra = $(this).closest('tr').attr('data-id');
	$('#editIdCompra').val(idCompra);

	$.ajax({url: 'php/compras.php', type: 'POST', data: {action: 'obtener', idCompra: idCompra}}).done(function(resp) {
		var data = JSON.parse(resp);
		var c = data.cabecera;

		$('#editDocumento').selectpicker('val', c.idComprobante).selectpicker('refresh');
		$('#editSerie').val(c.compSerie);
		$('#editFecha').val(moment(c.compFecha, 'DD/MM/YYYY').format('YYYY-MM-DD'));
		$('#editMoneda').selectpicker('val', c.idMoneda).selectpicker('refresh');
		$('#editRuc').val(c.cliRuc);
		$('#editRazonSocial').val(c.cliRazonSocial);
		$('#editDireccion').val(c.cliDomicilio || '');
		$('#editObs').val(c.comObs || '');

		var tbody = '';
		var total = 0;
		$.each(data.detalle, function(i, d) {
			var sub = parseFloat(d.comdSubTotal);
			total += sub;
			tbody += '<tr data-idprod="' + d.idProducto + '" data-afecto="' + d.idGravado + '" data-und="' + d.undSunat + '">' +
				'<td class="text-capitalize">' + d.prodDescripcion + '</td>' +
				'<td><input type="number" class="form-control form-control-sm editCant" value="' + parseFloat(d.comdCantidad) + '" step="0.01"></td>' +
				'<td><input type="number" class="form-control form-control-sm editPrecio" value="' + parseFloat(d.comdPrecioUnit).toFixed(2) + '" step="0.01"></td>' +
				'<td class="editSubTotal">' + sub.toFixed(2) + '</td>' +
				'<td><button class="btn btn-outline-danger btn-sm border-0 editBorrarFila"><i class="bi bi-x"></i></button></td>' +
				'</tr>';
		});
		$('#editDetTbody').html(tbody);
		$('#editTotalText').text(total.toFixed(2));
		$('#modalEditarCompra').modal('show');
	});
});

$('#editDetTbody').on('keyup', '.editCant, .editPrecio', function() {
	var row = $(this).closest('tr');
	var cant = parseFloat(row.find('.editCant').val()) || 0;
	var prec = parseFloat(row.find('.editPrecio').val()) || 0;
	var sub = cant * prec;
	row.find('.editSubTotal').text(sub.toFixed(2));
	var total = 0;
	$('#editDetTbody .editSubTotal').each(function() {
		total += parseFloat($(this).text()) || 0;
	});
	$('#editTotalText').text(total.toFixed(2));
});

$('#editDetTbody').on('click', '.editBorrarFila', function() {
	$(this).closest('tr').remove();
	var total = 0;
	$('#editDetTbody .editSubTotal').each(function() {
		total += parseFloat($(this).text()) || 0;
	});
	$('#editTotalText').text(total.toFixed(2));
});

$('#btnGuardarEdicion').click(function() {
	var idCompra = $('#editIdCompra').val();
	var productos = [];
	$('#editDetTbody tr').each(function() {
		var cant = $(this).find('.editCant').val();
		var prec = $(this).find('.editPrecio').val();
		productos.push({
			idProd: $(this).attr('data-idprod'),
			cantidad: cant,
			precUnit: prec,
			afecto: $(this).attr('data-afecto'),
			unidad: $(this).attr('data-und')
		});
	});

	var total = 0;
	$('#editDetTbody .editSubTotal').each(function() {
		total += parseFloat($(this).text()) || 0;
	});
	var exonerado = 0;
	var gravado = total;
	var subtotal = gravado / 1.18;
	var igv = gravado - subtotal;

	$.ajax({url: 'php/compras.php', type: 'POST', data: {
		action: 'update',
		idCompra: idCompra,
		idComprobante: $('#editDocumento').selectpicker('val'),
		compFecha: $('#editFecha').val(),
		serie: $('#editSerie').val(),
		idMoneda: $('#editMoneda').selectpicker('val'),
		monedaCambio: '0.00',
		ruc: $('#editRuc').val(),
		razonSocial: $('#editRazonSocial').val(),
		domicilio: $('#editDireccion').val(),
		compObs: $('#editObs').val(),
		sumExonerado: exonerado.toFixed(2),
		sumSubtotal: subtotal.toFixed(2),
		sumIgv: igv.toFixed(2),
		sumTotal: total.toFixed(2),
		jsonProductos: productos
	}}).done(function(resp) {
		if (resp == 'ok') {
			$('#modalEditarCompra').modal('hide');
			$('#h5Detalle').text('Compra actualizada correctamente');
			$('#modalGuardadoExitoso').modal('show').on('hidden.bs.modal', function() {
				location.reload();
			});
		} else {
			alertify.error('Error al actualizar: ' + resp);
		}
	});
});

/* =========== ELIMINAR =========== */
$('#tblCompras').on('click', '.btnBorrarCompra', function() {
	var idCompra = $(this).closest('tr').attr('data-id');
	$('#deleteIdCompra').val(idCompra);
	$('#modalBorrarCompra').modal('show');
});

$('#btnConfirmarBorrar').click(function() {
	var idCompra = $('#deleteIdCompra').val();
	$.ajax({url: 'php/compras.php', type: 'POST', data: {action: 'borrar', idCompra: idCompra}}).done(function(resp) {
		if (resp == 'ok') {
			$('#modalBorrarCompra').modal('hide');
			$('tr[data-id="' + idCompra + '"]').remove();
			alertify.message('Compra eliminada');
		} else {
			alertify.error('Error al eliminar');
		}
	});
});
</script>

<script>
	$.decimalSuper = <?= json_encode($decimalesSuper) ?>;
	$.porcentajeIGV1 = <?= json_encode($porcentajeIGV1) ?>;
	$.casaHost = <?= json_encode($casaHost) ?>;
</script>
<script src="js/emision.js"></script>
<?php include "piePagina.php"; ?>
</body>
</html>
