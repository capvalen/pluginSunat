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
	<link rel="stylesheet" href="css/bootstrap.min.css" integrity="" crossorigin="anonymous">
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

<?php include 'menu-wrapper.php'; ?>

<section>
	<div class="container-fluid mt-5 px-5">
		<div class="row">
		<div class="col-md-3">
			<img src="bitmap.jpg?version=1.0.3" class='img-fluid mt-3'>
		</div>
		<div class="col ml-4">
			<h3 class="display-4">Gestión de productos</h3>
			<small class="text-muted">Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
		</div></div>
		<div class="d-flex justify-content-end">
			<button class="btn btn-outline-primary " id="btnAgregarProducto"><i class="icofont-ui-rate-add"></i> Agregar nuevo producto</button>
		</div>
		

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
				<?php include "php/listarTodosProductos.php"; ?>
			</tbody>
		</table>
	</div>
</section>



<!-- Modal para un nuevo producto -->
<div class="modal fade" id="modalNuevoProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" >Nuevo Producto <span class="text-capitalize" ></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="form-group row">
					<label for="txtPrecioNuevo" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Descripción:</label>
					<div class="col-sm-8"> <input type="text" class="form-control text-capitalize" id="txtDescripcionNuevo" > </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioNuevo" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Precio al Público:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioNuevo" value="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioMayorNuevo" class="col-sm-4 col-form-label">Precio al Mayor:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioMayorNuevo" value="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioDescuentoNuevo" class="col-sm-4 col-form-label">Precio Mínimo:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioDescuentoNuevo" value="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="sltFiltroGravadoNuevo" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Impuesto:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-live-search="false" id="sltFiltroGravadoNuevo" title="&#xed12; Imposición">
							<option value="1">Afecto</option>
							<option value="2">Exonerado</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="sltFiltroUnidadesNuevo" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Und. Medida:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-live-search="false" id="sltFiltroUnidadesNuevo" title="&#xed12; Unidades">
							<?php include "php/listarUnidadesOPT.php"; ?>
						</select>
					</div>
				</div>
      </div>
      <div class="modal-footer d-flex flex-column">
				<label class="text-danger	d-none" for=""></label>
        <button type="button" class="btn btn-outline-success" id="btnNuevoProduct"><i class="icofont-ui-add"></i> Crear nuevo producto</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para editar producto -->
<div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto: <span class="text-capitalize" id="spanNomProducto"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="form-group row">
					<label for="txtPrecioPublico" class="col-sm-4 col-form-label">Descripción:</label>
					<div class="col-sm-8"> <input type="text" class="form-control text-capitalize" id="txtDescripcionPub" > </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioPublico" class="col-sm-4 col-form-label">Precio al Público:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioPublico" val="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioMayor" class="col-sm-4 col-form-label">Precio al Mayor:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioMayor" val="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioDescuento" class="col-sm-4 col-form-label">Precio Mínimo:</label>
					<div class="col-sm-6"> <input type="number" class="form-control esMoneda text-center" id="txtPrecioDescuento" val="0.00"> </div>
				</div>
				<div class="form-group row">
					<label for="sltFiltroGravado" class="col-sm-4 col-form-label">Impuesto:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-live-search="false" id="sltFiltroGravado" title="&#xed12; Imposición">
							<option value="1">Afecto</option>
							<option value="2">Exonerado</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="sltFiltroUnidades" class="col-sm-4 col-form-label">Und. Medida:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-live-search="false" id="sltFiltroUnidades" title="&#xed12; Unidades">
							<?php include "php/listarUnidadesOPT.php"; ?>
						</select>
					</div>
				</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id="btnUpdateProduct"><i class="icofont-refresh"></i> Actualizar datos</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal para modificar stock-->
<div class="modal fade" id="modalModificarStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar stock: <span class="text-capitalize" id="spanNomProducto"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="form-group row">
					<label for="sltFiltroGravado" class="col-sm-4 col-form-label">Proceso:</label>
					<div class="col-sm-6">
						<select class="selectpicker" data-live-search="false" id="sltTipoModStock" title="&#xed12; ¿Qué proceso es?">
							<option value="1">Aumento directo</option>
							<option value="2">Disminución directa</option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioPublico" class="col-sm-4 col-form-label">Cantidad:</label>
					<div class="col-sm-4"> <input type="number" class="form-control " min="0" id="txtCantidadStock" > </div>
				</div>
				<div class="form-group row">
					<label for="txtPrecioPublico" class="col-sm-4 col-form-label">Observaciones:</label>
					<div class="col-sm-8"> <input type="text" class="form-control text-capitalize" id="txtObservacionStock" > </div>
				</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success" id="btnUpdateStock"><i class="icofont-refresh"></i> Actualizar stock</button>
      </div>
    </div>
  </div>
</div>



<?php include "php/modal.php"; ?>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js" integrity="" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js" integrity="" crossorigin="anonymous"></script>
<script src="js/impotem.js?version=1.0.8"></script>
<script src="js/moment.js"></script>
<script src="js/bootstrap-select.js"></script>
<script src="js/stupidtable.js"></script>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	//$('table').stupidtable();
	/* $.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$.precios = JSON.parse(resp);
		console.log( $.precios );
	}); */
	//$("table").stupidtable();
	$('[data-toggle="tooltip"]').tooltip();

});

$('table').on('click', '.btnEditProducto', function (e) {
	var padre=$(this).parent().parent();

	$('#spanNomProducto').text( padre.find('.tdProdNombre').text());
	$('#txtDescripcionPub').val(padre.find('.tdProdNombre').text());

	$('#txtPrecioPublico').val( parseFloat(padre.find('.tdPublico').attr('data-value')).toFixed(2) );
	$('#txtPrecioMayor').val( parseFloat(padre.find('.tdMayor').attr('data-value')).toFixed(2) );
	$('#txtPrecioDescuento').val( parseFloat(padre.find('.tdDescuento').attr('data-value')).toFixed(2) );


	$('#sltFiltroGravado').selectpicker('val',padre.find('.tdGrabado').attr('data-value'));
	$('#sltFiltroUnidades').selectpicker('val',padre.attr('data-und'));
	$('#btnUpdateProduct').attr('data-id', padre.attr('data-id'));
	$('#modalEditarProducto').modal('show');

	// var queProd= $(this).selectpicker('val');
	// 	$.each( $.precios , function(i, prodObj){
	// 		if(prodObj.idProductos==queProd){
	// 			//console.log(  prodObj.prodPrecio );
	// 			//padre.find('.sltFiltroUnidad').selectpicker('val', '3')
	// 			padre.find('.sltFiltroUnidad #sltfiltroTemporal').selectpicker('val', prodObj.undSunat ).selectpicker('refresh');;
	// 			padre.find('.campoPrecioUnit').val(parseFloat(prodObj.prodPrecio).toFixed(2));
	// 			padre.find('.campoSubTotal').val(parseFloat(prodObj.prodPrecio).toFixed(2));
	// 			padre.find('.campoCantidad').val(1).focus();

	// 		}
	// 	});
});
$('#btnUpdateProduct').click(function() {
	//console.log( $('#sltFiltroUnidades').selectpicker('val') );
	var pPublico=0, pMayor=0, pDescuento=0;
	if( $('#txtPrecioPublico').val()!='' ){ pPublico=$('#txtPrecioPublico').val(); }
	if( $('#txtPrecioMayor').val()!='' ){ pMayor=$('#txtPrecioMayor').val(); }
	if( $('#txtPrecioDescuento').val()!='' ){ pDescuento=$('#txtPrecioDescuento').val(); }

	$.ajax({url: 'php/updateProducto.php', type: 'POST', data: { idProd: $('#btnUpdateProduct').attr('data-id'), pNombre: $('#txtDescripcionPub').val(), pPublico: pPublico, pMayor: pMayor, pDescuento: pDescuento, pImpuesto: $('#sltFiltroGravado').selectpicker('val'), pUnidad: $('#sltFiltroUnidades').selectpicker('val') }}).done(function(resp) {
		if(resp=='ok'){
			$('#h5Detalle').text('Producto Actualizado');
			$('#modalEditarProducto').modal('hide');
			$('#modalGuardadoExitoso').modal('show');
		}
	});
});
$('#modalNuevoProducto').on('shown.bs.modal', function () { 
	$('#txtDescripcionNuevo').focus();
});
$('#btnAgregarProducto').click(function() {
	$('#modalNuevoProducto').modal('show');
});
/* $('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
}); */
$('#btnNuevoProduct').click(function() {
	if( $('#txtDescripcionNuevo').val()=='' || $('#txtPrecioNuevo').val()=='' || $('#sltFiltroGravadoNuevo').selectpicker('val')==null || $('#sltFiltroUnidadesNuevo').val()==null  ){
		$('#modalNuevoProducto .text-danger').removeClass('d-none').html('<i class="icofont-cat-alt-3"></i> Debe rellenar todos los campos olbigatorios');
	}else{
		$.ajax({url: 'php/insertarProducto.php', type: 'POST', data: {nombre: $('#txtDescripcionNuevo').val(), precio: $('#txtPrecioNuevo').val(), mayor: $('#txtPrecioMayorNuevo').val(), descuento: $('#txtPrecioDescuentoNuevo').val(), gravado: $('#sltFiltroGravadoNuevo').selectpicker('val'), unidad: $('#sltFiltroUnidadesNuevo').selectpicker('val') }}).done(function(resp) {
			//console.log(resp)
			if( resp =='ok'){
				$('#h5Detalle').text('Producto guardado');
				$('#modalNuevoProducto').modal('hide');
				$('#modalGuardadoExitoso').modal('show');
			}
		});
	}
	

});
$('table').on('click', '.btnBorrarProducto', function (e) {
	var idProd = $(this).parent().parent().attr('data-id');
	$.ajax({url: 'php/borrarProducto.php', type: 'POST', data: {idProd:idProd }}).done(function(resp) {
		if( resp =='ok'){
			$('#h5Detalle').text('Producto borrado');
			$('#modalGuardadoExitoso').modal('show');
		}
	});
});
$('table').on('click', '.btnStockProducto', function (e) {
	var idProd = $(this).parent().parent().attr('data-id');
	//console.log( idProd );
	$('#btnUpdateStock').attr('data-id', idProd)
	$('#modalModificarStock').modal('show');
});
$('#btnUpdateStock').click(function() {
	$.ajax({url: 'php/updateStockR.php', type: 'POST', data: {idProd: $('#btnUpdateStock').attr('data-id'), proceso: $('#sltTipoModStock').val(), cantidad: $('#txtCantidadStock').val(), obs: $('#txtObservacionStock').val() }}).done(function(resp) { console.log(resp)
		$('#modalModificarStock').modal('hide');
		//console.log(resp)
		if(resp=='ok'){var padre = $('tr[data-id="'+$('#btnUpdateStock').attr('data-id')+'"]');
		var cantInicial = parseFloat(padre.find('.tdStock').text());
		var cantFinal = parseFloat($('#txtCantidadStock').val());
		if( $('#sltTipoModStock').val() =='1'){
			padre.find('.tdStock').text(cantInicial + cantFinal);
		}
		if( $('#sltTipoModStock').val() =='2'){
			padre.find('.tdStock').text(cantInicial - cantFinal);
		}}
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