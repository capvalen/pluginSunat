<?php
include 'php/conexion.php';
include "generales.php";

if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.html");
	die(); }
include "generales.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<?php include 'headers.php'; ?>
</head>
<body>

<?php include 'menu-wrapper.php'; ?>

<section class="mt-3" id="app">
	<div class="container-fluid  px-5">
		<div class="row">
		<div class="col-md-3">
			<center><img src="<?= $_COOKIE['logo'];?>" class='img-fluid mt-3 w-75'></center>
		</div>
		<div class="col ml-4">
			<h3 class="display-4">Reportes</h3>
			<small class="text-muted">Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
		</div></div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<label class="pt-2"><strong>Filtros:</strong></label>

						<div class="row">
							<div class="col">
								<label for="">Reporte:</label>
								<select class="selectpicker" data-live-search="false" id="sltFiltroReporte" title="Tipo de reporte">
									<option value="0">Resumido</option>
									<option value="1">Contable</option>
									<!-- <option value="2">Kardex</option> -->
									<option value="3">Detallado</option>
								</select>
							</div>
							<div class="col">
								<label for="">Productos:</label>
								<select class="selectpicker" data-live-search="false" id="sltFiltroProducto" title="Productos">
									<?php 
									$sqlProd="SELECT `idProductos`, `prodDescripcion`, p.`idUnidad`, `prodPrecio`, `prodActivo`, u.undDescipcion
									FROM `productos` p inner join unidades u on u.idUnidad = p.idUnidad 
									WHERE `prodActivo`=1 and idProductos<>0";
									$resultadoProd=$cadena->query($sqlProd);
									while($rowProd=$resultadoProd->fetch_assoc()): ?>
										<option value="<?= $rowProd['idProductos'];?>"><?= $rowProd['prodDescripcion'];?></option>
									<?php endwhile	?>
								</select>
							</div>
							<div class="col">
								<label for="">Desde:</label>
								<input type="date" class="form-control" v-model="inicio" @change="fin=inicio">
							</div>
							<div class="col">
								<label for="">Hasta:</label>
								<input type="date" class="form-control" v-model="fin" :min="inicio">
							</div>
							<div class="col d-flex justify-content-center align-items-center">
								<button class="btn btn-outline-primary ml-3" id="btnBuscarReporte">Filtrar <i class="bi bi-search"></i></button>
							</div>
							<div class="col d-flex justify-content-center align-items-center">
								<button class="btn btn-outline-success ml-3 d-none" id="btnGuardarReporte"><i class="bi bi-file-earmark-excel"></i> Guardar reporte</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		

		<table class="table table-hover mt-3" id="tablaCabeceras" >
			<thead>
				<tr>
					<th data-sort="int"><i class="icofont-expand-alt"></i> N°</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Tipo</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Código</th>
					<th data-sort="int"><i class="icofont-expand-alt"></i> Fecha y Hora</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Cliente</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> I.G.V.</th>
					<th data-sort="float"><i class="icofont-expand-alt"></i> Monto</th>
					<th data-sort="string"><i class="icofont-expand-alt"></i> Estado</th>
					<th>@</th>
				</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>
		<div class="d-none" id="divTablaSysCont"></div>

	</div>
</section>











<?php include "php/modal.php"; ?>
<?php include "footer.php"; ?>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="js/bootstrap-datepicker.js?version=1.0.1"></script>
<script src="js/xlsx.core.min.js"></script>
<script src="js/FileSaver.min.js"></script>
<script src="js/tableexport.js?version=1.1"></script>

<script>
	const { createApp, ref } = Vue

	 window.app = createApp({
		setup() {
			const inicio = ref(moment().format('YYYY-MM-DD'))
			const fin = ref(moment().format('YYYY-MM-DD'))
			return {
				inicio, fin
			}
		}
	}).mount('#app')
</script>

<script>
$(document).ready(function(){
	$('.selectpicker').selectpicker('render');
	$('.selectpicker').selectpicker('val', -1);
	$('#sltFiltroReporte').selectpicker('val',"0");
	$('table').stupidtable();
	/* $.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		//console.log(resp)
		$.precios = JSON.parse(resp);
		console.log( $.precios );
	}); */
	
	$('[data-toggle="tooltip"]').tooltip();
	$('.input-daterange').datepicker({
		format: "dd/mm/yyyy",
		todayBtn: "linked",
		language: "es",
		autoclose: true
	});
	$('.input-daterange input').val(moment().format('DD/MM/YYYY'));
});
$('.input-daterange input').change(function(){
	$('#btnGuardarReporte').addClass('d-none');
})
/* $('#btnEmitirBoleta').click(function() {
	$.ajax({url: 'emision.php', type: 'POST', data: { emitir: 3, factura: $('#txtCodigoFact').val() }}).done(function(resp) {
		console.log(resp)
		if(resp=='fin'){
			$('#modalArchivoBien').modal('show');
		}
	});
}); */
$('#btnBuscarReporte').click(function() {
	$('#tablaCabeceras').removeClass('d-none');
	$('#divTablaSysCont').addClass('d-none');
	if( $('#txtFecha1').val()!='' &&  $('#txtFecha2').val()!=''){
		

		switch ($('#sltFiltroReporte').selectpicker('val')) {
			case "0":
				$.ajax({url: 'php/listarTodoPorFecha.php', type: 'POST', data:{fecha: app.inicio, fecha2: app.fin, esReporte:1 } }).done(function(resp) {
					$('#tablaCabeceras tbody').children().remove();
					$('#tablaCabeceras tbody').append(resp).anotherJqueryMethod;
				});
				break;
			case "1":
				$('#divTablaSysCont').removeClass('d-none');
				$('#tablaCabeceras').addClass('d-none');
				$.ajax({url: 'php/reporteSysConta.php', type: 'POST', data:{fecha1: app.inicio, fecha2: app.fin } }).done(function(resp) {
					$('#divTablaSysCont').children().remove();
					$('#divTablaSysCont').append(resp).anotherJqueryMethod;
				});
				break;
			case "2":
				$('#divTablaSysCont').removeClass('d-none');
				$('#tablaCabeceras').addClass('d-none');
				$.ajax({url: 'php/reporteKardex.php', type: 'POST', data: { }}).done(function(resp) { console.log( resp );
					$('#divTablaSysCont').children().remove();
					$('#divTablaSysCont').append(resp).anotherJqueryMethod;
				});
			break;
			case '3':
				$('#divTablaSysCont').removeClass('d-none');
				$('#tablaCabeceras').addClass('d-none');
				$.ajax({url: 'php/reporteC34.php', type: 'POST', data: {fecha: app.inicio, fecha2: app.fin }}).done(function(resp) { console.log( resp );
					$('#divTablaSysCont').children().remove();
					$('#divTablaSysCont').append(resp).anotherJqueryMethod;
				});
			break;
			default:
				break;
		}
		$('[data-toggle="tooltip"]').tooltip();
		$('#btnGuardarReporte').removeClass('d-none');

	}
});


$('#btnGuardarReporte').click(function() {
	console.log( $('#sltFiltroReporte').selectpicker('val') );
	switch ($('#sltFiltroReporte').selectpicker('val')) {
		case "0":
			var instance = new TableExport(document.getElementById('tablaCabeceras'), {
				formats: ['xlsx'],
				exportButtons: false,
				sheetname: "Reporte resumido"
			});
			var exportData = instance.getExportData()['tablaCabeceras']['xlsx'];
			instance.export2file(exportData.data, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'Reporte resumido', exportData.fileExtension);
			
			

		break;
		case "1":
		case '3':
			console.log( 'pido' );
			var instance = new TableExport(document.getElementById('tablaSysConta'), {
				formats: ['xlsx'],
				exportButtons: false,
				sheetname: "Reporte contable"
			});
			var exportData = instance.getExportData()['tablaSysConta']['xlsx'];
			instance.export2file(exportData.data, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'Reporte contable', exportData.fileExtension);
		break;
		default:
		break;

	}
	
});

</script>
<style>
.bg-dark {
	background-color: #7030a0!important;
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
/* .bootstrap-select .dropdown-toggle .filter-option{font-family:'Segoe UI';} */
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
#imgLogo{max-width:250px;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
		border-radius: .25rem;}
thead tr th{cursor: pointer;}
.dropdown-item .text, .bootstrap-select button{text-transform: capitalize;}
.bootstrap-select{display: block;
width: 100%!important;}
.bg-success th{color:white!important}
</style>
</body>
</html>