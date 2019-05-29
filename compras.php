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
	<title>Facturador electrónico</title>
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="stylesheet" href="css/bootstrap-select.min.css">
	<link rel="stylesheet" href="css/anksunamun.css">
	<link rel="shortcut icon" href="images/VirtualCorto.png" type="image/png">
	<link rel="stylesheet" href="css/colorsmaterial.css">


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
.bootstrap-select .dropdown-toggle .filter-option, .iconPlaceholder{font-family:'Icofont', 'Segoe UI';}
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
#imgLogo{max-width:250px;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
    border-radius: .25rem;}
thead tr th{cursor: pointer;}
.dropdown-item .text, .bootstrap-select button{text-transform: capitalize;}
#tblProductosResultados tbody tr:hover{background-color: #a3deff4f;
		color: #007bff;}
/* #tblProductosResultados {color: #0073e6;}
 */
#tblProductosResultados th{border-top-color: transparent!important;     border-bottom: 2px solid #1f8fff;}
#tblProductosResultados td{border-top: 1px solid #d2e9ff;}
</style>

<?php include 'menu-wrapper.php'; ?>

<section>
	<div class="container-fluid mt-5 px-5">
		<div class="row">
		<div class="col-md-3">
			<img src="bitmap.jpg?version=1.0.3" class='img-fluid mt-3'>
		</div>
		<div class="col ml-4">
			<h3 class="display-4">Gestión de compras</h3>
			<small class="text-muted">Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
		</div></div>
		<div class="d-flex justify-content-end">
			<!-- <button class="btn btn-outline-primary " id="btnAgregarProducto"><i class="icofont-shopping-cart"></i> Agregar nueva compra</button> -->
			<a class="btn btn-outline-primary " href="compras.php?nuevaCompra"><i class="icofont-shopping-cart"></i> Generar nueva compra</a>
		</div>

		<?php if(isset($_GET['nuevaCompra'])){ ?>
		<h3>Nueva compra</h3>
		<div class="card">
			<div class="card-body">
				<h6 class="card-subtitle mb-2 text-muted">Datos de Proveedor</h6>
		
				<div class="row">
					<div class="col-sm-6 form-group row">
						<label for="sltFiltroMoneda" class="col-lg-3 col-form-label">Documento:</label>
						<div class="col-lg-4"> 
						<select class="selectpicker" data-live-search="false" id="sltFiltroMoneda" title="&#xed12; Documentos">
							<option value="1">Factura</option>
							<option value="3">Boleta de venta</option>
							<option value="7">Nota de crédito</option>
							<option value="12">Ticket de máquina registradora</option>
						</select>
						</div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtCompraFecha" class="col-lg-3 col-form-label">Fecha de compra:</label>
						<div class="col-lg-6"><input type="text" class="form-control soloNumeros" id="txtCompraFecha" > </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="sltFiltroMoneda" class="col-lg-3 col-form-label">Tipo de Moneda:</label>
						<div class="col-lg-4"> 
						<select class="selectpicker" data-live-search="false" id="sltFiltroMoneda" title="&#xed12; Moneda">
							<option value="1">Soles</option>
							<option value="2">Dólares</option>
						</select>
						</div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtCompraValorDolar" class="col-lg-3 col-form-label">Tipo de cambio:</label>
						<div class="col-lg-3"><input type="text" class="form-control soloNumeros" id="txtCompraValorDolar" > </div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 form-group row">
						<label for="txtProviderRuc" class="col-lg-3 col-form-label">R.U.C.:</label>
						<div class="col-lg-6"> <input type="text" class="form-control soloNumeros" id="txtProviderRuc" autocomplete='nope'> </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtProviderRazon" class="col-lg-3 col-form-label">Razon Social:</label>
						<div class="col-lg-9"> <input type="text" class="form-control soloNumeros" id="txtProviderRazon" autocomplete='nope'> </div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 form-group row">
						<label for="txtProviderDireccion" class="col-lg-3 col-form-label">Dirección:</label>
						<div class="col-lg-6"> <input type="text" class="form-control soloNumeros" id="txtProviderDireccion" autocomplete='nope'> </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtProviderRuc" class="col-lg-3 col-form-label">Observaciones:</label>
						<div class="col-lg-9"> <input type="text" class="form-control soloNumeros" id="txtProviderObs" autocomplete='nope'> </div>
					</div>					
				</div>


			</div>
		</div>

		<div class="card mt-3">
		<div class="card-body">
			<h6 class="card-subtitle mb-2 text-muted">Detalle de la compra</h6>
			<div class="form-group row">
				<label for="txtFiltroProducto" class="col-lg-2 col-form-label"><i class="icofont-filter"></i> Filtro de producto:</label>
				<div class="col-lg-9"> 
					<div class="input-group">
						<input type="text" class="form-control iconPlaceholder" id="txtFiltroProducto" autocomplete='nope' placeholder="&#xed11; Nombre de producto, código">
						<div class="input-group-append">
							<button class="btn btn-outline-primary" data-toggle="tooltip" title="Realizar búsqueda" id="btnRealizarBusqueda"><i class="icofont-search-1"></i></button>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
			<table class="table table-hover">
			<thead>
			<tr>
				<th>N°</th>
				<th>Cant.</th>
				<th>Descripción</th>
				<th>Unidad</th>
				<th>Afecto</th>
				<th>Precio Unit.</th>
				<th>Valor de venta</th>
			</tr>
			</thead>
			</table>
			</div>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis eveniet ipsa corporis, fuga debitis eligendi corrupti necessitatibus officiis accusantium officia rerum repellat vel nesciunt, deleniti perspiciatis incidunt maxime quis quaerat.</p>
		</div>
		</div>
		<div class="card mt-3">
		<div class="card-body">
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis, iste, architecto aut ipsum consequatur ad error, quasi molestiae tenetur doloremque vero accusamus eligendi nesciunt? Repudiandae velit placeat tempora natus quia.</p>
		</div>
		</div>

		<?php } else{ //se muestra cuando no hay ningun parámetro ?>
		<table class="table table-hover mt-3">
			<thead>
				<tr>
					<th data-sort="int"><i class="icofont-expand-alt"></i> N°</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Nombre de producto</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Precio Público</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Precio por Mayor</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Precio con Dscto.</th>
					<th data-sort="int"><i class="icofont-expand-alt"></i> Stock</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Gravado</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Estado</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
		<?php } //fin de else parametros ?>
	</div>
</section>


<!-- Modal para: mostrar productos resultado-->
<div class='modal fade ' id="modalProductosEncontrados" tabindex='-1' role='dialog' aria-hidden='true'>
	<div class='modal-dialog modal-lg' >
	<div class='modal-content '>
		<div class='modal-body'>
		<button type='button' class='close' data-dismiss='modal' aria-label='Close' ><span aria-hidden='true'>&times;</span></button>
		<h4 class='modal-title blue-text text-accent-2'>Productos</h4>
			<div class="table-responsive" id="divResultadoProd"></div>
		</div>
		
		</div>
	</div>
</div>




<?php include "php/modal.php"; ?>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/impotem.js?version=1.0.8"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/stupidtable.js"></script>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	$('#txtCompraFecha').val(moment().format('YYYY-MM-DD'));
	//$('table').stupidtable();
	/* $.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$.precios = JSON.parse(resp);
		console.log( $.precios );
	}); */
	//$("table").stupidtable();
	$('[data-toggle="tooltip"]').tooltip();

});
$('#btnAgregarProducto').click(function() {
	$('.modalProductosEncontrados').modal('show');
});
$('#btnRealizarBusqueda').click(function() {
	$('#modalProductosEncontrados').modal('show');
	$.ajax({url: 'php/filtroProductos.php', type: 'POST', data: { texto: $('#txtFiltroProducto').val() }}).done(function(resp) {
		console.log(resp)
		$('#divResultadoProd').html(resp);
	});
});

</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<!-- <script type='text/javascript'>
(function(){ var widget_id = 'ucFX66lIdV';var d=document;var w=window;function l(){
  var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
  s.src = '//code.jivosite.com/script/widget/'+widget_id
    ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
  if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
  else{w.addEventListener('load',l,false);}}})();
</script> -->
<!-- {/literal} END JIVOSITE CODE -->
</body>
</html>