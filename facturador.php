<?php
include 'conexion.php';
if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.html");
	die(); }
include "generales.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico - Desarrollado por: Infocat Soluciones</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.min.css">
	<link rel="stylesheet" href="css/anksunamun.css">

</head>
<body>
<style>
.bg-dark {
	background-color: #7531d4!important;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    /* display: none; <- Crashes Chrome on hover */
    -webkit-appearance: none;
    margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
    -moz-appearance:textfield; /* Firefox */
}
#txtPlacaBoleta::placeholder{
	font-family:'Icofont', 'Segoe UI';
	text-align: right;
}
.bootstrap-select .dropdown-toggle .filter-option{font-family:'Icofont', 'Segoe UI';}
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
#imgLogo{max-width:250px;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
    border-radius: .25rem;}
thead tr th{cursor: pointer;}
.dropdown-item .text, .bootstrap-select button{text-transform: capitalize;}
#divCalculosFinales span{font-size:1.1rem;}
.btn-outline-primary {
    color: #663cdc;
    border-color: #663cdc;
}
.btn-outline-primary:hover, .btn-outline-primary:hover, .btn-outline-primary:not(:disabled):not(.disabled):active{
	background-color: #663cdc;
	border-color: transparent;
}
.btn-outline-primary:focus {
	box-shadow: 0 0 0 0.2rem rgba(148, 102, 239, 0.5);
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5">
	<a class="navbar-brand" href="#">
    <img src="images/VirtualCorto.png" width="60" height="60" alt="">
  </a>
  <a class="navbar-brand" href="#">Facturador</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="icofont-newspaper"></i> Emitir comprobante
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#!" id="AEmitirBoleta"><i class="icofont-ui-note"></i> Boleta</a>
					<a class="dropdown-item" href="#!" id="AEmitirFactura"><i class="icofont-ui-copy"></i> Factura</a>
				</div>
			</li>
      <a class="nav-item nav-link d-none" href="#!" id="btnEmitirComprobante">Emitir comprobante</a>
      <a class="nav-item nav-link d-none" href="#!" id="btnConsultarComprobante">Consultar comprobante</a>
		<?php if($_COOKIE['ckPower']): ?>
      <a class="nav-item nav-link" href="#!" id="btnModificarSerie"><i class="icofont-tag"></i> Modificar serie</a>
      <a class="nav-item nav-link" href="productos.php" id=""><i class="icofont-hotel"></i> Productos</a>
      <a class="nav-item nav-link d-none" href="#!" id="btnModificarPrecios"><i class="icofont-infinite"></i> Modificar precios</a>
      <a class="nav-item nav-link " href="#!" id="btnModificarUsuarios"><i class="icofont-group"></i> Usuarios</a>
      <a class="nav-item nav-link " href="reportes.php" id=""><i class="icofont-group"></i> Reportes</a>
		<?php endif; ?>
      <a class="nav-item nav-link " href="desconectar.php"><i class="icofont-addons"></i> Cerrar</a>
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
				<button class="btn btn-outline-success btn-block btn-lg my-4">Emitir Comprobante</button>
				<button class="btn btn-outline-warning btn-block btn-lg my-4">Consultar comprobante</button>
				<button class="btn btn-outline-dark btn-block btn-lg my-4 d-none">Modificar serie de comprobante</button>
			</div>
			</div>
		</div>
	</section>
</div>
<section>
	<div class="container-fluid mt-5 px-5">
		<div class="row">
		<div class="col-3">
			<img src="bitmap.jpg?version=1.0.3" class='img-fluid mt-3'>
		</div>
		<div class="col ml-4">
			<h3 class="display-4">Facturación Electrónica</h3>
			<small class="text-muted">Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
			<div class="row d-flex justify-content-between">
				<div class="col-sm-3"><input type="date" class="form-control text-center" id="fechaFiltro"></div>
				<div class="col-sm-2"><button class="btn btn-outline-primary" id="btnRefresh"><i class="icofont-refresh"></i> Actualizar</button></div>
			</div>
		</div></div>
		

		<table class="table table-hover mt-3" id="tablaPrincipal">
			<thead>
				<tr>
					<th data-sort="int"><i class="icofont-expand-alt"></i> N°</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Tipo</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Código</th>
					<th data-sort="int"><i class="icofont-expand-alt"></i> Hora</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Cliente</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Monto</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Estado</th>
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
				<button class="btn btn-outline-primary" id="btnPrintTicketera"><i class="icofont-paper"></i> Imprimir en ticketera</button>
				<button class="btn btn-outline-success" id="btnPrintA4"><i class="icofont-print"></i> Generar PDF (A4)</button>

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
          <span aria-hidden="true">&times;</span>
				</button>
				<h5 class="pb-4"><i class="icofont-cart-alt"></i> Generar comprobante de venta</h5>
				<div class="form-inline">
				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" value="" id="chkEstadoDni" >
					<label class="form-check-label" id="labelEstadoDni" for="chkEstadoDni" >Cliente anónimo</label>
				</div>
				<div class="form-check mb-3 ml-5 d-none">
					<label for="">Placa de vehículo:</label>
					<input type="text" class='form-control text-uppercase ml-3' placeholder="N° Placa &#xee1e;" id="txtPlacaBoleta">
				</div>
				<div class="form-inline mt-n3 pl-3">
				<select class="selectpicker" data-live-search="true" id="sltFiltroClientes" title="&#xed12; Filtro de clientes">
					<?php include "php/listarTodosClientes.php";?>
				</select>
				</div>
				<div class="form-inline  ml-auto">
				<label class="pr-3 mt-n3" for=""><strong>Serie:</strong></label>
				<div class="dropdown mb-3">
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
				</div>
			
				
				<div id="divDatosCliente" class="d-none card mb-3">
					<div class="card-body">
						<p class="text-muted "><strong>Datos del cliente:</strong></p>
						<div class="row mb-3">
							<div class="col-4">
								<input type="text"  class="form-control ml-2 soloNumeros" id="txtDniBoleta" value="" placeholder='Dni' readonly>
							</div>
							<div class="col-8">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtRazonBoleta" value="" placeholder='Razón social o Apellidos y Nombres' readonly>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtDireccionBoleta" value="" placeholder='Dirección' readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<p class="text-muted d-none mb-0"><strong>Detalle:</strong></p>
						<div class="row">
							<div class="col-5"><strong>Concepto</strong></div>
							<div class="col-1"><strong>Cant.</strong></div>
							<div class="col-2 d-none"><strong>Und</strong></div>
							<div class="col-2"><strong>Precio Unit.</strong></div>
							<div class="col-2"><strong>Sub-Total</strong></div>
						</div>
						<!-- <div class="row mb-1 cardHijoProducto" data-producto="2">
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esGalon campoCantidad" value="0.00" step="0.5" min="0"></div>
							<div class="col-1">Galón</div>
							<div class="col-5 divNombProducto">Gasohol 90 Plus</div>
							<div class="col-2"><input type="number" class="form-control esMoneda campoPrecioUnit" id="txtPrecioGasolina" step='0.1' min="0"></div>
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoSubTotal" id="txtCampoPrecioGasolina" value="0.00"></div>
						</div>
						<div class="row mb-1 cardHijoProducto" data-producto="1">
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esGalon campoCantidad" value="0.00" step="0.5" min="0"></div>
							<div class="col-1">Galón</div>
							<div class="col-5 divNombProducto">Diesel D5 S-50 UV</div>
							<div class="col-2"><input type="number" class="form-control esMoneda campoPrecioUnit" id="txtPrecioPetroleo" step='0.1' min="0"></div>
							<div class="col-2"><input type="number" class="form-control form-control-sm text-center esMoneda campoSubTotal" id="txtCampoPrecioPetroleo" value="0.00"></div>
						</div> -->
						<div id="divProductos">
							<?php include "php/filaNueva.php";?>
						</div>
						<button class="btn btn-outline-success  mt-2" id="btnAgregarProducto"><i class="icofont-ui-add"></i> Agregar más produtos</button>
					</div>
				</div>
				<div class='mt-2 pr-5'>
					<div class="d-flex justify-content-around" id="divCalculosFinales"> <!-- align-items-end flex-column -->
						<span><span>Sub-Total:</span> <span>S/ <span id="spSubTotBoleta">0.00</span></span></span>
						<span><span>IGV:</span> <span>S/ <span id="spIgvBoleta">0.00</span></span></span>
						<span><span>Total:</span> <span>S/ <span id="spTotalBoleta">0.00</span></span></span>
					</div>
				</div>
				
       
      </div>
      <div class="modal-footer">
				<div class="container-fluid">
					<div class="row text-center">
						<p for="" class="text-danger d-none"> <span class="lblError"></span></p>
					</div>
					<button type="button" class="btn btn-outline-success float-right d-none" id="btnEmitirFacturav2" ><i class="icofont-paper"></i> Emitir Factura</button>
					<button type="button" class="btn btn-outline-primary float-right" id="btnEmitirBoletav2" ><i class="icofont-paper"></i> Emitir Boleta</button>
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
        <button type="button" class="btn btn-primary" id="btnUpdatePrecios"><i class="icofont-refresh"></i> Actualizar precios</button>
      </div>
    </div>
  </div>
</div>

<?php include "php/modal.php"; ?>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/impotem.js?version=1.0.7"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/stupidtable.js"></script>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);

	$.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
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
	});
	$('#fechaFiltro').change(function() {
		console.log( moment($('#fechaFiltro').val()).isValid() );
		$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST', data:{fecha: $('#fechaFiltro').val(), fecha2:$('#fechaFiltro').val() } }).done(function(resp) {
			$('#tablaPrincipal tbody').children().remove();
			$('#tablaPrincipal tbody').append(resp).anotherJqueryMethod;
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
	

	$.ajax({url: 'solicitarDataComprobante.php', type: 'POST', data: { caso:caso, serie: serie, correlativo: correlativo }}).done(function(resp) {
		console.log( resp );
		$.jTicket = JSON.parse(resp); //console.log( $.jTicket );
		$.ajax({url: 'http://127.0.0.1/<?= $casaHost; ?>/printComprobante.php', type: 'POST', data: {
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
			/* placa: $.jTicket[0].placa, */
		}}).done(function(resp) {
			console.log(resp)
			//location.reload();
		});
	});
});
$('#btnPrintTicketera').click(function() {
	$.ajax({url: 'http://127.0.0.1/<?= $casaHost; ?>/printComprobante.php', type: 'POST', data: {
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
				/* placa: $.jTicket[0].placa, */
			}}).done(function(resp) {
				console.log(resp)
				location.reload();
			});
});
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
$('#btnPrintA4').click(function() {
	window.open( 'printComprobanteA4.php?serie='+encodeURIComponent($.jTicket[0].serie)+'&correlativo='+encodeURIComponent($.jTicket[0].correlativo) ,'_blank');
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
	$('#txtDniBoleta').attr('placeholder', 'D.N.I.');
	$('#txtRazonBoleta').attr('placeholder', 'Nombres y apellidos');
	$('#btnEmitirBoletav2').removeClass('d-none');
	$('#btnEmitirFacturav2').addClass('d-none');
	$('#sltSeriesBoleta option').removeAttr('selected');
	$('#optBoleta').attr('selected', true);
	$('#chkEstadoDni').prop('checked', true).change().attr('disabled', false);
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
	$('#modalEmisionBoleta').modal('show');
});
$('#chkEstadoDni').change(function() {
	if($('#chkEstadoDni').prop('checked')	){
		$('#labelEstadoDni').text('Cliente anónimo');
		$('#divDatosCliente').addClass('d-none');
		$('#txtDniBoleta').attr('readonly', true).val('');
		$('#txtRazonBoleta').attr('readonly', true).val('');
		$('#txtDireccionBoleta').attr('readonly', true).val('');
		$('.selectpicker').selectpicker('val', -1);
	}else{
		$('#labelEstadoDni').text('Cliente con Documento');
		$('#divDatosCliente').removeClass('d-none');
		$('#txtRazonBoleta').attr('readonly', false);
		$('#txtDireccionBoleta').attr('readonly', false);
		$('#txtDniBoleta').attr('readonly', false).focus();
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
	var sumaTotal = 0;
	$.each( $('.campoSubTotal'), function(i, elem){
		//console.log( $(elem).val() );
		if( $(elem).val()!='' ){
			sumaTotal+=parseFloat($(elem).val());
		}
		
	});
	//console.log( sumaTotal );
	var costo = sumaTotal/1.18;
	var igv=sumaTotal-costo;
	$('#spSubTotBoleta').text(parseFloat(costo).toFixed(2));
	$('#spIgvBoleta').text(parseFloat(igv).toFixed(2));
	$('#spTotalBoleta').text(parseFloat(sumaTotal).toFixed(2));
}
/* $('#modalEmisionBoleta').on('shown.bs.modal', function () { 
	$('#txtPlacaBoleta').focus();
}); */
$('#btnEmitirBoletav2').click(function() {
	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	if( $('#sltSeriesBoleta').val()=='series'){
		$('#sltSeriesBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('#sltTemporal').selectpicker('val')==null ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidaste seleccionar un producto').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('.esMoneda').val()=='0.00' || $('.cardHijoProducto').first().find('.esMoneda').val()==0 || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()=='0.00' || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()==0 ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidaste ingresar una cantidad / precio').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('#sltfiltroTemporal').selectpicker('val')==null ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidaste seleccionar una unidad').parent().removeClass('d-none');
	}else if( $('#spTotalBoleta').text()=='0.00' ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none');
	}else{
		var jsonCliente= [];
		if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
			jsonCliente.push({dni: $('#txtDniBoleta').val(),
				razon: $('#txtRazonBoleta').val(),
				direccion: $('#txtDireccionBoleta').val()
			});
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
					subtotal: $(elem).find('.campoSubTotal').val()
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
		
		$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 3, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon	, cliDireccion: $('#txtDireccionBoleta').val(),jsonProductos: jsonProductos, jsonCliente:jsonCliente }}).done(function(resp) { //  placa: $('#txtPlacaBoleta').val(),
			console.log(resp)
			$.jTicket = JSON.parse(resp); console.log( $.jTicket );
			if($.jTicket.length >=1){
				$('#modalEmisionBoleta').modal('hide');
				$('#modalArchivoBien').modal('show');
			}
		});
	}
});
$('#btnEmitirFacturav2').click(function() {
	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	if( $('#sltSeriesBoleta').val()=='series'){
		$('#sltSeriesBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none');
	}/* else if( $('#txtPlacaBoleta').val()==''){
		$('#txtPlacaBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> La placa del automóvil tiene que ser rellenado').parent().removeClass('d-none');
	} */else if( $('#txtDniBoleta').val().length!=11 ){
		$('#txtDniBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> El RUC del cliente, no es correcto').parent().removeClass('d-none');
	}else if( $('#txtRazonBoleta').val()=='' ){
		$('#txtRazonBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> La razón social no puede estar en blanco').parent().removeClass('d-none');
	}else if( $('#spTotalBoleta').text()=='0.00' ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none');
	}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none');
	}else{
		var jsonCliente= [];
		if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
			jsonCliente.push({dni: $('#txtDniBoleta').val(),
				razon: $('#txtRazonBoleta').val(),
				direccion: $('#txtDireccionBoleta').val()
			});
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
					subtotal: $(elem).find('.campoSubTotal').val()
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
		$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 1, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon	, cliDireccion: $('#txtDireccionBoleta').val(), jsonProductos: jsonProductos, jsonCliente: jsonCliente }}).done(function(resp) { // placa: $('#txtPlacaBoleta').val(),
			console.log(resp)
			$.jTicket = JSON.parse(resp); console.log( $.jTicket );
			if($.jTicket.length >=1){
				$('#modalEmisionBoleta').modal('hide');
				$('#modalArchivoBien').modal('show');
			}
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
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Falta seleccionar un producto').parent().removeClass('d-none');
	}else if( $('#divProductos .sltFiltroUnidad').last().selectpicker('val')==null ){
		$('#modalEmisionBoleta .lblError').html('<i class="icofont-cat-alt-3"></i> Olvidó rellenar una unidad').parent().removeClass('d-none');
	}else{
		$.ajax({url: 'php/filaNueva.php', type: 'POST' }).done(function(resp) {
			//console.log(resp)
			$('#divProductos').append(resp);
			$('.selectpicker').selectpicker('render');
		});
	}
});
$('#divProductos').on('changed.bs.select', '.sltFiltroProductos', function (e, clickedIndex, isSelected, previousValue) {
	var padre = $(this).parent().parent().parent();
	//console.log( padre.html() );
	if( $(this).selectpicker('val')!=null ){
		var queProd= $(this).selectpicker('val');
		$.each( $.precios , function(i, prodObj){
			if(prodObj.idProductos==queProd){
				//console.log(  prodObj.prodPrecio );
				//padre.find('.sltFiltroUnidad').selectpicker('val', '3')
				padre.find('.sltFiltroUnidad #sltfiltroTemporal').selectpicker('val', prodObj.undSunat ).selectpicker('refresh');;
				padre.find('.campoPrecioUnit').val(parseFloat(prodObj.prodPrecio).toFixed(2));
				padre.find('.campoSubTotal').val(parseFloat(prodObj.prodPrecio).toFixed(2));
				padre.find('.campoCantidad').val(1).focus();

			}
		});

		if(padre.find('.divNombProducto button').attr('title')=='Libre'){
			padre.find('.bootstrap-select').addClass('d-none');
			padre.find('.campoTextoLibre').removeClass('d-none').focus();
		}
		sumaTodo()
	}
});
$('#divProductos').on('click', '.borrarFila', function (e) {
	var padre=$(this).parent().parent();
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
});

</script>
<?php include "piePagina.php"; ?>
</body>
</html>