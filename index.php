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
			<h1 class="text-center my-4">Plataforma de facturación</h1>
		</section>
		<section id="cuerpoBotones">
			<div class="container">
				<div class="row">
				<div class="col-sm-6">
					<label for="">Ingrese el código con el que desea trabajar:</label>
					<input type="text" class="form-control form-control-lg text-center text-uppercase" id="txtCodigoFact" value="FF60-00000004">
						<p>Elija a la acción:</p>
						<button class="btn btn-outline-primary btn-block btn-lg my-4" id="btnEmitirBoleta" >Emitir Boleta</button>
						<button class="btn btn-outline-success btn-block btn-lg my-4" id="btnEmitirFact">Emitir Factura</button>
						<button class="btn btn-outline-warning btn-block btn-lg my-4">Generar Nota de Débito</button>
						<button class="btn btn-outline-dark btn-block btn-lg my-4">Generar Nota de Crédito</button>
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
        <p>Los archivos correctamente se crearon en la ruta <strong><?php echo $directorio; ?></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ok</button>
        
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
$('#btnEmitirFact').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 1, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
});
$('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
});
</script>
</body>
</html>