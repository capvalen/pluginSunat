<?php
include 'php/conexion.php';
include "generales.php";

if( !isset($_COOKIE['ckidUsuario']) ){ header("Location: index.php");
	die(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Nueva compra - Facturador electrónico</title>
	<?php include 'headers.php'; ?>
</head>
<body class="pb-5">
<style>
.bg-dark {
	background-color: #7531d4!important;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance:textfield;
}
.bootstrap-select .dropdown-toggle .filter-option, .iconPlaceholder{font-family:'Icofont', 'Segoe UI';}
.close{color: #ff0202}
.close:hover, .close:not(:disabled):not(.disabled):hover{color: #fd0000;opacity:1;}
.bootstrap-select .btn-light{background-color: #ffffff;}
.bootstrap-select .dropdown-toggle .filter-option{    border: 1px solid #ced4da;
    border-radius: .25rem;}
#tblProductosResultados tbody tr:hover{background-color: #a3deff4f;
		color: #007bff;}
#tblProductosResultados th{border-top-color: transparent!important;     border-bottom: 2px solid #1f8fff;}
#tblProductosResultados td{border-top: 1px solid #d2e9ff;}
.inputValido{border-color: #45c763!important;}
.inputInvalido{border-color: #ff1d1d!important;}
#overlay {
    position: fixed;
    display: none;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.75);
    z-index: 1051;
}
#overlay .text{position: absolute;
    top: 50%;
    left: 50%;
    font-size: 18px;
    color: white;
    user-select: none;
    transform: translate(-50%,-50%);
}
</style>

<?php include 'menu-wrapper.php'; ?>

<section id="seccionPrincipal">
	<div class="container-fluid mt-5 px-5 pb-5">
		<div class="row">
		<div class="col-md-3 text-center">
			<img src="<?= $_COOKIE['logo'];?>" class='img-fluid mx-auto'>
		</div>
		<div class="col ml-4">
			<h3 class="display-4" style="font-size: 2.5rem;">Nueva compra</h3>
			<small class="text-muted"><i class="bi bi-person"></i> Usuario: <?= strtoupper($_COOKIE['ckAtiende']); ?></small>
		</div></div>

		<div id="app">
		<div class="card">
			<div class="card-body">
				<h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-truck"></i> Datos de Proveedor</h6>

				<div class="row">
					<div class="col-sm-6 form-group row">
						<label for="sltFiltroDocumento" class="col-lg-3 col-form-label"><span style="white-space:nowrap">Comprobante:<span class="text-danger">*</span></span></label>
						<div class="col-lg-4"> 
						<select class="selectpicker" data-live-search="false" id="sltFiltroDocumento" title="&#xed12; Comprobantes" v-model="compra.idComprobante">
							<option value="1">Factura</option>
							<option value="3">Boleta de venta</option>
							<option value="7">Nota de crédito</option>
							<option value="12">Ticket</option>
							<option value="9">Guía de Remisión</option>
						</select>
						</div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtCompraSerie" class="col-lg-3 col-form-label">Serie y correlativo:</label>
						<div class="col-lg-6"><input type="text" class="form-control text-uppercase" id="txtCompraSerie" style="text-transform:uppercase" v-model="compra.serie" @input="compra.serie = $event.target.value.toUpperCase()"> </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="txtCompraFecha" class="col-lg-3 col-form-label"><span style="white-space:nowrap">Fecha de compra:<span class="text-danger">*</span></span></label>
						<div class="col-lg-6"><input type="date" class="form-control" v-model="compra.fecha"> </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label for="sltFiltroMoneda" class="col-lg-3 col-form-label"><span style="white-space:nowrap">Tipo de Moneda:<span class="text-danger">*</span></span></label>
						<div class="col-lg-4"> 
						<select class="selectpicker" data-live-search="false" id="sltFiltroMoneda" title="&#xed12; Moneda" v-model="compra.idMoneda" @change="cambioMoneda">
							<option value="1">Soles</option>
							<option value="2">Dólares</option>
						</select>
						</div>
					</div>
					<div class="col-sm-6 form-group row" v-show="compra.idMoneda == 2">
						<label for="txtCompraValorDolar" class="col-lg-3 col-form-label">Tipo de cambio:</label>
						<div class="col-lg-3"><input type="text" class="form-control esMoneda" v-model="compra.cambio" value="0.00"> </div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6 form-group row">
						<label class="col-lg-3 col-form-label"><span style="white-space:nowrap">R.U.C.:<span class="text-danger">*</span></span></label>
						<div class="col-lg-6">
							<div class="input-group">
								<input type="text" class="form-control soloNumeros" v-model="compra.ruc" autocomplete="nope" @blur="buscarProveedor" maxlength="11">
								<div class="input-group-append">
									<button class="btn btn-outline-secondary" type="button" @click="buscarProveedor" :disabled="buscandoProveedor"><i class="bi bi-search"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 form-group row">
						<label class="col-lg-3 col-form-label"><span style="white-space:nowrap">Razon Social:<span class="text-danger">*</span></span></label>
						<div class="col-lg-9"><div class="input-group"><input type="text" class="form-control" v-model="compra.razonSocial" autocomplete="nope"><span v-if="buscandoProveedor" class="input-group-text"><span class="spinner-border spinner-border-sm"></span></span></div></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 form-group row">
						<label class="col-lg-3 col-form-label">Dirección:</label>
						<div class="col-lg-6"> <input type="text" class="form-control" v-model="compra.direccion" autocomplete="nope"> </div>
					</div>
					<div class="col-sm-6 form-group row">
						<label class="col-lg-3 col-form-label">Observaciones:</label>
						<div class="col-lg-9"> <input type="text" class="form-control" v-model="compra.obs" autocomplete="nope"> </div>
					</div>					
				</div>

			</div>
		</div>

		<div class="card mt-3">
		<div class="card-body">
			<div class="form-group row mb-0">
				<label for="txtFiltroProducto" class="col-lg-2 col-form-label"><i class="bi bi-funnel"></i> Filtro de producto:</label>
				<div class="col-lg-4">
					<div class="input-group">
						<input type="text" class="form-control" id="txtFiltroProducto" autocomplete="nope" placeholder="Nombre, código" v-model="filtroProducto" @keyup.enter="buscarProductos">
						<div class="input-group-append">
							<button class="btn btn-outline-primary" data-toggle="tooltip" title="Realizar búsqueda" id="btnRealizarBusqueda" @click="buscarProductos"><i class="bi bi-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

		<div class="card mt-3">
		<div class="card-body">
			<h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-receipt"></i> Detalle de la compra</h6>
			<table class="table table-hover">
			<thead>
			<tr>
				<th>N°</th>
				<th>Cant.</th>
				<th>Descripción</th>
				<th>Precio Unit.</th>
				<th>Valor de venta</th>
				<th>@</th>
			</tr>
			</thead>
			<tbody>
			<tr v-for="(prod, idx) in productos" :key="idx" class="cardHijoProducto" :data-id="prod.idProd" :data-und="prod.unidad" :data-afecto="prod.afecto">
				<td>{{ idx + 1 }}.</td>
				<td><input type="text" inputmode="decimal" class="form-control text-center" v-model="prod.cantidad" @input="calcularFila(idx)" @keyup="calcularFila(idx)"></td>
				<td class="text-capitalize">{{ prod.descripcion }}</td>
				<td><input type="text" inputmode="decimal" class="form-control esMoneda text-center" v-model="prod.precUnit" @input="calcularFila(idx)" @keyup="calcularFila(idx)"></td>
				<td><input type="text" inputmode="decimal" class="form-control esMoneda text-center" v-model="prod.valorVenta" readonly></td>
				<td class="text-center"><button class="btn btn-outline-danger border-0 btn-sm" @click="eliminarProducto(idx)"><i class="bi bi-x"></i></button></td>
			</tr>
			<tr v-if="productos.length === 0">
				<td colspan="6" class="text-muted text-left"><i class="bi bi-info-circle"></i> Use el filtro para agregar productos</td>
			</tr>
			</tbody>
			</table>
		</div>
		</div>
		<div class="card my-3">
		<div class="card-body">
			<h6 class="card-subtitle mb-2 text-muted"><i class="bi bi-calculator"></i> Resumen</h6>
			<div class="row text-center">
				<div class="col"><strong>Exoneradas:</strong><br><span class="spanTMonedaR">{{ monedaSimbolo }}</span> {{ exoneradas }}</div>
				<div class="col"><strong>Gravadas:</strong><br><span class="spanTMonedaR">{{ monedaSimbolo }}</span> {{ gravadas }}</div>
				<div class="col"><strong>Sub Total:</strong><br><span class="spanTMonedaR">{{ monedaSimbolo }}</span> {{ subTotal }}</div>
				<div class="col"><strong>I.G.V.:</strong><br><span class="spanTMonedaR">{{ monedaSimbolo }}</span> {{ igv }}</div>
				<div class="col"><strong>Total:</strong><br><span class="spanTMonedaR">{{ monedaSimbolo }}</span> {{ total }}</div>
			</div>
			<div class="text-center my-2">
				<button class="btn btn-outline-primary" @click="validarCesta"><i class="bi bi-save"></i> Validar cesta</button>
				<button class="btn btn-outline-primary mx-2" id="btnGuardarCompraTodo" v-show="cestaValida" @click="guardarCompra"><i class="bi bi-save"></i> Guardar compra</button>
			</div>
		</div>
		</div>
		</div>

	</div>
</section>

<footer class="bg-dark p-3 text-white text-center mt-1 fixed-bottom">
	<p class="mb-0"><i class="bi bi-bookmark"></i>  <small><?php include 'php/version.php';?></small></p>
	<p class="mb-1"><i class="bi bi-bookmark"></i> Facturador Sunat 2.1</p>
</footer>

<!-- Modal para: mostrar productos resultado-->
<div class="modal fade" id="modalProductosEncontrados" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-body">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title blue-text text-accent-2">Productos</h4>
			<div class="table-responsive" id="divResultadoProd"></div>
		</div>
		</div>
	</div>
</div>

<?php include 'modals-emision.php'; ?>
<?php include "php/modal.php"; ?>
<?php include "footer.php"; ?>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script>
const { createApp, ref, reactive, computed, onMounted, watch, nextTick } = Vue;

const app = createApp({
	setup() {
		const filtroProducto = ref('');
		const cestaValida = ref(false);
		const buscandoProveedor = ref(false);

		const compra = reactive({
			idComprobante: '3',
			serie: '',
			fecha: '',
			idMoneda: '1',
			cambio: '0.00',
			ruc: '',
			razonSocial: '',
			direccion: '',
			obs: ''
		});

		const productos = ref([]);

		const monedaSimbolo = computed(() => compra.idMoneda == 2 ? '$' : 'S/');

		const exoneradas = computed(() => {
			let s = 0;
			productos.value.forEach(p => { if (p.afecto == 2) s += parseFloat(p.valorVenta) || 0; });
			return s.toFixed(2);
		});

		const gravadas = computed(() => {
			let s = 0;
			productos.value.forEach(p => { if (p.afecto == 1) s += parseFloat(p.valorVenta) || 0; });
			return s.toFixed(2);
		});

		const subTotal = computed(() => (parseFloat(gravadas.value) / 1.18).toFixed(2));
		const igv = computed(() => (parseFloat(gravadas.value) - parseFloat(subTotal.value)).toFixed(2));
		const total = computed(() => (parseFloat(gravadas.value) + parseFloat(exoneradas.value)).toFixed(2));

		function calcularFila(idx) {
			const p = productos.value[idx];
			const cant = parseFloat(p.cantidad) || 0;
			const prec = parseFloat(p.precUnit) || 0;
			p.valorVenta = (cant * prec).toFixed(2);
			cestaValida.value = false;
		}

		function eliminarProducto(idx) {
			productos.value.splice(idx, 1);
			cestaValida.value = false;
		}

		function buscarProductos() {
			if (filtroProducto.value.length < 2) return;
			$.ajax({url: 'php/filtroProductos.php', type: 'POST', data: { texto: filtroProducto.value }}).done(function(resp) {
				$('#divResultadoProd').html(resp);
				$('[data-toggle="tooltip"]').tooltip();
			});
			$('#modalProductosEncontrados').modal('show');
		}

		function agregarProducto(padre) {
			const und = padre.find('.tdUnidad').attr('data-und');
			const gravado = padre.find('.tdGravado').attr('data-gravado');
			const id = padre.attr('data-id');
			const desc = padre.find('.tdNombreProd').text();
			productos.value.push({
				idProd: id,
				descripcion: desc,
				cantidad: '1',
				precUnit: '0.00',
				valorVenta: '0.00',
				afecto: gravado,
				unidad: und
			});
			$('#modalProductosEncontrados').modal('hide');
			cestaValida.value = false;
		}

		function validarCesta() {
			let tieneError = false;
			productos.value.forEach(p => {
				if (!parseFloat(p.cantidad) || parseFloat(p.cantidad) <= 0) tieneError = true;
				if (!parseFloat(p.precUnit) || parseFloat(p.precUnit) <= 0) tieneError = true;
			});
			if (tieneError || productos.value.length === 0) {
				$('#h5DetalleFaltan').text('Revise la cantidad y precio de cada producto');
				$('#modalFaltaDatos').modal('show');
				cestaValida.value = false;
			} else {
				cestaValida.value = true;
			}
		}

		function guardarCompra() {
			pantallaOver(true);
			if (!compra.idComprobante) { mostrarError('Debe seleccionar un tipo de comprobante'); return; }
			if (!compra.fecha) { mostrarError('La fecha de compra no puede estar vacío'); return; }
			if (!compra.idMoneda) { mostrarError('Debe seleccionar un tipo de moneda'); return; }
			if (!compra.ruc) { mostrarError('Se olvidó ingresar el R.U.C. del proveedor'); return; }
			if (!compra.razonSocial) { mostrarError('Se olvidó ingresar la razón social'); return; }
			if (productos.value.length === 0) { mostrarError('No se puede guardar una compra con una lista vacía'); return; }

			const jsonProductos = productos.value.map(p => ({
				idProd: p.idProd,
				cantidad: p.cantidad,
				precUnit: p.precUnit,
				afecto: p.afecto,
				unidad: p.unidad
			}));

			$.ajax({url: 'php/insertarCompra.php', type: 'POST', data: {
				ruc: compra.ruc,
				razonSocial: compra.razonSocial,
				domicilio: compra.direccion,
				idComprobante: compra.idComprobante,
				compFecha: compra.fecha,
				serie: compra.serie,
				idMoneda: compra.idMoneda,
				monedaCambio: compra.cambio,
				sumExonerado: exoneradas.value,
				sumSubtotal: subTotal.value,
				sumIgv: igv.value,
				sumTotal: total.value,
				compObs: compra.obs,
				jsonProductos: jsonProductos
			}}).done(function(resp) {
				if (resp == 'ok') {
					$('#h5Detalle').text('su compra se guardó correctamente');
					$('#modalGuardadoExitoso').modal('show');
					$('#myModal').on('hidden.bs.modal', function() {
						window.location.href = 'compras.php';
					});
				}
			});
			pantallaOver(false);
		}

		function mostrarError(msg) {
			$('#h5DetalleFaltan').text(msg);
			$('#modalFaltaDatos').modal('show');
			pantallaOver(false);
		}

		function buscarProveedor() {
			const ruc = compra.ruc.trim();
			if (ruc.length < 8) return;
			buscandoProveedor.value = true;
			$.ajax({url: 'php/buscarCliente.php', type: 'POST', contentType: 'application/json', data: JSON.stringify({ texto: ruc })}).done(function(resp) {
				const data = JSON.parse(resp);
				if (data.length > 0) {
					compra.razonSocial = (data[0].cliRazonSocial || '').trim();
					compra.direccion = (data[0].cliDomicilio || '').trim();
				}
			}).always(() => { buscandoProveedor.value = false; });
		}

		function cambioMoneda() {
			nextTick(() => { $('.selectpicker').selectpicker('refresh'); });
		}

		onMounted(() => {
			compra.fecha = moment().format('YYYY-MM-DD');
			$('.selectpicker').selectpicker('render');
			nextTick(() => {
				$('#sltFiltroDocumento').selectpicker('val', '3');
				$('#sltFiltroMoneda').selectpicker('val', '1');
				$('.selectpicker').selectpicker('refresh');
			});
			$('[data-toggle="tooltip"]').tooltip();
		});

		watch(() => compra.idComprobante, () => { nextTick(() => $('.selectpicker').selectpicker('refresh')); });
		watch(() => compra.idMoneda, () => { nextTick(() => $('.selectpicker').selectpicker('refresh')); });

		$('#divResultadoProd').on('click', '#tblProductosResultados tbody tr', function(e) {
			if ($(e.target).closest('button, select, input').length) return;
			agregarProducto($(this));
		});
		$('#divResultadoProd').on('click', '.btnAgregarProdCesta', function(e) {
			e.stopPropagation();
			agregarProducto($(this).closest('tr'));
		});

		return {
			filtroProducto, cestaValida, buscandoProveedor, compra, productos, monedaSimbolo,
			exoneradas, gravadas, subTotal, igv, total,
			calcularFila, eliminarProducto, buscarProductos, agregarProducto,
			validarCesta, guardarCompra, cambioMoneda, buscarProveedor
		};
	}
});

app.mount('#app');
</script>

<script>
	$.decimalSuper = <?= json_encode($decimalesSuper) ?>;
	$.porcentajeIGV1 = <?= json_encode($porcentajeIGV1) ?>;
	$.casaHost = <?= json_encode($casaHost) ?>;
</script>
<script src="js/emision.js"></script>
<?php include "piePagina.php"; ?>
</body>
</html>
