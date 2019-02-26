<?php
if( !isset($_COOKIE['ckNegocio']) ){ header("Location: index.html");
	die(); }
include "generales.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">

</head>
<body>
<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5">
  <a class="navbar-brand" href="#">Facturador</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Emitir
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#!" id="AEmitirBoleta"><i class="icofont-ui-note"></i> Boleta</a>
					<a class="dropdown-item" href="#!" id="AEmitirFactura"><i class="icofont-ui-copy"></i> Factura</a>
				</div>
			</li>
      <a class="nav-item nav-link d-none" href="#!" id="btnEmitirComprobante">Emitir comprobante</a>
      <a class="nav-item nav-link d-none" href="#!" id="btnConsultarComprobante">Consultar comprobante</a>
      <a class="nav-item nav-link" href="#!" id="btnModificarSerie">Modificar serie</a>
      <a class="nav-item nav-link " href="desconectar.php"><i class="icofont-addons"></i> Cerrar sesión</a>
    </div>
  </div>
</nav>
<div class="container d-none">
	<section>
		<h1 class="text-center my-4">Sistema de emisión de comprobantes 1.0</h1>
	</section>
	<section id="cuerpoBotones">
		<div class="container">
			<div class="row">
			<div class="col-sm-12 mx-5 px-5">
				<button class="btn btn-outline-success btn-block btn-lg my-4 " >Emitir Comprobante</button>
				<button class="btn btn-outline-warning btn-block btn-lg my-4">Consultar comprobante</button>
				<button class="btn btn-outline-dark btn-block btn-lg my-4 d-none">Modificar serie de comprobante</button>
			</div>
			</div>
		</div>
	</section>
</div>
<section>
	<div class="container-fluid mt-5 px-5">
		<h3>Comprobantes generados: </h3>
		<small>Usuario: <?= strtoupper($_COOKIE['ckNegocio']); ?></small>
		<div class="row d-flex justify-content-between">
			<div class="col-sm-3"><input type="date" class="form-control" id="fechaFiltro"></div>
			<div class="col-sm-2"><button class="btn btn-outline-primary" id="btnRefresh"><i class="icofont-refresh"></i> Actualizar</button></div>
		</div>
		<table class="table table-hover mt-3">
			<thead>
				<tr>
					<th>N°</th>
					<th>Ticket</th>
					<th>Tipo</th>
					<th>Hora</th>
					<th>Cliente</th>
					<th>Monto</th>
					<th>Estado</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>20550-88</td>
					<td>Factura</td>
					<td>3:05 p.m.</td>
					<td>Cliente sin DNI</td>
					<td>55.00</td>
					<td>Emitido</td>
					<td>
						<button class="btn btn-outline-primary btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Generar comprobante"><i class="icofont-flag"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Imprmir ticket"><i class="icofont-paper"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Imprmir A4"><i class="icofont-print"></i></button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>

<div class="modal fade" id="modalArchivoBien" tabindex="-1" role="dialog">
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
				<button class="btn btn-outline-primary" id="btnPrintTicketera">Imprimir en ticketera</button>
				<button class="btn btn-outline-primary" id="btnPrintA4">Generar PDF (A4)</button>

      </div>
      <div class="modal-footer">
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
          <span aria-hidden="true">&times;</span>
				</button>
				<h5>Generar Boleta de venta</h5>
				<div class="form-inline">
				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" value="" id="chkEstadoDni" checked="true">
					<label class="form-check-label" id="labelEstadoDni" for="chkEstadoDni" >Cliente anónimo</label>
				</div>
				<div class="form-check mb-3 ml-5">
					<input type="text" class='form-control text-uppercase' placeholder="Placa de Vehículo">
				</div>
				</div>
			
				
				<div id="divDatosCliente" class="d-none card mb-3">
					<div class="card-body">
						<p class="text-muted"><strong>Datos del cliente:</strong></p>
						<div class="row mb-3">
							<div class="col-4">
								<input type="text"  class="form-control ml-2" id="txtDniBoleta" value="" placeholder='Dni' readonly>
							</div>
							<div class="col-8">
								<input type="text"  class="form-control ml-2" id="txtRazonBoleta" value="" placeholder='Razón social o Apellidos y Nombres' readonly>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<input type="text"  class="form-control ml-2" id="txtDireccionBoleta" value="" placeholder='Dirección' readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<p class="text-muted"><strong>Productos:</strong></p>
						<div class="row">
							<div class="col-2"><strong>Cant.</strong></div>
							<div class="col-1"><strong>Und</strong></div>
							<div class="col-5"><strong>Producto</strong></div>
							<div class="col-2"><strong>Precio Unit.</strong></div>
							<div class="col-2"><strong>Sub-Total</strong></div>
						</div>
						<div class="row mb-1" data-producto="2">
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoCantidad" value="0.00" step="0.5" min="0"></div>
							<div class="col-1">Galón</div>
							<div class="col-5">Gasolina</div>
							<div class="col-2"><input type="number" class="form-control esMoneda campoPrecioUnit" id="txtPrecioGasolina" step='0.1' min="0"></div>
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoSubTotal" value="0.00"></div>
						</div>
						<div class="row mb-1" data-producto="1">
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoCantidad" value="0.00" step="0.5" min="0"></div>
							<div class="col-1">Galón</div>
							<div class="col-5">Petróleo</div>
							<div class="col-2"><input type="number" class="form-control esMoneda campoPrecioUnit" id="txtPrecioPetroleo" step='0.1' min="0"></div>
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoSubTotal" value="0.00"></div>
						</div>
					</div>
				</div>
				<div class='mt-2 pr-5'>
					<div class="d-flex align-items-end flex-column">
						<h5><span>Sub-Total:</span> <span>S/ <span id="spSubTotBoleta">0.00</span></span></h5>
						<h5><span>IGV:</span> <span>S/ <span id="spIgvBoleta">0.00</span></span></h5>
						<h5><span>Total:</span> <span>S/ <span id="spTotalBoleta">0.00</span></span></h5>
					</div>
				</div>
				
       
      </div>
      <div class="modal-footer">
				<div class="container-fluid">
					<div class="row">
						<p for="" class="text-danger "><small class="lblError"></small></p>
					</div>
					<button type="button" class="btn btn-outline-primary float-right" id="btnConsultarDisponibilidad" ><i class="icofont-paper"></i> Emitir boleta</button>
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
      </div>
      <div class="modal-footer">
				<p class="text-danger d-none" id="pError2"></p>
        <button type="button" class="btn btn-primary" id="btnUpdateSeries">Actualizar series</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/impotem.js"></script>
<script src="js/moment.js"></script>
<script>
$(document).ready(function(){
	$.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$.precios = JSON.parse(resp);
		console.log( $.precios );
		$('#txtPrecioGasolina').val($.precios[1].prodPrecio);
		$('#txtPrecioPetroleo').val($.precios[0].prodPrecio);
	});
	$('#fechaFiltro').val( moment().format('YYYY-MM-DD'));
	$('[data-toggle="tooltip"]').tooltip();
	$('tbody').children().remove();

	$.ajax({url: 'listarTodoPorFecha.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$('tbody').append(resp);
		$('[data-toggle="tooltip"]').tooltip();
	});
	$('#fechaFiltro').change(function() {
		console.log( moment($('#fechaFiltro').val()).isValid() );
		$.ajax({url: 'listarTodoPorFecha.php', type: 'POST', data:{fecha: $('#fechaFiltro').val() } }).done(function(resp) {
			$('tbody').children().remove();
			$('tbody').append(resp).anotherJqueryMethod;
			$('[data-toggle="tooltip"]').tooltip();
		});
	});
});
/* $('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
}); */

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
$('tbody').on('click', '.imprTicketFuera', function (e) {
	var padre= $(this).parent()

	var caso = padre.attr('data-caso');
	var serie = padre.attr('data-serie');
	var correlativo = padre.attr('data-correlativo');
	var ticket = padre.attr('data-ticket');

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { fecha: $('#fechaFiltro').val(), ticket: ticket }}).done(function(resp) {
		console.log( resp );
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		if($.jTicket.length >=1){  
			$.post('solicitarFirma.php',{ emisor: '<?= $rucEmisor;?>',
				caso: caso,
				serie: serie,
				correlativo: correlativo}
				).done(function(respu){
					console.log( respu );
					if( respu == 'Sin firma'){
						$.hash = '';
					}else{
						$hassh= respu;
					}
					$.ajax({url: 'http://127.0.0.1/pluginSunat/printComprobante.php', type: 'POST', data: {
							tipoComprobante: $.jTicket[0].tipoComprobante,
							rucEmisor: $.jTicket[0].rucEmisor,
							queEs: $.jTicket[0].queSoy,
							serie: $.jTicket[0].serie,
							correlativo: $.jTicket[0].correlativo,
							tipoCliente: $.jTicket[0].tipoCliente,
							fecha: $.jTicket[0].fechaEmision,
							cliente: $.jTicket[0].razonSocial,
							docClient: $.jTicket[0].ruc,
							monedas: $.jTicket[0].letras,
							descuento: parseFloat($.jTicket[0].descuento).toFixed(2),
							costoFinal: parseFloat($.jTicket[0].costoFinal).toFixed(2),
							igvFinal: parseFloat($.jTicket[0].igvFinal).toFixed(2),
							totalFinal: parseFloat($.jTicket[0].totalFinal).toFixed(2),
							productos: $.jTicket[1],
							direccion:$.jTicket[0].direccion,
							hash: $hassh
						}}).done(function(resp) {
							console.log(resp)
							location.reload();
						});
				});
		}
	});
});
$('#btnPrintTicketera').click(function() {
	$.post('solicitarFirma.php',{ emisor: '<?= $rucEmisor;?>',	caso: $.jTicket[0].tipoComprobante,
	serie: $.jTicket[0].serie,
	correlativo: $.jTicket[0].correlativo}
	).done(function(respu){
		console.log( respu );
		if( respu == 'Sin firma'){
			$hassh = '';
		}else{
			$hassh= respu;
			$.ajax({url: 'http://127.0.0.1/pluginSunat/printComprobante.php', type: 'POST', data: {
				tipoComprobante: $.jTicket[0].tipoComprobante,
				rucEmisor: $.jTicket[0].rucEmisor,
				queEs: $.jTicket[0].queSoy,
				serie: $.jTicket[0].serie,
				correlativo: $.jTicket[0].correlativo,
				tipoCliente: $.jTicket[0].tipoCliente,
				fecha: $.jTicket[0].fechaEmision,
				cliente: $.jTicket[0].razonSocial,
				docClient: $.jTicket[0].ruc,
				monedas: $.jTicket[0].letras,
				descuento: parseFloat($.jTicket[0].descuento).toFixed(2),
				costoFinal: parseFloat($.jTicket[0].costoFinal).toFixed(2),
				igvFinal: parseFloat($.jTicket[0].igvFinal).toFixed(2),
				totalFinal: parseFloat($.jTicket[0].totalFinal).toFixed(2),
				productos: $.jTicket[1],
				direccion:$.jTicket[0].direccion,
				hash: $hassh
			}}).done(function(resp) {
				console.log(resp)
				location.reload();
			});
		}
	});
});
$('#btnModificarSerie').click(function() {
	$.ajax({url: 'llamarSeries.php', type: 'POST', data: { }}).done(function(resp) {
		
		var data = JSON.parse(resp)[0];
		console.log( data );
		$('#txtSerieBoleta').val( data.serieBoleta );
		$('#txtSerieFactura').val( data.serieFactura );
		$('#modalModSerie').modal('show');
	});
	
});
$('#btnUpdateSeries').click(function() {
	$('#pError2').addClass('d-none')
	if( $('#txtSerieBoleta').val()=='' || $('#txtSerieFactura').val()=='' ){
		$('#pError2').removeClass('d-none').text('Ambos campos deben estar rellenados');
	}else{
		$.ajax({url: 'updateSeries.php', type: 'POST', data: { serFact: $('#txtSerieFactura').val(), serBol: $('#txtSerieBoleta').val() }}).done(function(resp) {
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
	var ticket = padre.attr('data-ticket');

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { fecha: $('#fechaFiltro').val(), ticket: ticket }}).done(function(resp) {
		console.log(resp)
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		if($.jTicket.length >=1){
			$.post('solicitarFirma.php',{ emisor: '<?= $rucEmisor;?>',
				caso: caso,
				serie: serie,
				correlativo: correlativo}
				).done(function(respu){
					console.log( respu );
					if( respu == 'Sin firma'){
						$hash = '';
					}else{
						$hash= respu;
						window.open( 'printComprobanteA4.php?ticket='+ticket+'&hash='+encodeURIComponent($hash)+"&fecha="+encodeURIComponent($('#fechaFiltro').val()) ,'_blank');
					}
				});
		}
	});
});
$('#btnPrintA4').click(function() {
	$.post('solicitarFirma.php',{ emisor: '<?= $rucEmisor;?>',	caso: $.jTicket[0].tipoComprobante,
	serie: $.jTicket[0].serie,
	correlativo: $.jTicket[0].correlativo}
	).done(function(respu){
		console.log( respu );
		if( respu == 'Sin firma'){
			$.hash = '';
		}else{
			$hassh= respu;
			window.open( 'printComprobanteA4.php?negocio='+$('#txtNCodNegocio2').val()+'&local='+$('#txtCodLocal2').val()+'&ticket='+$('#txtNumTicket2').val()+'&hash='+encodeURIComponent($.hash)+"&fecha="+encodeURIComponent($('#fechaFiltro').val()) ,'_blank');
		}
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
	location.reload();
});
$('#AEmitirBoleta').click(function() {
	$('#modalEmisionBoleta').modal('show');
});

$('#chkEstadoDni').change(function() {
	if($('#chkEstadoDni').prop('checked')	){
		$('#labelEstadoDni').text('Cliente anónimo');
		$('#divDatosCliente').addClass('d-none');
		$('#txtDniBoleta').attr('readonly', true).val('');
		$('#txtRazonBoleta').attr('readonly', true).val('');
		$('#txtDireccionBoleta').attr('readonly', true).val('');
	}else{
		$('#labelEstadoDni').text('Cliente con documento de identidad');
		$('#divDatosCliente').removeClass('d-none');
		$('#txtRazonBoleta').attr('readonly', false);
		$('#txtDireccionBoleta').attr('readonly', false);
		$('#txtDniBoleta').attr('readonly', false).focus();
	}
});
$('.campoSubTotal').keyup(function() {
	var padre = $(this).parent().parent();
	var subTotal = parseFloat($(this).val());
	var precio = parseFloat(padre.find('.campoPrecioUnit').val());
	var cantidad = 0;//parseFloat(padre.find('.campoCantidad').val());
	
	cantidad = parseFloat(subTotal/precio);
	padre.find('.campoCantidad').val( cantidad.toFixed(2) );
	sumaTodo();
});
$('.campoPrecioUnit').keyup(function() {
	var padre = $(this).parent().parent();
	var precio = parseFloat($(this).val());
	var cantidad = parseFloat(padre.find('.campoCantidad').val());
	var subTotal = 0;//parseFloat(padre.find('.campoPrecioUnit').val());
	
	subTotal = parseFloat(cantidad*precio);
	padre.find('.campoSubTotal').val( subTotal.toFixed(2) );
	sumaTodo();
});
$('.campoCantidad').keyup(function() {
	var padre = $(this).parent().parent();
	var cantidad = parseFloat($(this).val());
	var precio = parseFloat(padre.find('.campoPrecioUnit').val());
	var subTotal = 0;//parseFloat(padre.find('.campoPrecioUnit').val());
	
	subTotal = parseFloat(cantidad*precio);
	padre.find('.campoSubTotal').val( subTotal.toFixed(2) );
	sumaTodo();
});
function sumaTodo() {
	var sumaTotal = 0;
	$.each( $('.campoSubTotal'), function(i, elem){
		//console.log( $(elem).val() );
		sumaTotal+=parseFloat($(elem).val());
	});
	console.log( sumaTotal );
	var costo = sumaTotal/1.18;
	var igv=sumaTotal-costo;
	$('#spSubTotBoleta').text(parseFloat(costo).toFixed(2));
	$('#spIgvBoleta').text(parseFloat(igv).toFixed(2));
	$('#spTotalBoleta').text(parseFloat(sumaTotal).toFixed(2));

}
</script>
</body>
</html>