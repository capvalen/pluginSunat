<?php
include 'php/conexion.php';
include "generales.php";
//var_dump($_COOKIE); die();
if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.php");
	die(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Facturador electrónico -Infocat Soluciones</title>
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
<section id="seccionPrincipal">
	<div class="container-fluid mt-5 mb-5 ">
		<div class="row">
			<div class="col-md-3 text-center">
				<img src="<?= $_COOKIE['logo'];?>" class='img-fluid mx-auto'>
			</div>
			<div class="col ml-4">
				<h3 class="display-4" style="font-size: 2.5rem;">Facturación Electrónica</h3>
				<small class="text-muted"><i class="bi bi-person"></i> Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
				<div class="row d-flex ">
					<div class="col-sm-3"><small class="text-muted"><i class="bi bi-calendar2-event"></i> Filtro por fecha</small><input type="date" class="form-control text-center" id="fechaFiltro" onchange="$('#txtFiltro').val('');filtrarTablaHtml()"></div>
					<div class="col-sm-3"><small class="text-muted"><i class="bi bi-funnel"></i> Filtro por comprobante, Cliente</small><input type="text" autocomplete="off" class="form-control" id="txtFiltro"></div>
					<div class="col-sm-2 d-flex align-items-end">
						<div><button class="btn btn-outline-primary" id="btnRefresh"><i class="bi bi-arrow-clockwise"></i> Refrescar</button></div>
					</div>
				</div>
			</div>
			
		</div>
		<div class="container mx-auto mt-4 row d-none" style="color: #7030a0">
			<div class="col"><strong>N° Comprobantes: <span id="strCantdad"></span></strong></div>
			<div class="col"><strong>Venta total: S/ <span id="strTotal"></span></strong></div>
		</div>
		
		<div class="table-responsive" id="padreTablaPrincipal">
		</div>
	</div>
</section>

<footer class="bg-dark p-3 text-white text-center mt-1 fixed-bottom">
	<p class="mb-0"><i class="bi bi-bookmark"></i>  <small><?php include 'php/version.php';?></small></p>
	<p class="mb-1"><i class="bi bi-bookmark"></i> Facturador Sunat 2.1</p>
</footer>

<?php include 'modals-emision.php'; ?>


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
<!-- Modal para empezar Compartir en PC -->
<div class="modal fade" id="modalCompartirPc" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-0 shadow">
			<div class="modal-header border-bottom-0 pb-0">
				<h5 class="modal-title"><i class="bi bi-share"></i> Compartir comprobante</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card border">
					<div class="card-body">
						<div class="d-flex align-items-center mb-3">
							<div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
								<i class="bi bi-envelope text-white"></i>
							</div>
							<h6 class="mb-0 font-weight-bold">Correo electrónico</h6>
						</div>
						<div class="input-group mb-4">
							<input type="email" class="form-control" id="txtCorreo" autocomplete="off" placeholder="correo@ejemplo.com">
							<div class="input-group-append">
								<button class="btn btn-primary" type="button" onclick="btnEnviarCorreo()" data-dismiss="modal"><i class="bi bi-send"></i> Enviar</button>
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<div class="rounded-circle bg-success d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
								<i class="bi bi-whatsapp text-white"></i>
							</div>
							<h6 class="mb-0 font-weight-bold">WhatsApp</h6>
						</div>
						<div class="input-group">
							<input type="text" class="form-control" id="txtWhatsapp" autocomplete="off" placeholder="Número de celular">
							<div class="input-group-append">
								<button class="btn btn-success" type="button" onclick="btnEnviarWhatsapp()"><i class="bi bi-send"></i> Enviar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if($_COOKIE['ckPower']==1 || $_COOKIE['ckPower']==2){ ?>
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

<?php include "php/modal.php"; ?>
<?php include "footer.php"; ?>

<script>
$(document).ready(function(){
	$('#fechaFiltro').val( moment().format('YYYY-MM-DD'));
	$('[data-toggle="tooltip"]').tooltip();
	$('#tablaPrincipal tbody').children().remove();	
	filtrarTablaHtml()
});
var timeoutBusqueda;
function procesarRespuesta(resp){
	$('#padreTablaPrincipal').html(resp)
	$('#resumenTable').insertBefore('#tablaPrincipal');
	$("#padreTablaPrincipal table").stupidtable();
	$('[data-toggle="tooltip"]').tooltip();
	$("#tablaPrincipal").stupidtable();
	sumarGenerados()
}

function filtrarTablaHtml(){
	$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST', data:{
		fecha: $('#fechaFiltro').val(),
		texto: ''
	} }).done(procesarRespuesta);
}

function buscarPorTexto(){
	var txt = $('#txtFiltro').val().trim();
	if(txt == '') return;
	$('#txtFiltro').prop('disabled', true);
	$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST', data:{
		texto: txt
	} }).done(procesarRespuesta).always(function(){
		$('#txtFiltro').prop('disabled', false).focus().select();
	});
}
function sumarGenerados(){
	var sumaDia =0;
	$.each( $('#tablaPrincipal tbody tr'), function(index, obj){
		//console.log( 'cambio num: '+ $(obj).find('.spTotalPac').text() );
		let caso  = $(obj).find('.spTotalPac');
		if($(caso).attr('data-estado')!='2' && $(caso).attr('data-estado')!='4'){
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
$('#padreTablaPrincipal').on('click', '.imprTicketFuera', function (e) {
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');
	const tipo = padre.attr('data-tipo');

	<?php if($_COOKIE['ticket']=='automatico'){ ?>
	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso, serie, correlativo, tipo }}).done(function(resp) {
		console.log( resp );
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		$.ajax({url: 'http://127.0.0.1/<?= $casaHost; ?>/<?= $_COOKIE['demoFacturador']=="true" ? 'php/printDemoTicket.php' : 'printComprobante.php' ?>', type: 'POST',
		contentType: 'application/json',
		
		 data: JSON.stringify ({
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
			observaciones: $.jTicket[0].observaciones
			/* placa: $.jTicket[0].placa, */
		})
		}).done(function(resp) {
			console.log(resp)
			//location.reload();
		});
	});
	<?php }else{ ?>
		let token = btoa(serie+'-'+correlativo)
		window.open('./ticket.php?serie='+serie+'&correlativo='+correlativo+'&token='+token, '_blank');
	<?php } ?>
});
$('#btnModificarSerie').click(function() {
	var cargarSeries = function(s) {
		$('#txtSerieBoleta').val(s.serieBoleta);
		$('#txtSerieFactura').val(s.serieFactura);
		$('#txtSerieInterna').val(s.serieOpcional);
		$('#modalModSerie').modal('show');
	};
	if ($.series && $.series.length) {
		cargarSeries($.series[0]);
	} else {
		$.ajax({url: 'llamarSeries.php', type: 'POST'}).done(function(resp) {
			$.series = JSON.parse(resp);
			if ($.series.length) cargarSeries($.series[0]);
		});
	}
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
$('#padreTablaPrincipal').on('click', '.imprA4Fuera', function (e) {
	console.log('a4')
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');
	const tipo = padre.attr('data-tipo');

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso, serie, correlativo, tipo }}).done(function(resp) {
		console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		window.open( 'printComprobanteA4.php?serie='+encodeURIComponent(serie)+'&correlativo='+encodeURIComponent(correlativo)+'&tipo='+tipo ,'_blank');
	});
});
$('#padreTablaPrincipal').on('click', '.imprPDFFuera', function (e) {
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
	$('#txtFiltro').val('');
	$('#fechaFiltro').val(moment().format('YYYY-MM-DD'));
	filtrarTablaHtml();
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
function compartir(serie, correlativo){
	// Verificamos si el navegador tiene soporte para el API compartir
	if ('share' in navigator) {
		navigator.share({
			title: "Contenido",
			text: `Su Comprobante ${serie}-${correlativo} puede ser revisado online`,
			url: `./printComprobanteA4.php?serie=${serie}&correlativo=${correlativo}`
		})
		// Mensaje en Consola cuando se presiona el botón de compartir 
		.then(() => {
			console.log("Contenido Compartido!");
		})
		.catch(console.error);
	} else {
		// Si el navegador no tiene soporte para la API compartir, le enviamos un mensaje al usuario
		alert('Lo siento, este navegador no tiene soporte para recursos compartidos.')
	}
}
function compartirPc(serie, correlativo){
	$.serie= serie;
	$.correlativo = correlativo;
}
async function  btnEnviarCorreo(){
	const correo = document.getElementById('txtCorreo').value;
	if(!correo){
		Swal.fire({ icon: 'warning', title: 'Campo vacío', text: 'Ingrese un correo electrónico', confirmButtonColor: '#7030a0' });
		return;
	}
	Swal.fire({ title: 'Enviando...', text: 'Enviando comprobante al correo', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
	let datos = new FormData();
	datos.append('correo', correo);
	datos.append('serie', $.serie);
	datos.append('correlativo', $.correlativo);
	if ($.jTicket && $.jTicket[0] && $.jTicket[0].tipoComprobante) {
		datos.append('tipo', $.jTicket[0].tipoComprobante);
	}
	const servidor = await fetch('php/correo.php',{ method:'POST', body: datos });
	const respuesta = await servidor.text();
	if(respuesta == 'Mensaje entregado'){
		Swal.fire({ icon: 'success', title: 'Enviado', text: 'El comprobante se envió correctamente al correo', confirmButtonColor: '#7030a0' });
	}else{
		Swal.fire({ icon: 'error', title: 'Error al enviar', text: respuesta, confirmButtonColor: '#7030a0' });
	}
}
function btnEnviarWhatsapp(){
	const celular = document.getElementById('txtWhatsapp').value;
	if(celular)
		window.open('https://wa.me/51'+ document.getElementById('txtWhatsapp').value.replaceAll(' ', '') + '?text='+ `Su Comprobante ${$.serie}-${$.correlativo} puede ser revisado online desde: ` + encodeURIComponent(`<?=  $webHost ?>printComprobantePDF.php?serie=${$.serie}&correlativo=${$.correlativo}`), '_blank')
	
}
$('#txtFiltro').on('input', function(){
	clearTimeout(timeoutBusqueda);
	var txt = $(this).val().trim();
	if(txt.length >3 && txt.indexOf('-') === -1){
		timeoutBusqueda = setTimeout(function() {
			$('#fechaFiltro').val('');
			buscarPorTexto();
		}, 600);
	}
}).keyup(function(e){
	if (e.keyCode === 13) {
		clearTimeout(timeoutBusqueda);
		var txt = $(this).val().trim();
		if(txt == ''){
			$('#btnRefresh').click()
		}else{
			buscarPorTexto()
		}
	}
})

<?php if($_COOKIE['ckPower']==1 || $_COOKIE['ckPower']==2){ ?>
$('#seccionPrincipal').on('click', '.btnDarBajas', function (e) {
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
	$('#txtConceptoBaja').val('')
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

// Modal editar campos - llenar datos al abrir
$('#modalEditarCampos').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var ruc = button.data('ruc');
	var razon = button.data('razon');
	var direccion = button.data('direccion');
	var tipo = button.data('tipo');

	$(this).find('#editIdComprobante').val(id);
	$(this).find('#editTipoDoc').val(tipo);
	$(this).find('#editRuc').val(ruc);
	$(this).find('#editRazonSocial').val(razon);
	$(this).find('#editDireccion').val(direccion);
});

// Guardar edición de campos
$('#btnGuardarEdicion').click(function() {
	var id = $('#editIdComprobante').val();
	var ruc = $('#editRuc').val().trim();
	var razon = $('#editRazonSocial').val().trim();
	var direccion = $('#editDireccion').val().trim();

	if (ruc === '' || razon === '' ) {
		$('#editError').text('Debe rellenar todos los campos').removeClass('d-none');
		return;
	}

	$('#editError').addClass('d-none');
	$.ajax({
		url: 'php/editarCampos.php',
		type: 'POST',
		data: {
			id: id,
			ruc: ruc,
			razonSocial: razon,
			direccion: direccion
		}
	}).done(function(resp) {
		console.log(resp)
		if (resp.success) {
			$('#modalEditarCampos').modal('hide');
			filtrarTablaHtml();
		} else {
			$('#editError').text(data.message).removeClass('d-none');
		}
	});
});

// Buscar SUNAT para editar comprobante
function buscarSunatEditar() {
	var ruc = $('#editRuc').val().trim();
	if (ruc === '' || ![0,8,11].includes(ruc.length)) {
		alert('Ingrese un RUC válido (8 o 11 dígitos)');
		return;
	}
	$.ajax({
		url: 'php/dataSunat.php',
		type: 'POST',
		data: { ruc: ruc }
	}).done(function(resp) {
		try {
			var datos = JSON.parse(resp);
			if ( datos ) {
				$('#editRazonSocial').val($.trim(datos.razon_social));
				$('#editDireccion').val($.trim(datos.domicilio_fiscal));
			}
		} catch(e) {
			alert('Error al buscar datos en SUNAT');
		}
	}).fail(function() {
		alert('Error de conexión con SUNAT');
	});
}

<?php }?>
	$.decimalSuper = <?= json_encode($decimalesSuper) ?>;
	$.porcentajeIGV1 = <?= json_encode($porcentajeIGV1) ?>;
	$.casaHost = <?= json_encode($casaHost) ?>;
</script>
<script src="js/emision.js"></script>
<?php include "piePagina.php"; ?>
</body>
</html>
