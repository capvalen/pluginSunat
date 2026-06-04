<!-- Modal Archivo Bien (success post-emisión) -->
<div class="modal fade" id="modalArchivoBien" tabindex="-1" role="dialog" data-backdrop="static" >
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header border-0">
				<h5 class="modal-title">Guardado exitoso</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<img src="images/successful.jpg" class="img-fluid px-5 mb-2">
				<h5>Comprobante generado correctamente. </h5>
				<p>¿Qué deseas hacer a continuación?</p>
				<div class="d-flex justify-content-between">
					<button class="btn btn-outline-primary" id="btnPrintTicketera"><i class="bi bi-clipboard2"></i> Imprimir ticket</button>
					<button class="btn btn-outline-success d-none d-sm-block" id="btnPrintA4"><i class="bi bi-printer"></i> Ver en A4</button>
					<button class="btn btn-outline-success d-block d-sm-none" id="btnPrintPDF"><i class="bi bi-printer"></i> Ver en PDF</button>
				</div>
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
				<i class="bi bi-x"></i>
				</button>
				<h4 class="py-3 hTitulo"><i class="bi bi-clipboard2"></i> Generar: <span id="queGenero"></span> Electrónica</h4>
				<div class="row d-none">
					<div class="col">
						<div class="checkbox checkbox-success mb-3">
							<input id="checkbox2" class="styled" type="checkbox" id="chkFecha" onchange="mostrarFecha()">
							<label for="checkbox2">Fecha</label>
						</div>
					</div>
					<div class="col">
						<div class="checkbox checkbox-success mb-3">
							<input id="checkbox3" class="styled" type="checkbox" id="chkSerie" onchange="mostrarSeries()">
							<label for="checkbox3">Serie</label>
						</div>
					</div>
					<div class="col">
						<div class="checkbox checkbox-success mb-3">
							<input id="chkCreditos" class="styled" type="checkbox" id="chkPago" onchange="mostrarCreditos()">
							<label for="chkCreditos">Pago al contado</label>
						</div>
					</div>
				</div>
				<div class="card mb-2" id="cardAtributos">
					<div class="card-body row">
						<div class="form-check mb-3 d-none">
							<input class="form-check-input" type="checkbox" value="" id="chkEstadoDni" >
							<label class="form-check-label" id="labelEstadoDni" for="chkEstadoDni" >Cliente anónimo</label>
						</div>
						<div class="form-check mb-3 ml-5 d-none">
							<label for="">Placa de vehículo:</label>
							<input type="text" class='form-control text-uppercase ml-3' placeholder="N° Placa &#xee1e;" id="txtPlacaBoleta">
						</div>
						<div class="col">
							<label class="pr-3 text-muted mt-2" for=""><strong>Clientes guardados:</strong></label>
							<select class="selectpicker" data-live-search="true" id="sltFiltroClientes" title="&#xed12; Filtro de clientes">
							<?php include "php/listarTodosClientes.php";?>
						</select>
						</div>
						<div class="col " id="divFecha">
							<label class="pr-3  text-muted mt-2" for=""><strong>Fecha:</strong></label>
							<input type="date" class="form-control  mr-2" id="txtFechaComprobante">
						</div>
					
						<div class="col " id="divSeries">
							<label class="pr-3 text-muted mt-2" for=""><strong>Serie:</strong></label>
							<div class="dropdown">
							<select class="form-control" id="sltSeriesBoleta">
								<option value="series" selected>Series</option>
							</select>
							</div>
						</div>
						<div class="col" id="divCreditos">
							<label class="pr-3 text-muted mt-2 w-100" for=""><strong>Crédito y fechas:</strong></label>
							<button class="btn btn-sm btn-outline-secondary" id="btnAddCredito" data-toggle="modal" data-target="#modalCreditos"><i class="bi bi-stars"></i> Agregar crédito</button>
						</div>
						<div class="col" id="divCuantosCreditos">
						</div>
					</div>
				</div>
			
				
				<div id="divDatosCliente" class=" card mb-3">
					<div class="card-body">
						<p class="text-muted "><strong>Datos del cliente:</strong></p>
						<div class="row mb-2">
							<div class="col-4">
								<div class="input-group mb-2">
									<input type="text" class="form-control ml-2 soloNumeros" id="txtDniBoleta" placeholder="Dni o RUC" autocomplete="off">
									<div class="input-group-append">
										<button class="btn btn-outline-secondary" type="button" id="btnReniec" onclick="buscarReniec()"><img src="images/reniec.png" width="16"> Reniec</button>
									</div>
									<div class="input-group-append d-none">
										<button class="btn btn-outline-secondary" type="button" id="btnSunat" onclick="buscarReniec()"><img src="images/sunat.webp" width="16"> SUNAT</button>
									</div>
								</div>
							</div>
							<div class="col-8">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtRazonBoleta" value="" placeholder='Razón social o Apellidos y Nombres' autocomplete="off">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<input type="text"  class="form-control ml-2 text-capitalize" id="txtDireccionBoleta" value="" placeholder='Dirección' autocomplete="off">
							</div>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<p class="text-muted d-none mb-0"><strong>Detalle:</strong></p>
						<div class="row text-muted">
							<div class="col-6 col-md-4"><strong>Concepto</strong></div>
							<div class="col-6 col-md-2"><strong>Cant.</strong></div>
							<?php if($_COOKIE['facCambiarUnidad']==1): ?>
							<div class="col-6 col-md-2"><strong>Und</strong></div>
							<?php endif;
							if($_COOKIE['facCambiarGravado']==1): ?>
							<div class="col-6 col-md-2"><strong>Gravado.</strong></div>
							<?php endif; ?>
							<div class="col-6 col-md-2"><strong>Precio</strong></div>
							<?php if($_COOKIE['verCantidad']==1):?>
							<div class="col-6 col-md-2 "><strong>Precio Unit.</strong></div>
							<?php endif;?>
							<div class="col-6 col-md-2 d-none"><strong>Sub-Total</strong></div>
						</div>
						<div id="divProductos">
							<?php include "php/filaNueva.php";?>
						</div>
						<button class="btn btn-outline-success btn-sm mt-2" id="btnAgregarProducto"><i class="bi bi-plus-lg"></i> Agregar más produtos</button>
					</div>
				</div>
				<div class='my-3 '>
					<div class="container row row-cols-2 row-cols-md-4 text-center" id="divCalculosFinales">
						<span><small>Exonerado:</small> <span>S/ <span id="spExoneradoBoleta">0.00</span></span></span>
						<span><small>Sub-Total:</small> <span>S/ <span id="spSubTotBoleta">0.00</span></span></span>
						<span><small>IGV:</small> <span>S/ <span id="spIgvBoleta">0.00</span></span></span>
						<span><small>Total:</small> <strong>S/ <span id="spTotalBoleta">0.00</span></strong></span>
					</div>
				</div>
				
				<div class="container-fluid row mt-3 d-flex justify-content-end">
					<span id="spanErrorFinal" for="" class=" d-none"> <span class="lblError"></span></span>
				</div>
				
			
			<div class="container-fluid">
				<div class="row">
					<div class="col">
						<p class="mb-0"><small>Observaciones adicionales:</small></p>
						<input type="text" class="form-control" id="txtObservaciones">
					</div>
				</div>
			</div>
			
			<div class="container-fluid row d-flex justify-content-end my-3">
				<div class="row">
					<label for="" class="col-sm-4 col-form-label text-right"><small>Paga con:</small></label>
					<input type="number" class="form-control col-sm-3" id="txtPagaCuanto">
					<label for="" class="col-sm-4 col-form-label d-none"><small>Vuelto: S/<span id="spanVuelto"></span></small></label>
				</div>
				<div class="col mt-2 mt-md-0">
					<button type="button" class="btn btn-outline-success float-right d-none" id="btnEmitirFacturav2" ><i class="bi bi-bookmark-star"></i> Emitir Factura</button>
					<button type="button" class="btn btn-outline-primary float-right" id="btnEmitirBoletav2" ><i class="bi bi-bookmark-star"></i> Emitir Boleta</button>
				</div>
				<div class="container-fluid row mt-3 d-flex justify-content-end d-none" id="">
					<span id="spanLimiteSobrepasado" style="background: #e6330a!important;"><span class=""><i class="bi bi-chat-dots"></i> Se sobrepasó el límite máximo en comprobantes.</span></span>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Modal para pedir fechas y monto -->
<div class="modal fade" id="modalCreditos" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Agregar crédito</h5>
			</div>
			<div class="modal-body">
				<label for="">Fecha del próximo pago:</label>
				<input type="date" class="form-control text-center" id="txtCreditoFecha">
				<label for="">Monto de pago:</label>
				<input type="number" class="form-control text-center" id="txtCreditoMonto">
				<center class="mt-2"><button class="btn btn-lg btn-primary " id="btnCerrarCredito" data-toggle="modal" data-target="#modalEmisionBoleta">Agregar crédito</button></center>
			</div>
		</div>
	</div>
</div>

<!-- Overlay de carga -->
<div id="overlay">
	<div class="text"><span id="hojita"><i class="bi bi-circle-half"></i></span> <p id="pFrase"> Solicitando los datos a Sunat... <br> <span>«Pregúntate si lo que estás haciendo hoy <br> te acerca al lugar en el que quieres estar mañana» <br> Walt Disney</span></p></div>
</div>
