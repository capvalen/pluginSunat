<?php
include "generales.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<section>
			<h1 class="text-center my-4">Sistema de emisión de comprobantes 1.0</h1>
		</section>
		<section id="cuerpoBotones">
			<div class="container">
				<div class="row">
				<div class="col-sm-12 mx-5 px-5">
						<button class="btn btn-outline-success btn-block btn-lg my-4" id="btnEmitirComprobante">Emitir Comprobante</button>
						<button class="btn btn-outline-warning btn-block btn-lg my-4">Consultar comprobante</button>
						<button class="btn btn-outline-dark btn-block btn-lg my-4">Modificar serie de comprobante</button>
					</div>
				</div>
			</div>
		</section>
	</div>

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
				<button class="btn btn-outline-primary">Generar PDF (A4)</button>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ok</button>
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
        <p>Ingrese los datos de negocio y el N° de Ticket:</p>
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtNCodNegocio" placeholder='Código de negocio' value="113">
				<input type="text" class="form-control text-uppercase text-center my-3" id="txtCodLocal" placeholder='Código de local' value="12300">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>

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
				$('#modalIngresoTicket .lblError').text('Datos errados, no coinciden con ningún local y ticket.');
			}else{
				$('#modalIngresoTicket .lblError').text('Hubo un error interno, comuníquelo a su proveedor');
			}
			//
		});
	}
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
		costoFinal: $.jTicket[0].costoFinal,
		igvFinal: $.jTicket[0].igvFinal,
		totalFinal: $.jTicket[0].totalFinal,
		productos: $.jTicket[1]
	 }}).done(function(resp) {
		console.log(resp)
	});
});

</script>
</body>
</html>