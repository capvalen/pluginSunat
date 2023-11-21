<?php
include 'php/conexion.php';
include "generales.php";

if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.html");
	die(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Facturador electrónico - Desarrollado por: Infocat Soluciones</title>
	<?php include 'headers.php'; ?>

</head>
<body>

<?php include 'menu-wrapper.php'; ?>

<div class="container d-none">
	<section>
		<h1 class="text-center my-4">Sistema de emisión de comprobantes 1.0</h1>
	</section>
	<section id="cuerpoBotones">
		<div class="container">
			<div class="row">
			<div class="col-sm-12 mx-5 px-5">
				<button class="btn btn-outline-success btn-block btn-lg my-4">Emitir Comprobante</button>
				<button class="btn btn-outline-warning btn-block btn-lg my-4">Consultar comprobante</button>
				<button class="btn btn-outline-dark btn-block btn-lg my-4 d-none">Modificar serie de comprobante</button>
			</div>
			</div>
		</div>
	</section>
</div>
<section>
	<div class="container-fluid mt-5 mb-5 ">
		<div class="row">
			<div class="col-md-3 text-center">
				<img src="<?= $_COOKIE['logo'];?>" class='img-fluid mx-auto'>
			</div>
			<div class="col ml-4">
				<h3 class="display-4">Facturación Electrónica</h3>
				<small class="text-muted"><i class="bi bi-person"></i> Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
				<div class="row d-flex justify-content-between">
					<div class="col-sm-3"><small class="text-muted"><i class="bi bi-calendar2-event"></i> Filtro por fecha</small><input type="date" class="form-control text-center" id="fechaFiltro"></div>
					<div class="col-sm-3"><small class="text-muted"><i class="bi bi-funnel"></i> Filtro texto</small><input type="text" autocomplete="off" class="form-control" id="txtFiltro"></div>
					<div class="col-sm-2"><button class="btn btn-outline-primary" id="btnRefresh"><i class="bi bi-arrow-clockwise"></i> Actualizar</button></div>
				</div>
			</div>
			
		</div>
		<div class="container mx-auto mt-4 row" style="color: #7030a0">
			<div class="col"><strong>N° Comprobantes: <span id="strCantdad"></span></strong></div>
			<div class="col"><strong>Venta total: S/ <span id="strTotal"></span></strong></div>
		</div>
		
		<div class="table-responsive">
			<table class="table table-hover mt-3 mb-5 pb-5" id="tablaPrincipal">
				<thead>
					<tr>
						<th data-sort="int"><i class="bi bi-arrow-down-short"></i> N°</th>
						<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Tipo</th>
						<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Código</th>
						<th data-sort="int"><i class="bi bi-arrow-down-short"></i> Hora</th>
						<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Cliente</th>
						<th data-sort="float"><i class="bi bi-arrow-down-short"></i> I.G.V.</th>
						<!-- <th data-sort="float"><i class="bi bi-arrow-down-short"></i> Monto</th> -->
						<th data-sort="float"><i class="bi bi-arrow-down-short"></i> Total</th>
						<th data-sort="string"><i class="bi bi-arrow-down-short"></i> Estado</th>
						<th>@</th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
						<td>1</td>
						<td>20550-88</td>
						<td>Factura</td>
						<td>3:05 p.m.</td>
						<td>Cliente sin DNI</td>
						<td>55.00</td>
						<td>Emitido</td>
					</tr> -->
				</tbody>
			</table>
		</div>
	</div>
</section>

<footer class="bg-dark p-3 text-white text-center mt-1 ">
	<p class="mb-0"><i class="bi bi-bookmark"></i>  <small><?php include 'php/version.php';?></small></p>
	<p class="mb-1"><i class="bi bi-bookmark"></i> Facturador SFS 2.0</p>
</footer>

<div class="modal fade" id="modalArchivoBien" tabindex="-1" role="dialog" data-backdrop="static" >
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Guardado exitoso</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Comprobante generado correctamente. ¿Qué deseas hacer a continuación?</p>
				<button class="btn btn-outline-primary" id="btnPrintTicketera"><i class="bi bi-clipboard2"></i> Imprimir en ticketera</button>
				<button class="btn btn-outline-success d-none d-sm-block" id="btnPrintA4"><i class="bi bi-printer"></i> Generar A4</button>
				<button class="btn btn-outline-success d-block d-sm-none" id="btnPrintPDF"><i class="bi bi-printer"></i> Generar PDF</button>

			</div>
			<div class="modal-footer d-none">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">ok</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal para Emitir Boleta -->
<div class="modal fade" id="modalEmisionBoleta" tabindex="-1" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="bi bi-x"></i>
				</button>
				<h4 class="py-3 hTitulo"><i class="bi bi-clipboard2"></i> Generar: <span id="queGenero"></span> Electrónica</h4>
				<div class="row">
					<div class="col">
						<div class="checkbox checkbox-success mb-3">
							<input id="checkbox2" class="styled" type="checkbox" id="chkFecha" onchange="mostrarFecha()">
							<label for="checkbox2">Fecha</label>
						</div>
					</div>
					<div class="col">
						<!-- <div class="form-check mb-3">
							<input class="form-check-input" type="checkbox" value="" id="chkSerie" >
							<label class="form-check-label" for="chkSerie" >Serie</label>
						</div> -->
						<div class="checkbox checkbox-success mb-3">
							<input id="checkbox3" class="styled" type="checkbox" id="chkSerie" onchange="mostrarSeries()">
							<label for="checkbox3">Serie</label>
						</div>
					</div>
					<div class="col">
						<div class="checkbox checkbox-success mb-3">
							<input id="chkCreditos" class="styled" type="checkbox" id="chkPago" onchange="mostrarCreditos()">
							<label for="chkCreditos">Pago al contado</label>
						</div>
					</div>
				</div>
				<div class="card d-none mb-2" id="cardAtributos">
					<div class="card-body form-inline">
						<div class="form-check mb-3 d-none">
							<input class="form-check-input" type="checkbox" value="" id="chkEstadoDni" >
							<label class="form-check-label" id="labelEstadoDni" for="chkEstadoDni" >Cliente anónimo</label>
						</div>
						<div class="form-check mb-3 ml-5 d-none">
							<label for="">Placa de vehículo:</label>
							<input type="text" class='form-control text-uppercase ml-3' placeholder="N° Placa &#xee1e;" id="txtPlacaBoleta">
						</div>
						<div class="form-inline  d-none pl-3">
						<select class="selectpicker" data-live-search="true" id="sltFiltroClientes" title="&#xed12; Filtro de clientes">
							<?php include "php/listarTodosClientes.php";?>
						</select>
						</div>
						<div class="form-inline d-none" id="divFecha">
							<label class="pr-3  text-muted mt-2" for=""><strong>Fecha:</strong></label>
							<input type="date" class="form-control  mr-2" id="txtFechaComprobante">
						</div>
					
						<div class="form-inline d-none" id="divSeries">
							<label class="pr-3 text-muted mt-2" for=""><strong>Serie:</strong></label>
							<div class="dropdown my-3">
							<?php
								$sqlSerieBoleta="SELECT * FROM `fact_series`";
								$resultadoSerieBoleta=$cadena->query($sqlSerieBoleta);
								$rowSerieBoleta=$resultadoSerieBoleta->fetch_assoc();
							?>
							<select class="form-control" id="sltSeriesBoleta">
								<option value="series" selected>Series</option>
								<option id="optBoleta"><?= $rowSerieBoleta['serieBoleta']; ?></option>
								<option id="optFactura"><?= $rowSerieBoleta['serieFactura']; ?></option>
								<option id="optOpcional" disabled><?= $rowSerieBoleta['serieOpcional']; ?></option>
							</select>
							</div>
						</div>
						<div class="form-inline d-none" id="divCreditos">
							<label for="">Fecha de vencimiento:</label>
							<input type="date" class="form-control mx-2" id="txtDateVencimiento">
							<label for="">Crédito S/</label>
							<input type="number" class="form-control mx-2" id="txtMontoCredito">
						</div>
					</div>
				</div>
			
				
				<div id="divDatosCliente" class=" card mb-3">
					<div class="card-body">
						<p class="text-muted "><strong>Datos del cliente:</strong></p>
						<div class="row mb-2">
							<div class="col-4">
								<div class="input-group mb-2">
									<input type="text" class="form-control ml-2 soloNumeros" id="txtDniBoleta" placeholder="Dni o RUC" autocomplete="off">
									<div class="input-group-append">
										<button class="btn btn-outline-secondary" type="button" id="button-addon1" onclick="buscarReniec()"><img src="images/reniec.png" width="16"> Reniec</button>
									</div>
								</div>
							</div>
							<div class="col-8">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtRazonBoleta" value="" placeholder='Razón social o Apellidos y Nombres' autocomplete="off">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtDireccionBoleta" value="" placeholder='Dirección' autocomplete="off">
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<p class="text-muted d-none mb-0"><strong>Detalle:</strong></p>
						<div class="row text-muted">
							<div class="col-6 col-md-4"><strong>Concepto</strong></div>
							<div class="col-6 col-md-2"><strong>Cant.</strong></div>
							<?php if($_COOKIE['facCambiarUnidad']==1): ?>
							<div class="col-6 col-md-1"><strong>Und</strong></div>
							<?php endif;
							if($_COOKIE['facCambiarGravado']==1): ?>
							<div class="col-6 col-md-2"><strong>Gravado.</strong></div>
							<?php endif; ?>
							<div class="col-6 col-md-2"><strong>Precio</strong></div>
							<?php if($_COOKIE['verCantidad']==1):?>
							<div class="col-6 col-md-2 "><strong>Precio Unit.</strong></div>
							<?php endif;?>
							<div class="col-6 col-md-2 d-none"><strong>Sub-Total</strong></div>
						</div>
						<div id="divProductos">
							<?php include "php/filaNueva.php";?>
						</div>
						<button class="btn btn-outline-success btn-sm mt-2" id="btnAgregarProducto"><i class="bi bi-plus-lg"></i> Agregar más produtos</button>
					</div>
				</div>
				<div class='my-3 '>
					<div class="container row row-cols-2 row-cols-md-4 text-center" id="divCalculosFinales"> <!-- align-items-end flex-column -->
						<span><small>Exonerado:</small> <span>S/ <span id="spExoneradoBoleta">0.00</span></span></span>
						<span><small>Sub-Total:</small> <span>S/ <span id="spSubTotBoleta">0.00</span></span></span>
						<span><small>IGV:</small> <span>S/ <span id="spIgvBoleta">0.00</span></span></span>
						<span><small>Total:</small> <strong>S/ <span id="spTotalBoleta">0.00</span></strong></span>
					</div>
				</div>
				
				<div class="container-fluid row mt-3 d-flex justify-content-end">
					<span id="spanErrorFinal" for="" class=" d-none"> <span class="lblError"></span></span>
				</div>
				
				
			
			<div class="container-fluid row d-flex justify-content-end mb-3">
				<div class="row">
					<label for="" class="col-sm-4 col-form-label text-right"><small>Paga con:</small></label>
					<input type="number" class="form-control col-sm-3" id="txtPagaCuanto">
					<label for="" class="col-sm-4 col-form-label d-none"><small>Vuelto: S/<span id="spanVuelto"></span></small></label>
				</div>
				<div class="col mt-2 mt-md-0">
					<button type="button" class="btn btn-outline-success float-right d-none" id="btnEmitirFacturav2" ><i class="bi bi-bookmark-star"></i> Emitir Factura</button>
					<button type="button" class="btn btn-outline-primary float-right" id="btnEmitirBoletav2" ><i class="bi bi-bookmark-star"></i> Emitir Boleta</button>
				</div>
				<div class="container-fluid row mt-3 d-flex justify-content-end d-none" id="">
					<span id="spanLimiteSobrepasado" style="background: #e6330a!important;"><span class=""><i class="bi bi-chat-dots"></i> Se sobrepasó el límite máximo en comprobantes.</span></span>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<!-- Modal para ingresar el N° ticket -->
<div class="modal fade" id="modalIngresoTicket" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5>Generar comprobante</h5>
				<p>N° de Ticket:</p>
				<input type="text" class="form-control text-uppercase text-center my-3 d-none" id="txtNCodNegocio" placeholder='Código de negocio' value="<?= $_COOKIE['ckNegocio'];?>" readonly>
				<input type="text" class="form-control text-uppercase text-center my-3 d-none" id="txtCodLocal" placeholder='Código de local' value="<?= $_COOKIE['ckLocal'];?>" readonly>
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtNumTicket" placeholder='N° de Ticket' value="103420-8">
			</div>
			<div class="modal-footer">
				<div class="container-fluid">
					<div class="row">
						<p for="" class="text-danger "><small class="lblError"></small></p>
					</div>
					<button type="button" class="btn btn-secondary float-right" id="btnConsultarDisponibilidad" >Consultar disponibilidad</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal para consultar el N° ticket -->
<div class="modal fade" id="modalConsultaTicket" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<p>Ingrese los datos de negocio y el N° de Ticket:</p>
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtNCodNegocio2" placeholder='Código de negocio' value="113">
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtCodLocal2" placeholder='Código de local' value="12300">
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtNumTicket2" placeholder='N° de Ticket' value="103420-8">
			</div>
			<div class="modal-footer">
				<div class="container-fluid">
					<div class="row">
						<p for="" class="text-danger "><small class="lblError"></small></p>
					</div>
					<button type="button" class="btn btn-secondary float-right" id="btnConsultarDisponibilidad2" >Consultar</button>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Modal para empezar el proceso B/v-Fact -->
<div class="modal fade" id="modalProcesarComprobante" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<p>Procesos para el Ticket <strong class="text-uppercase"><span id="spanTicket"></span></strong>:</p>
				<button class="btn btn-block btn-outline-primary my-3" id="btnEmitirFactura">Emitir Factura</button>
				<button class="btn btn-block btn-outline-primary my-3" id="btnEmitirBoleta">Emitir Boleta de Venta</button>
				<button class="btn btn-block btn-outline-primary my-3">Generar Nota de Crédito</button>
				<button class="btn btn-block btn-outline-primary my-3">Generar Nota de Pedido</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal para empezar Modificar las series -->
<div class="modal fade" id="modalModSerie" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modificar series</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label for="">Serie de Boletas:</label>
				<input type="text" class="form-control text-center" id="txtSerieBoleta">
				<label for="">Serie de Facturas:</label>
				<input type="text" class="form-control text-center" id="txtSerieFactura">
				<label for="">Serie de Interna:</label>
				<input type="text" class="form-control text-center" id="txtSerieInterna">
			</div>
			<div class="modal-footer">
				<p class="text-danger d-none" id="pError2"></p>
				<button type="button" class="btn btn-primary" id="btnUpdateSeries">Actualizar series</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal para empezar Modificar las precios -->
<div class="modal fade" id="modalModPrecios" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modificar precios</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label for="">Precio de Gasohol 90 Plus:</label>
				<input type="text" class="form-control text-center" id="txtPrecGasoholv2">
				<label for="">Precio de Diesel D5 S-50 UV:</label>
				<input type="text" class="form-control text-center" id="txtPrecDieselv2">
			</div>
			<div class="modal-footer">
				<p class="text-danger d-none" id="pError3"></p>
				<button type="button" class="btn btn-primary" id="btnUpdatePrecios"><i class="bi bi-arrow-clockwise"></i> Actualizar precios</button>
			</div>
		</div>
	</div>
</div>
<?php if($_COOKIE['ckPower']==1){ ?>
<!-- Modal para confirmar la Baja -->
<div class="modal fade" id="modalDarBajas" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Notificación de baja</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<label for="">¿Desea realmente dar de baja el Comprobante <strong id="strComprobante"></strong>?</label>
				<label for="">Ingrese el motivo de la baja:</label>
				<input type="text" class="form-control text-capitalize" id="txtConceptoBaja">
			</div>
			<div class="modal-footer">
				<p class="text-danger d-none" id="pErrorBajas"></p>
				<button type="button" class="btn btn-danger" id="btnDarbaja"><i class="bi bi-download"></i> Dar de Baja</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modalExitoBajas" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<label for="">Comprobante dado de baja exitosamente</label>
				<h5 id="h5ComprobanteBaja"></h5>
			</div>
			<div class="modal-footer">
				<p class="text-danger d-none" id="pError3"></p>
				<button type="button" class="btn btn-success" id="btnDarbaja"  data-dismiss="modal"><i class="bi bi-check-lg"></i> Ok</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal para: -->
<div class='modal fade' id='modalConfirmarBorrar' tabindex='-1'>
	<div class='modal-dialog modal-sm modal-dialog-centered'>
		<div class='modal-content'>
			<div class='modal-body'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'> <span aria-hidden='true'>&times;</span></button>
				<h5 class='modal-title'>Confirmar</h5>
				<p>¿Deseas borrar el comprobante extra?</p>
				<div class='d-flex justify-content-between'>
					<button type='button' class='btn btn-outline-dark' data-dismiss="modal">No</button>
					<button type='button' class='btn btn-outline-danger' onclick="borrarDefinitivamente()" data-dismiss="modal">Sí</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<div id="overlay">
	<div class="text"><span id="hojita"><i class="bi bi-circle-half"></i></span> <p id="pFrase"> Solicitando los datos a Sunat... <br> <span>«Pregúntate si lo que estás haciendo hoy <br> te acerca al lugar en el que quieres estar mañana» <br> Walt Disney</span></p></div>
</div>

<?php include "php/modal.php"; ?>
<?php include "footer.php"; ?>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);

	$.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		console.info( '\033[35mLista de precios:' );
		$.precios = JSON.parse(resp);
		console.log( $.precios );
	});
	$('#fechaFiltro').val( moment().format('YYYY-MM-DD'));
	$('[data-toggle="tooltip"]').tooltip();
	$('#tablaPrincipal tbody').children().remove();

	$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$('#tablaPrincipal tbody').append(resp);
		$('[data-toggle="tooltip"]').tooltip();
		$("#tablaPrincipal").stupidtable();
		sumarGenerados()
	});
	$('#fechaFiltro').change(function() {
		//console.log( moment($('#fechaFiltro').val()).isValid() );
		$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST', data:{fecha: $('#fechaFiltro').val(), fecha2:$('#fechaFiltro').val() } }).done(function(resp) {
			$('#tablaPrincipal tbody').children().remove();
			$('#tablaPrincipal tbody').append(resp).anotherJqueryMethod;
			$('[data-toggle="tooltip"]').tooltip();
			sumarGenerados()
		});
	});
});
function sumarGenerados(){
	var sumaDia =0;
	$.each( $('#tablaPrincipal tbody tr'), function(index, obj){
		//console.log( 'cambio num: '+ $(obj).find('.spTotalPac').text() );
		let caso  = $(obj).find('.spTotalPac');
		if($(caso).attr('data-estado')!='4'){
			sumaDia+= parseFloat( caso.text().replace(',',''));
		}
	});
	$('#strCantdad').text( $('#tablaPrincipal tbody tr').length );
	$('#strTotal').text( parseFloat(sumaDia).toFixed(2) );
	$.sumaDia = sumaDia;
	limiteVentas();
}
/* $('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
}); */
function limiteVentas(){
	//console.log( 'limite' );
	$('#spanLimiteSobrepasado').parent().addClass('d-none');
	$('#spanLimiteSobrepasado').parent().removeClass('d-flex');
	if(isNaN($.sumaDia)){
		$('#strTotal').text( '0.00' );
	}else{
		if( parseFloat($.sumaDia) >= parseFloat(<?= $_COOKIE['limiteFacurado']?>)){
			$('#spanLimiteSobrepasado').parent().removeClass('d-none');	
			$('#spanLimiteSobrepasado').parent().addClass('d-flex');
		}
	}
}

$('#btnEmitirComprobante').click(function() {
	/* $('#txtNCodNegocio').val('');
	$('#txtCodLocal').val('');
	$('#txtNumTicket').val(''); */
	$('#modalIngresoTicket .lblError').text('');
	$('#modalIngresoTicket').modal('show');
});
$('#btnConsultarDisponibilidad').click(function() {
	if( $('#txtNCodNegocio').val()=='' || $('#txtCodLocal').val()=='' || $('#txtNumTicket').val()==''){
		$('#modalIngresoTicket .lblError').text('Debe rellenar todos los datos para procesar su ticket');
	}else{
		
		$('#spanTicket').text($('#txtNumTicket').val());
		$.ajax({url: 'comprobarTicket.php', type: 'POST', data: { local:$('#txtCodLocal').val() , negocio:$('#txtNCodNegocio').val() , ticket:$('#txtNumTicket').val()  }}).done(function(resp) {
			//console.log(resp)
			if( resp == $('#txtNumTicket').val() ){
				$('#modalIngresoTicket').modal('hide');
				$('#modalProcesarComprobante').modal('show');
			}else if(resp =='sin coincidencia'){
				$('#modalIngresoTicket .lblError').text('Datos errados, no coincide con ningún ticket.');
			}else{
				$('#modalIngresoTicket .lblError').text('Hubo un error interno, comuníquelo a su proveedor');
			}
			//
		});
	}
});
$('#btnConsultarDisponibilidad2').click(function() {
	if( $('#txtNCodNegocio2').val()=='' || $('#txtCodLocal2').val()=='' || $('#txtNumTicket2').val()==''){
		$('#modalConsultaTicket .lblError').text('Debe rellenar todos los datos para procesar su ticket');
	}else{
		
		$('#spanTicket2').text($('#txtNumTicket2').val());
		$.ajax({url: 'comprobarTicket.php', type: 'POST', data: { local:$('#txtCodLocal2').val() , negocio:$('#txtNCodNegocio2').val() , ticket:$('#txtNumTicket2').val() }}).done(function(resp) {
			console.log(resp)
			if( resp == $('#txtNumTicket2').val() ){
				$.ajax({url: 'reverificacion.php', type: 'POST', data: { local:$('#txtCodLocal2').val() , negocio:$('#txtNCodNegocio2').val() , ticket:$('#txtNumTicket2').val() }}).done(function(resp) {
					console.log(resp)
					$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
					if($.jTicket.length >=1){
						$('#modalProcesarComprobante').modal('hide');
						$('#modalArchivoBien').modal('show');
						imprimitEnTicketera()
						
					}
				});
				$('#modalConsultaTicket').modal('hide');
				$('#modalArchivoBien').modal('show');
				
			}else if(resp =='sin coincidencia'){
				$('#modalConsultaTicket .lblError').text('Datos errados, no coinciden con ningún local y ticket.');
			}else{
				$('#modalConsultaTicket .lblError').text('Hubo un error interno, comuníquelo a su proveedor');
			}
			//
		});
	}
});
$('#btnConsultarComprobante').click(function() {
	$('#modalConsultaTicket .lblError').text('');
	$('#modalConsultaTicket').modal('show');

});
$('#btnEmitirFactura').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 1, local:$('#txtCodLocal').val() , negocio:$('#txtNCodNegocio').val() , ticket:$('#txtNumTicket').val()  }}).done(function(resp) {
		//console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		if($.jTicket.length >=1){
			$('#modalProcesarComprobante').modal('hide');
			$('#modalArchivoBien').modal('show');
		}
	});
});

$('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, local:$('#txtCodLocal').val() , negocio:$('#txtNCodNegocio').val() , ticket:$('#txtNumTicket').val()  }}).done(function(resp) {
		//console.log(resp)
		$.jTicket = JSON.parse(resp); console.log( $.jTicket );
		if($.jTicket.length >=1){
			$('#modalProcesarComprobante').modal('hide');
			$('#modalArchivoBien').modal('show');
		}
		//if(resp=='fin'){	} 
	});
});
$('#modalArchivoBien').on('hidden.bs.modal', function () { 
	location.reload();
});
$('tbody').on('click', '.imprTicketFuera', function (e) {
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');
	
	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso:caso, serie: serie, correlativo: correlativo }}).done(function(resp) {
		console.log( resp );
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		$.ajax({url: 'http://127.0.0.1/<?= $casaHost; ?>/<?= $_COOKIE['demoFacturador']=="true" ? 'php/printDemoTicket.php' : 'printComprobante.php' ?>', type: 'POST', data: {
			tipoComprobante: $.jTicket[0].tipoComprobante,
			rucEmisor: $.jTicket[0].rucEmisor,
			queEs: $.jTicket[0].queSoy,
			serie: $.jTicket[0].serie,
			correlativo: $.jTicket[0].correlativo,
			tipoCliente: $.jTicket[0].tipoCliente,
			fecha: $.jTicket[0].fechaEmision,
			fechaLat: moment($.jTicket[0].fechaEmision, 'YYYY-MM-DD').format('DD/MM/YYYY'),
			cliente: $.jTicket[0].razonSocial,
			docClient: $.jTicket[0].ruc,
			monedas: $.jTicket[0].letras,
			descuento: parseFloat($.jTicket[0].descuento).toFixed(2),
			costoFinal: parseFloat($.jTicket[0].costoFinal).toFixed(2),
			igvFinal: parseFloat($.jTicket[0].igvFinal).toFixed(2),
			totalFinal: parseFloat($.jTicket[0].totalFinal).toFixed(2),
			productos: $.jTicket[1],
			direccion:$.jTicket[0].direccion,
			exonerado: parseFloat($.jTicket[0].exonerado).toFixed(2),
			/* placa: $.jTicket[0].placa, */
		}}).done(function(resp) {
			console.log(resp)
			//location.reload();
		});
	});

});
$('#btnPrintTicketera').click(function() { console.log( 'ticketera' );
	imprimitEnTicketera()
});
function imprimitEnTicketera(){
	$.ajax({url: 'http://127.0.0.1/<?= $casaHost; ?>/printComprobante.php', type: 'POST', data: {
				tipoComprobante: $.jTicket[0].tipoComprobante,
				rucEmisor: $.jTicket[0].rucEmisor,
				queEs: $.jTicket[0].queSoy,
				serie: $.jTicket[0].serie,
				correlativo: $.jTicket[0].correlativo,
				tipoCliente: $.jTicket[0].tipoCliente,
				fecha: $.jTicket[0].fechaEmision,
				fechaLat: moment($.jTicket[0].fechaEmision, 'YYYY-MM-DD').format('DD/MM/YYYY'),
				cliente: $.jTicket[0].razonSocial,
				docClient: $.jTicket[0].ruc,
				monedas: $.jTicket[0].letras,
				descuento: parseFloat($.jTicket[0].descuento).toFixed(2),
				costoFinal: parseFloat($.jTicket[0].costoFinal).toFixed(2),
				igvFinal: parseFloat($.jTicket[0].igvFinal).toFixed(2),
				totalFinal: parseFloat($.jTicket[0].totalFinal).toFixed(2),
				productos: $.jTicket[1],
				direccion:$.jTicket[0].direccion,
				exonerado: parseFloat($.jTicket[0].exonerado).toFixed(2),
				/* placa: $.jTicket[0].placa, */
			}}).done(function(resp) {
				console.log(resp)
				//location.reload();
			});
}
$('#btnModificarSerie').click(function() {
	$.ajax({url: 'llamarSeries.php', type: 'POST', data: { }}).done(function(resp) {
		var data = JSON.parse(resp)[0];
		console.log( data );
		$('#txtSerieBoleta').val( data.serieBoleta );
		$('#txtSerieFactura').val( data.serieFactura );
		$('#txtSerieInterna').val( data.serieOpcional );
		
		$('#modalModSerie').modal('show');
	});
	
});
$('#btnUpdateSeries').click(function() {
	$('#pError2').addClass('d-none')
	if( $('#txtSerieBoleta').val()=='' || $('#txtSerieFactura').val()=='' || $('#txtSerieInterna').val()=='' ){
		$('#pError2').removeClass('d-none').text('Ambos campos deben estar rellenados');
	}else{
		$.ajax({url: 'updateSeries.php', type: 'POST', data: { serFact: $('#txtSerieFactura').val(), serBol: $('#txtSerieBoleta').val(), serInt: $('#txtSerieInterna').val() }}).done(function(resp) {
			if( resp =='ok' ){
				$('#modalModSerie').modal('hide');
			}else{
				$('#pError2').removeClass('d-none').text('Hubo un error interno al guardar los datos');
			}
		});
	}
});
$('tbody').on('click', '.imprA4Fuera', function (e) {
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso:caso, serie: serie, correlativo: correlativo }}).done(function(resp) {
		console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		window.open( 'printComprobanteA4.php?serie='+encodeURIComponent(serie)+'&correlativo='+encodeURIComponent(correlativo) ,'_blank');
	});
});
$('tbody').on('click', '.imprPDFFuera', function (e) {
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso:caso, serie: serie, correlativo: correlativo }}).done(function(resp) {
		console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		window.open( 'printComprobantePDF.php?serie='+encodeURIComponent(serie)+'&correlativo='+encodeURIComponent(correlativo) ,'_blank');
	});
});
$('#btnPrintA4').click(function() {
	window.open( 'printComprobanteA4.php?serie='+encodeURIComponent($.jTicket[0].serie)+'&correlativo='+encodeURIComponent($.jTicket[0].correlativo) ,'_blank');
	location.reload();
});
$('#btnPrintPDF').click(function() {
	window.open( 'printComprobantePDF.php?serie='+encodeURIComponent($.jTicket[0].serie)+'&correlativo='+encodeURIComponent($.jTicket[0].correlativo) ,'_blank');
	location.reload();
});
$('tbody').on('click', '.btnGenComprobante', function (e) {
	var ticket = $(this).attr('data-ticket');
	//console.log( ticket );
	
	$.ajax({url: 'emision.php', type: 'POST', data: { ticket: ticket }}).done(function(resp) {
		console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		if($.jTicket.length >=1){
			$('#modalProcesarComprobante').modal('hide');
			$('#modalArchivoBien').modal('show');
		}
	});
});
$('#btnRefresh').click(function() {
	location.reload();
});
$('#AEmitirBoleta').click(function() {
	$('#optBoleta').attr('disabled',false);
	$('#optFactura').attr('disabled',true);
	$('#txtDniBoleta').attr('placeholder', 'DNI. o RUC.');
	$('#txtRazonBoleta').attr('placeholder', 'Nombres y apellidos');
	$('#btnEmitirBoletav2').removeClass('d-none');
	$('#btnEmitirFacturav2').addClass('d-none');
	$('#sltSeriesBoleta option').removeAttr('selected');
	$('#optBoleta').attr('selected', true);
	$('#chkEstadoDni').prop('checked', true).change().attr('disabled', false);
	$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'));
	$('#queGenero').text('Boleta de venta');
	$('#modalEmisionBoleta').modal('show');
});
$('#AEmitirFactura').click(function() {
	$('#optBoleta').attr('disabled',true);
	$('#optFactura').attr('disabled',false);
	$('#txtDniBoleta').attr('placeholder', 'R.U.C.');
	$('#txtRazonBoleta').attr('placeholder', 'Razón social');
	$('#btnEmitirBoletav2').addClass('d-none');
	$('#btnEmitirFacturav2').removeClass('d-none');
	$('#optFactura').attr('selected', true);
	$('#chkEstadoDni').prop('checked', false).change().attr('disabled', true);
	$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'));
	$('#queGenero').text('Factura');
	$('#modalEmisionBoleta').modal('show');
});

$('#chkEstadoDni').change(function() {
	if($('#chkEstadoDni').prop('checked')	){
		$('#labelEstadoDni').text('Cliente anónimo');
		//$('#divDatosCliente').addClass('d-none');
		//$('#txtDniBoleta').attr('readonly', true).val('');
		//$('#txtRazonBoleta').attr('readonly', true).val('');
		//$('#txtDireccionBoleta').attr('readonly', true).val('');
		$('.selectpicker').selectpicker('val', -1);
		$('#txtDniBoleta').focus();
	}else{
		$('#labelEstadoDni').text('Cliente con Documento');
		//$('#divDatosCliente').removeClass('d-none');
		//$('#txtRazonBoleta').attr('readonly', false);
		//$('#txtDireccionBoleta').attr('readonly', false);
		//$('#txtDniBoleta').attr('readonly', false).focus();
		$('#txtDniBoleta').focus();
	}
});
$('#divProductos').on('keyup','.campoSubTotal', function() {	
	var padre = $(this).parent().parent();
	var subTotal = 0;
	var precio = parseFloat(padre.find('.campoPrecioUnit').val());
	var cantidad = 0;//parseFloat(padre.find('.campoCantidad').val());
	if($(this).val()!=''){
		subTotal = parseFloat($(this).val());
	}
	cantidad = parseFloat(subTotal/precio);
	if( cantidad==Infinity ){
		cantidad=0;
	}
	padre.find('.campoCantidad').val( cantidad.toFixed(2) );
	sumaTodo();
});
$('#divProductos').on('keyup','.campoPrecioUnit', function() {
	var padre = $(this).parent().parent();
	var precio = 0;
	var cantidad = parseFloat(padre.find('.campoCantidad').val());
	var subTotal = 0;//parseFloat(padre.find('.campoPrecioUnit').val());
	if($(this).val()!=''){
		precio = parseFloat($(this).val());
	}

	subTotal = parseFloat(cantidad*precio);
	padre.find('.campoSubTotal').val( subTotal.toFixed(2) );
	sumaTodo();
});
$('#divProductos').on('keyup','.campoCantidad', function() {
	var padre = $(this).parent().parent();
	var cantidad = 0;
	if($(this).val()!=''){
		cantidad = parseFloat($(this).val());
	}
	var precio = parseFloat(padre.find('.campoPrecioUnit').val());
	var subTotal = 0;//parseFloat(padre.find('.campoPrecioUnit').val());
	subTotal = parseFloat(cantidad*precio);
	padre.find('.campoSubTotal').val( subTotal.toFixed(2) );
	sumaTodo();
});
function sumaTodo() {
	var sumaTotal=0, afectos = 0, exonerados = 0;
	
	$.each( $('.campoSubTotal'), function(i, elem){
		if( $(elem).val()!='' ){
			if( $(elem).attr('data-exonerado')=='1' ){
				afectos+=parseFloat($(elem).val());
			}else{
				exonerados+=parseFloat($(elem).val());
			}
		}
		
	});
	//console.log( sumaTotal );
	sumaTotal=afectos+exonerados;
	var costo = afectos/parseFloat(<?= $porcentajeIGV1; ?>);
	var igv=afectos-costo;
	$('#spExoneradoBoleta').text(parseFloat(exonerados).toFixed(2));
	$('#spSubTotBoleta').text(parseFloat(costo).toFixed(2));
	$('#spIgvBoleta').text(parseFloat(igv).toFixed(2));
	$('#spTotalBoleta').text(parseFloat(sumaTotal).toFixed(2));
	calcularVuelto();
}
/* $('#modalEmisionBoleta').on('shown.bs.modal', function () { 
	$('#txtPlacaBoleta').focus();
}); */
		
		
$('#btnEmitirBoletav2').click(function() {
	
	/* console.log( resuelve() ); */
	pantallaOver(true)
	
	const promesaCompletoTodo = new Promise((resolve, reject) => {
		var truncado = false;
		$.each( $('.cardHijoProducto'), function (i, elem) { 
			
			if( $(elem).find('.sltFiltroProductos').selectpicker('val')=='1' && $(elem).find('.campoTextoLibre').val()=='' ){
				truncado = true;
			}
			if( i== $('.cardHijoProducto').length -1 && truncado ==true ){
				//console.log( 'vacio1' );
				$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Existen conceptos vacíos en uno de los items').parent().removeClass('d-none');
				reject('falta datos');
			}else if( i== $('.cardHijoProducto').length -1 && truncado ==false ){
				//console.log( 'completo todo' );
				$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
				resolve('completo todo')
			}
		});
	});

	promesaCompletoTodo.then(resPromesa => {
		
		if( $('#sltSeriesBoleta').val()=='series'){
			$('#sltSeriesBoleta').focus();
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('#sltTemporal').selectpicker('val')==null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un producto').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('.esMoneda').val()=='0.00' || $('.cardHijoProducto').first().find('.esMoneda').val()==0 || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()=='0.00' || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()==0 ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste ingresar una cantidad / precio').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('#sltfiltroTemporal').selectpicker('val')==null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar una unidad').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('#spTotalBoleta').text()=='0.00' ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none'); pantallaOver(false)	;
		}else if( parseFloat($('#spTotalBoleta').text())>700 && $('#txtDniBoleta').val().length<8 ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Ésta boleta por ser mayor a S/ 700.00 requiere DNI').parent().removeClass('d-none'); pantallaOver(false);
		}
		else{
			var jsonCliente= [];

			if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
				jsonCliente.push({dni: $('#txtDniBoleta').val(),
					razon: $('#txtRazonBoleta').val(),
					direccion: $('#txtDireccionBoleta').val(),
					contado: !document.getElementById('chkCreditos').checked ? 1 : 2, //1:contado, 2:credito
					fechaCredito : $('#txtDateVencimiento').val(),
					adelanto: parseFloat($('#spTotalBoleta').text() -$('#txtMontoCredito').val()),
					montoCredito:$('#txtMontoCredito').val()
				});
			}else{
				jsonCliente.push({
					dni:'00000000',
					razon: 'Cliente sin documento',
					direccion: '',
					contado: !document.getElementById('chkCreditos').checked ? 1 : 2, //1:contado, 2:credito
					fechaCredito : $('#txtDateVencimiento').val(),
					adelanto: parseFloat($('#spTotalBoleta').text() -$('#txtMontoCredito').val()),
					montoCredito:$('#txtMontoCredito').val()
				})
			}
			var jsonProductos = [];
			$.each( $('.cardHijoProducto'), function (i, elem) {
				var productVariable ='';
				if( $(elem).find('.sltFiltroProductos').selectpicker('val')!='' ){
					if($(elem).find('.divNombProducto button').attr('title')=='Libre'){
						productVariable = $(elem).find('.campoTextoLibre').val();
					}else{
						productVariable = $(elem).find('.divNombProducto button').attr('title')
					}
					jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
						descripcionProducto: productVariable,
						precioProducto: $(elem).find('.campoPrecioUnit').val(),
						unidadProducto: $(elem).find('.divUnidadProducto button').attr('title'),
						unidadSunat: $(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val'),
						unidadCorto: $(elem).find(`.sltFiltroUnidad option[value="${$(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val')}"]`).attr('data-unidad') ,
						subtotal: $(elem).find('.campoSubTotal').val(),
						afecto: $(elem).find('#sltFiltroGravado').selectpicker('val'),
						idProd: $(elem).attr('data-producto')
					});
				}
				
			});
			var dniRc ='', razon='';
			if($('#txtDniBoleta').val()!=''){
				dniRc=$('#txtDniBoleta').val();
				razon=$('#txtRazonBoleta').val()
			}else{
				dniRc='00000000';
				razon='Cliente sin documento';
			}
			
			$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 3, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon, cliDireccion: $('#txtDireccionBoleta').val(),jsonProductos: jsonProductos, jsonCliente:jsonCliente, fecha: $('#txtFechaComprobante').val() }}).done(function(resp) { //  placa: $('#txtPlacaBoleta').val(),
				console.log(resp)
				$.jTicket = JSON.parse(resp); console.log( $.jTicket );
				if($.jTicket.length >=1){
					$('#modalEmisionBoleta').modal('hide');
					$('#modalArchivoBien').modal('show');
				}
				pantallaOver(false)
			});
		}

	})

	
});
$('#btnEmitirFacturav2').click(function() {
	pantallaOver(true)

	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	if( $('#sltSeriesBoleta').val()=='series'){
		$('#sltSeriesBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none');
	}/* else if( $('#txtPlacaBoleta').val()==''){
		$('#txtPlacaBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> La placa del automóvil tiene que ser rellenado').parent().removeClass('d-none');
	} */else if( $('#txtDniBoleta').val().length!=11 ){
		$('#txtDniBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> El RUC del cliente, no es correcto').parent().removeClass('d-none');
	}else if( $('#txtRazonBoleta').val()=='' ){
		$('#txtRazonBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> La razón social no puede estar en blanco').parent().removeClass('d-none');
	}else if( $('#spTotalBoleta').text()=='0.00' ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none');
	}else{
		var jsonCliente= [];
		if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
			jsonCliente.push({dni: $('#txtDniBoleta').val(),
				razon: $('#txtRazonBoleta').val(),
				direccion: $('#txtDireccionBoleta').val(),
				contado: !document.getElementById('chkCreditos').checked ? 1 : 2, //1:contado, 2:credito
				fechaCredito : $('#txtDateVencimiento').val(),
				adelanto: parseFloat($('#spTotalBoleta').text() -$('#txtMontoCredito').val()),
				montoCredito:$('#txtMontoCredito').val()
			});
		}else{
			jsonCliente.push({
				dni:'00000000',
				razon: 'Cliente sin documento',
				direccion: '',
				contado: !document.getElementById('chkCreditos').checked ? 1 : 2, //1:contado, 2:credito
				fechaCredito : $('#txtDateVencimiento').val(),
				adelanto: parseFloat($('#spTotalBoleta').text() -$('#txtMontoCredito').val()),
				montoCredito:$('#txtMontoCredito').val()
			})
		}
		var jsonProductos= [];
		$.each( $('.cardHijoProducto'), function (i, elem) {
			if( $(elem).find('.sltFiltroProductos').selectpicker('val')!='' ){
				if($(elem).find('.divNombProducto button').attr('title')=='Libre'){
					productVariable = $(elem).find('.campoTextoLibre').val();
				}else{
					productVariable = $(elem).find('.divNombProducto button').attr('title')
				}
				jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
					descripcionProducto: productVariable,
					precioProducto: $(elem).find('.campoPrecioUnit').val(),
					unidadProducto: $(elem).find('.divUnidadProducto button').attr('title'),
					unidadSunat: $(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val'),
					unidadCorto: $(elem).find(`.sltFiltroUnidad option[value="${$(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val')}"]`).attr('data-unidad') ,
					subtotal: $(elem).find('.campoSubTotal').val(),
					afecto: $(elem).find('#sltFiltroGravado').selectpicker('val'),
					idProd: $(elem).attr('data-producto')
				});
		}
		});
		var dniRc ='', razon='';
		if($('#txtDniBoleta').val()!=''){
			dniRc=$('#txtDniBoleta').val();
			razon=$('#txtRazonBoleta').val()
		}else{
			dniRc='00000000';
			razon='Cliente sin documento';
		}
		$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 1, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon, cliDireccion: $('#txtDireccionBoleta').val(), jsonProductos: jsonProductos, jsonCliente: jsonCliente, fecha: $('#txtFechaComprobante').val() }}).done(function(resp) { // placa: $('#txtPlacaBoleta').val(),
			console.log(resp)
			$.jTicket = JSON.parse(resp); console.log( $.jTicket );
			if($.jTicket.length >=1){
				$('#modalEmisionBoleta').modal('hide');
				$('#modalArchivoBien').modal('show');
			}
			pantallaOver(false)
		});
	}
});
$('#btnModificarPrecios').click(function() {
	$.ajax({url: 'php/llamarPrecios.php', type: 'POST'}).done(function(resp) {
		data=JSON.parse(resp);
		console.log( data );
		$('#txtPrecDieselv2').val(parseFloat(data[0].prodPrecio).toFixed(2))
		$('#txtPrecGasoholv2').val(parseFloat(data[1].prodPrecio).toFixed(2))
	});
	$('#modalModPrecios').modal('show');
});
$('#btnUpdatePrecios').click(function() {
	$('#pError3').addClass('d-none')
	if( $('#txtPrecDieselv2').val()=='' || $('#txtPrecGasoholv2').val()==''  ){
		$('#pError3').removeClass('d-none').text('Ningún precio puede estar vacío');
	}else{
		$.ajax({url: 'php/updatePrecios.php', type: 'POST', data: { diesel: $('#txtPrecDieselv2').val(), gasohol: $('#txtPrecGasoholv2').val() }}).done(function(resp) {
			console.log( resp );
			if( resp =='ok' ){
				$('#modalModPrecios').modal('hide');
				location.reload();
			}else{
				$('#pError3').removeClass('d-none').text('Hubo un error interno al guardar los datos');
			}
		});
	}
});
$('#sltFiltroClientes').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
	
	var index=$('#sltFiltroClientes').val();
	var padre = $("#sltFiltroClientes option[value="+index+"]");
	if($(this).val()!=null){
		$('#chkEstadoDni').prop('checked', false).change();
	}
	
	
	$('#txtDniBoleta').val(padre.attr('data-ruc'));
	$('#txtRazonBoleta').val(padre.attr('data-razon'));
	$('#txtDireccionBoleta').val(padre.attr('data-direccion'));
});
$('#btnAgregarProducto').click(function() {
	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	if( !$.isNumeric($('#divProductos .sltFiltroProductos').last().selectpicker('val')) ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Falta seleccionar un producto').parent().removeClass('d-none');
	}else if( $('#divProductos .sltFiltroUnidad').last().selectpicker('val')==null ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidó rellenar una unidad').parent().removeClass('d-none');
	}else{
		$.ajax({url: 'php/filaNueva.php', type: 'POST' }).done(function(resp) {
			//console.log(resp)
			$('#divProductos').append(resp);
			$('.selectpicker').selectpicker('render');
		});
	}
});
$('#divProductos').on('changed.bs.select', '.sltFiltroProductos', function (e, clickedIndex, isSelected, previousValue) {
	var padre = $(this).parent().parent(); //.parent()
	//console.log( padre );
	
	if( $('.sltFiltroProductos').selectpicker('val')!=null && $('.sltFiltroProductos').selectpicker('val')!='' ){
		var queProd= $('.sltFiltroProductos').selectpicker('val');
		
		//padre.find('.campoPrecioUnit').val
		$.each( $.precios , function(i, prodObj){
			if(prodObj.idProductos==queProd){
				//console.log('es pecio', prodObj.prodPrecio );
				//padre.find('.sltFiltroUnidad').selectpicker('val', '3')
				padre.attr('data-producto', prodObj.idProductos );
				padre.find('.sltFiltroUnidad #sltfiltroTemporal').selectpicker('val', prodObj.undSunat ).selectpicker('refresh');;
				padre.find('#sltFiltroGravado').selectpicker('val', prodObj.idGravado ).selectpicker('refresh');;
				padre.find('.campoPrecioUnit').val(parseFloat(prodObj.prodPrecio).toFixed(2));
				padre.find('.campoSubTotal').val(parseFloat(prodObj.prodPrecio).toFixed(2)).attr('data-exonerado', padre.find('#sltFiltroGravado').selectpicker('val'));
				padre.find('.campoCantidad').val(1).focus();

			}
		});

		//console.log('ver:' + JSON.stringify($(this).selectpicker('val')))

		if( clickedIndex ==1){ //codigo de la posición libre -> Antes #52
			padre.find('#sltFiltroGravado').prop('disabled', false).selectpicker('refresh');
			
			padre.find('.sltFiltroProductos').addClass('d-none');
			padre.find('.campoTextoLibre').removeClass('d-none').focus();

			padre.find('.sltFiltroPrecios').selectpicker('val', 0);
			padre.find('.campoPrecioUnit').prop('readonly', false);
			console.log('estoy en libre')
		}
		else if(clickedIndex>1){
			padre.find('.sltFiltroPrecios').selectpicker('val', 1);
			padre.find('.campoPrecioUnit').prop('readonly', true);
			console.log('estoy en otro')
		}
		padre.find('#sltFiltroGravado').selectpicker('val', 1)
		padre.find('.sltFiltroUnidad').selectpicker('val', 'NIU')
		sumaTodo();
	}
});
$('#divProductos').on('click', '.borrarFila', function (e) {
	var padre=$(this).parent().parent();
	padre.find('.campoPrecioUnit').prop('readonly',true);
	padre.find('#sltFiltroGravado').prop('disabled', true).selectpicker('refresh');
	if($('.cardHijoProducto').length>1){
		padre.remove();
	}else{
		padre.find('.sltFiltroProductos').selectpicker('val', -1).selectpicker('refresh');
		padre.find('.campoCantidad').val(0);
		padre.find('.campoPrecioUnit').val('0.00');
		padre.find('.campoSubTotal').val('0.00');
		padre.find('.bootstrap-select').removeClass('d-none');
		padre.find('.campoTextoLibre').addClass('d-none');
	}
	sumaTodo();
});

$('#divProductos').on('click', '.optPrecios', function (e) {
	var padre = $(this).parent().parent().parent().parent().parent().parent().parent();
	padre.find('.campoPrecioUnit').prop('readonly',true);
	
	switch ( padre.find('#sltFiltroPrecios').selectpicker('val')) {
		case "0":
			padre.find('.campoPrecioUnit').prop('readonly',false).focus().val('0.00');
		case "1":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecio).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		case "2":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecioMayor).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		case "3":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecioDescto).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		default:
			break;
	}
	
});
var divFecha = document.getElementById('divFecha');
var divSeries = document.getElementById('divSeries');
var divCreditos = document.getElementById('divCreditos');
function mostrarFecha(){
	$('#txtDateVencimiento').val(moment().format('YYYY-MM-DD'))
	divFecha.classList.toggle('d-none'); ocultarPadre() }
function mostrarSeries(){ divSeries.classList.toggle('d-none'); ocultarPadre() }
function mostrarCreditos(){
	$('#txtDateVencimiento').val(moment().add(1, 'day').format('YYYY-MM-DD'))
	$('#txtMontoCredito').val($('#spTotalBoleta').text())
	divCreditos.classList.toggle('d-none'); ocultarPadre()
}
function ocultarPadre(){
	if($('#cardAtributos .d-none').length == 6 ){ //total de d-none ocultos
		$('#cardAtributos').addClass('d-none')
	}else{
		$('#cardAtributos').removeClass('d-none')
	}
}

$("#txtDniBoleta").keyup(function(e){
	var code = e.which; 
	if( code==13 ){ e.preventDefault();
		buscarReniec();
	}
});
function buscarReniec(){
	pantallaOver(true);
	$('#txtDniBoleta').val( $.trim($('#txtDniBoleta').val()) )
	$('#txtRazonBoleta').focus();
	if( [8,11].includes($("#txtDniBoleta").val().length) ){ //es mayor a 8 digitos
		$.ajax({url: 'php/dataSunat.php', type: 'POST', data: { ruc: $('#txtDniBoleta').val() }}).done(function(resp) {
			//console.log(resp)
			try {
				dato = JSON.parse(resp);
				if(dato.length=!0){	
					//console.log( dato.razon_social );
					$('#txtRazonBoleta').val( dato.razon_social);
					$('#txtDireccionBoleta').val( dato.domicilio_fiscal);
				}
			} catch (error) {}
			pantallaOver(false);
		});
	}else{
		alertify.error('<i class="bi bi-exclamation-diamond"></i> Datos del DNI no son correctos.', 10000);
		pantallaOver(false);
	}
	
}

$('#txtPagaCuanto').keyup(function() {
	calcularVuelto()
});

function calcularVuelto(){
	if( $('#txtPagaCuanto').val()!=''){
		if( $('#txtPagaCuanto').val() > parseFloat($('#spTotalBoleta').text()) ){
			$('#spanVuelto').text( parseFloat(parseFloat($('#txtPagaCuanto').val()) - parseFloat($('#spTotalBoleta').text())).toFixed(2) );
			$('#spanVuelto').parent().parent().removeClass('d-none')
		}else{
			$('#spanVuelto').parent().parent().addClass('d-none')
		}
	}else{
		$('#spanVuelto').parent().parent().addClass('d-none')
	}
}

function prepararTransformacion(id){
	$.idComprobante = id;
	$.ajax({url: 'php/prepararConversion.php', type: 'POST', data: { id: $.idComprobante }}).done(function(resp) {
		console.log(resp)
		$.transformar = JSON.parse(resp)
		$('#pConverir').text($.transformar.que);
		$('#modalTransformacion').modal('show');
	});
}
function transformar(){
	$.ajax({url: 'php/transformar.php', type: 'POST', data: { id: $.idComprobante, serie: $.transformar.serie, tipo: $.transformar.tipo }}).done(function(resp) {
		console.log(resp)
		location.reload();
	});
}
$('#txtFiltro').keyup(e=>{
	if (e.keyCode === 13) {
		if($('#txtFiltro').val()==''){
			$('#btnRefresh').click()
		}else{
			$('#tablaPrincipal tbody').html('')
			$.ajax({url:'php/listarTodoPorFecha.php', type: 'POST', data: {texto: $.trim($('#txtFiltro').val()).replace('-', '%') }}).done(resp=>{
				$('#tablaPrincipal tbody').html(resp)
				sumarGenerados();
			})
		}
	}
})


<?php if($_COOKIE['ckPower']==1){ ?>
$('#tablaPrincipal').on('click', '.btnDarBajas', function (e) {
	$('#strComprobante').text( $(this).parent().parent().find('.tdCorrelativo').text());
	$('#h5ComprobanteBaja').text( $('#strComprobante').text());
	$('#btnDarbaja').attr('data-baja', $(this).attr('data-baja'));
	$('#btnDarbaja').attr('data-boleta', $(this).attr('data-boleta'));
	$('#pErrorBajas').addClass('d-none');
	if($(this).attr('data-boleta')=='3'){
		$('#txtConceptoBaja').addClass('d-none').prev().addClass('d-none');
		$.bajaComprobante = 'boleta';
	}else{
		$('#txtConceptoBaja').removeClass('d-none').prev().removeClass('d-none');
		$.bajaComprobante = 'factura';
	}
	$('#modalDarBajas').modal('show');
});
$('#btnDarbaja').click(function() {
	if( $.bajaComprobante =='factura' && $('#txtConceptoBaja').val()=='' ){
		$('#pErrorBajas').html('<i class="bi bi-chat-dots"></i>  Falta ingresar un motivo de baja');
		$('#pErrorBajas').removeClass('d-none');
	}else{
		$.ajax({url: 'php/darBajas.php', type: 'POST', data: { concepto: $('#txtConceptoBaja').val(), boleta: $(this).attr('data-boleta'), id: $(this).attr('data-baja') }}).done(function(resp) {
			if(resp=='ok'){
				$('#modalDarBajas').modal('hide');
				$('#modalExitoBajas').modal('show');
				$('#modalExitoBajas').on('hidden.bs.modal', function () { 
					location.reload();
				});
			}
		});

	}
});
$('#txtFechaComprobante').focusout(function() {
	let hoy = moment( moment().format('YYYY-MM-DD'), 'YYYY-MM-DD')
	let comprobante = moment($('#txtFechaComprobante').val(), 'YYYY-MM-DD')
	let diferencia = hoy.diff(comprobante, 'days')
	if( diferencia<0 ){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}else if(diferencia>4){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}else if( isNaN(diferencia)){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}
});

$('#btnVaciarBandeja').click(function() {
	$('#overlay').css('display', 'flex')
	$('#pFrase').text('Limpiando los datos de la bandeja')
	$.ajax({url: '<?= $_COOKIE['servidorCasa']?>/php/limpiarBandeja.php', type: 'POST'}).done(function(resp) {
		//console.log(resp)
		$('#overlay').css('display', 'none')
	});
});
function borrarExtra(id){
	$.idComprobante=id;
	$('#modalConfirmarBorrar').modal('show');
}
function borrarDefinitivamente(){
	$.ajax({url: 'php/borrarInterno.php', type: 'POST', data: { id: $.idComprobante }}).done(function(resp) {
		console.log(resp)
		if(resp=='ok'){
			location.reload();
		}
	});
}

<?php }?>
</script>
<?php include "piePagina.php"; ?>
</body>
</html>