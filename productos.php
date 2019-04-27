<?php
include 'conexion.php';
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
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.min.css">

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
.bootstrap-select .dropdown-toggle .filter-option{font-family:'Icofont', 'Segoe UI';}
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
#imgLogo{max-width:250px;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
    border-radius: .25rem;}
thead tr th{cursor: pointer;}
.dropdown-item .text, .bootstrap-select button{text-transform: capitalize;}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark pl-5">
  <a class="navbar-brand" href="#">Facturador</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link " href="facturador.php" id=""><i class="icofont-ebook"></i> Facturación</a>
      <a class="nav-item nav-link active" href="productos.php" id=""><i class="icofont-cube"></i> Productos</a>
      <a class="nav-item nav-link" href="reportes.php" id=""><i class="icofont-file-alt"></i> Reportes</a>
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
			<h3 class="display-4">Gestión de productos</h3>
			<small class="text-muted">Usuario: <?= strtoupper($_COOKIE['ckNegocio']); ?></small>
		</div></div>
		<div class="d-flex justify-content-end">
			<button class="btn btn-outline-primary "><i class="icofont-ui-rate-add"></i> Agregar nuevo producto</button>
		</div>
		

		<table class="table table-hover mt-3">
			<thead>
				<tr>
					<th data-sort="int"><i class="icofont-expand-alt"></i> N°</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Nombre de prodcuto</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Precio de venta</th>
					<th data-sort="int"><i class="icofont-expand-alt"></i> Stock</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Estado</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Brocoly Hibrico Legacy</td>
					<td>15.50</td>
					<td>60 Unds.</td>
					<td>Activo</td>
					<td>
						<button class="btn btn-outline-primary btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Editar Producto"><i class="icofont-flag"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Cambiar Precio"><i class="icofont-list"></i></button>
						<button class="btn btn-outline-dark btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Modificar Stock"><i class="icofont-magic"></i></button>
					</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Alfalfa Moapa Suelto x 250grs.</td>
					<td>4.90</td>
					<td>58 Unds.</td>
					<td>Activo</td>
					<td>
						<button class="btn btn-outline-primary btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Editar Producto"><i class="icofont-flag"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Cambiar Precio"><i class="icofont-list"></i></button>
						<button class="btn btn-outline-dark btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Modificar Stock"><i class="icofont-magic"></i></button>
					</td>
				</tr>
				<tr>
					<td>3</td>
					<td>baygon verde x 250cc.</td>
					<td>14.10</td>
					<td>50 Unds.</td>
					<td>Activo</td>
					<td>
						<button class="btn btn-outline-primary btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Editar Producto"><i class="icofont-flag"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Cambiar Precio"><i class="icofont-list"></i></button>
						<button class="btn btn-outline-dark btn-sm border border-light" data-toggle="tooltip" data-placement="top" title="Modificar Stock"><i class="icofont-magic"></i></button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</section>












<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/impotem.js?version=1.0.4"></script>
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
	//$('tbody').children().remove();

/* 	$.ajax({url: 'listarTodoPorFecha.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$('tbody').append(resp);
		$('[data-toggle="tooltip"]').tooltip();
		$("table").stupidtable();
	}); */
	$('#fechaFiltro').change(function() {
		console.log( moment($('#fechaFiltro').val()).isValid() );
		$.ajax({url: 'listarTodoPorFecha.php', type: 'POST', data:{fecha: $('#fechaFiltro').val() } }).done(function(resp) {
			$('tbody').children().remove();
			$('tbody').append(resp);
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
			/* placa: $.jTicket[0].placa, */
		}}).done(function(resp) {
			console.log(resp)
			//location.reload();
		});
	});
});
$('#btnPrintTicketera').click(function() {
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
			if( $(elem).find('.sltFiltroProductos').selectpicker('val')!='' ){
				jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
					descripcionProducto: $(elem).find('.divNombProducto button').attr('title'),
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
				jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
					descripcionProducto: $(elem).find('.divNombProducto button').attr('title'),
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
//	$('#chkEstadoDni').prop('checked', false).change();
	
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
</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'ucFX66lIdV';var d=document;var w=window;function l(){
  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
  s.src = '//code.jivosite.com/script/widget/'+widget_id
    ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
  if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
  else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->
</body>
</html>