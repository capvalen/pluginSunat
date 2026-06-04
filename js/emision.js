$.undMap = { GLI: 'GAL', LTR: 'LTR', NIU: 'UND', KGM: 'KG', GRM: 'GR', CAN: 'LATA', PA: 'PK', BAG: 'SBR', BO: 'BOT', BX: 'CAJ', ZZ: '-' };

$(document).ready(function(){
	$.creditos=[];

	$.ajax({url: 'php/getPreciosProductos.php', type: 'POST' }).done(function(resp) {
		console.info('Lista de precios:' );
		$.precios = JSON.parse(resp);
		console.log( $.precios );
	});
	cargarSeriesEnSelector()

});

function cargarSeriesEnSelector() {
	$.ajax({url: 'llamarSeries.php', type: 'POST', async: false }).done(function(resp) {
		$.series = JSON.parse(resp);
	});
	poblarSelectorSeries();
}

function poblarSelectorSeries() {
	if (!$.series || !$.series.length) return;
	var s = $.series[0];
	var $sel = $('#sltSeriesBoleta');
	$sel.find('option:not([value=series])').remove();
	$sel.append('<option id="optBoleta" value="' + s.serieBoleta + '">' + s.serieBoleta + '</option>');
	$sel.append('<option id="optFactura" value="' + s.serieFactura + '">' + s.serieFactura + '</option>');
	/* $sel.append('<option id="optOpcional" value="' + s.serieOpcional + '">' + s.serieOpcional + '</option>');
	$sel.append('<option id="optOpcional2" value="' + s.serieOpcional2 + '">' + s.serieOpcional2 + '</option>'); */
	if ($.tipoSerie === 'boleta') {
		$('#optBoleta').prop('selected', true);
		$('#optFactura').prop('disabled', true);
	} else if ($.tipoSerie === 'factura') {
		$('#optFactura').prop('selected', true);
		$('#optBoleta').prop('disabled', true);
	}
}

$('#AEmitirBoleta').click(function() {
	$.tipoSerie = 'boleta';
	cargarSeriesEnSelector();
	$('#txtDniBoleta').attr('placeholder', 'DNI. o RUC.');
	$('#txtRazonBoleta').attr('placeholder', 'Nombres y apellidos');
	$('#btnEmitirBoletav2').removeClass('d-none');
	$('#btnEmitirFacturav2').addClass('d-none');
	$('#chkEstadoDni').prop('checked', true).change().attr('disabled', false);
	$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'));
	$('#queGenero').text('Boleta de venta');
	$('#modalEmisionBoleta').modal('show');
});

$('#AEmitirFactura').click(function() {
	$.tipoSerie = 'factura';
	cargarSeriesEnSelector();
	$('#txtDniBoleta').attr('placeholder', 'R.U.C.');
	$('#txtRazonBoleta').attr('placeholder', 'Razón social');
	$('#btnEmitirBoletav2').addClass('d-none');
	$('#btnEmitirFacturav2').removeClass('d-none');
	$('#chkEstadoDni').prop('checked', false).change().attr('disabled', true);
	$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'));
	$('#queGenero').text('Factura');
	$('#modalEmisionBoleta').modal('show');
});


$('#chkEstadoDni').change(function() {
	if($('#chkEstadoDni').prop('checked')){
		$('#labelEstadoDni').text('Cliente anónimo');
		$('.selectpicker').selectpicker('val', -1);
		$('#txtDniBoleta').focus();
	}else{
		$('#labelEstadoDni').text('Cliente con Documento');
		$('#txtDniBoleta').focus();
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

$('#divProductos').on('keyup','.campoSubTotal', function() {	
	var padre = $(this).parent().parent();
	var subTotal = 0;
	var precio = parseFloat(padre.find('.campoPrecioUnit').val());
	var cantidad = 0;
	if($(this).val()!=''){
		subTotal = parseFloat($(this).val());
	}
	cantidad = parseFloat(subTotal/precio);
	if( cantidad==Infinity ){
		cantidad=0;
	}
	padre.find('.campoCantidad').val( cantidad.toFixed($.decimalSuper) );
	sumaTodo();
});

$('#divProductos').on('keyup','.campoPrecioUnit', function() {
	var padre = $(this).parent().parent();
	var precio = 0;
	var cantidad = parseFloat(padre.find('.campoCantidad').val());
	var subTotal = 0;
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
	var subTotal = 0;
	subTotal = parseFloat(cantidad*precio);
	padre.find('.campoSubTotal').val( subTotal.toFixed($.decimalSuper) );
	sumaTodo();
});

function sumaTodo() {
	var sumaTotal=0, afectos = 0, exonerados = 0;
	
	$.each( $('.campoSubTotal'), function(i, elem){
		if( $(elem).val()!='' ){
			if( $(elem).attr('data-exonerado')=='1' ){
				afectos+=parseFloat($(elem).val());
			}else{
				exonerados+=parseFloat($(elem).val());
			}
		}
	});
	sumaTotal=afectos+exonerados;
	var costo = afectos/parseFloat($.porcentajeIGV1);
	var igv=afectos-costo;
	$('#spExoneradoBoleta').text(parseFloat(exonerados).toFixed(2));
	$('#spSubTotBoleta').text(parseFloat(costo).toFixed(2));
	$('#spIgvBoleta').text(parseFloat(igv).toFixed(2));
	$('#spTotalBoleta').text(parseFloat(sumaTotal).toFixed(2));
	calcularVuelto();
}

$('#btnEmitirBoletav2').click(function() {
	pantallaOver(true)
	
	const promesaCompletoTodo = new Promise((resolve, reject) => {
		var truncado = false;
		$.each( $('.cardHijoProducto'), function (i, elem) { 
			
			if( $(elem).find('.sltFiltroProductos').selectpicker('val')=='1' && $(elem).find('.campoTextoLibre').val()=='' ){
				truncado = true;
			}
			if( i== $('.cardHijoProducto').length -1 && truncado ==true ){
				$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Existen conceptos vacíos en uno de los items').parent().removeClass('d-none');
				reject('falta datos');
			}else if( i== $('.cardHijoProducto').length -1 && truncado ==false ){
				$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
				resolve('completo todo')
			}
		});
	});

	promesaCompletoTodo.then(resPromesa => {
		
		if( $('#sltSeriesBoleta').val()=='series'){
			$('#sltSeriesBoleta').focus();
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('#sltTemporal').selectpicker('val')==null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un producto').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('.esMoneda').val()=='0.00' || $('.cardHijoProducto').first().find('.esMoneda').val()==0 || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()=='0.00' || $('.cardHijoProducto').first().find('.campoPrecioUnit').val()==0 ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste ingresar una cantidad / precio').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('#sltfiltroTemporal').selectpicker('val')==null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar una unidad').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('#spTotalBoleta').text()=='0.00' ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none'); pantallaOver(false);
		}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none'); pantallaOver(false);
		}else if( parseFloat($('#spTotalBoleta').text())>700 && $('#txtDniBoleta').val().length<8 ){
			$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Ésta boleta por ser mayor a S/ 700.00 requiere DNI').parent().removeClass('d-none'); pantallaOver(false);
		}
		else{
			var jsonCliente= [];

			if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
				jsonCliente.push({dni: $('#txtDniBoleta').val(),
					razon: $('#txtRazonBoleta').val(),
					direccion: $('#txtDireccionBoleta').val(),
					contado: $.creditos.length==0 ? 1 : 2,
					fechaCredito : $('#txtDateVencimiento').val(),
					adelanto: 0,
					montoCredito:0,
					observaciones: $('#txtObservaciones').val()
				});
			}else{
				jsonCliente.push({
					dni:'00000000',
					razon: 'Cliente sin documento',
					direccion: '',
					contado: $.creditos.length==0 ? 1 : 2,
					fechaCredito : $('#txtDateVencimiento').val(),
					adelanto: 0,
					montoCredito:0,
					observaciones: $('#txtObservaciones').val()
				})
			}
			var jsonProductos = [];
			$.each( $('.cardHijoProducto'), function (i, elem) {
				var productVariable ='';
					if($(elem).find('.divNombProducto').attr('data-tipo')=='libre'){
						productVariable = $(elem).find('.campoTextoLibre').val();
					}else{
						productVariable = $(elem).find('.divNombProducto button').attr('title')
					}
					jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
						descripcionProducto: productVariable,
						precioProducto: $(elem).find('.campoPrecioUnit').val(),
						unidadProducto: $(elem).find('.divUnidadProducto button').attr('title'),
						unidadSunat: $(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val'),
						unidadCorto: $.undMap[$(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val')],
						subtotal: $(elem).find('.campoSubTotal').val(),
						afecto: $(elem).find('#sltFiltroGravado').selectpicker('val'),
						idProd: $(elem).attr('data-producto')
					});
			});
			var dniRc ='', razon='';
			if($('#txtDniBoleta').val()!=''){
				dniRc=$('#txtDniBoleta').val();
				razon=$('#txtRazonBoleta').val()
			}else{
				dniRc='00000000';
				razon='Cliente sin documento';
			}
			
			$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 3, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon, cliDireccion: $('#txtDireccionBoleta').val(),jsonProductos: jsonProductos, jsonCliente:jsonCliente, fecha: $('#txtFechaComprobante').val(), creditos: $.creditos }}).done(function(resp) {
				console.log(resp)
				$.jTicket = JSON.parse(resp); console.log( $.jTicket );
				if($.jTicket.length >=1){
					$('#modalEmisionBoleta').modal('hide');
					$('#modalArchivoBien').modal('show');
				}
				pantallaOver(false)
			});
		}

	}).finally(()=>{
		pantallaOver(false)
	})
	
});

$('#btnEmitirFacturav2').click(function() {
	pantallaOver(true)

	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	if( $('#sltSeriesBoleta').val()=='series'){
		$('#sltSeriesBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidaste seleccionar un tipo de serie').parent().removeClass('d-none');
	}else if( $('#txtDniBoleta').val().length!=11 ){
		$('#txtDniBoleta').focus();
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> El RUC del cliente, no es correcto').parent().removeClass('d-none'); pantallaOver(false)
	}else if( $('#txtRazonBoleta').val()=='' ){
		$('#txtRazonBoleta').focus(); pantallaOver(false)
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> La razón social no puede estar en blanco').parent().removeClass('d-none');
	}else if( $('#spTotalBoleta').text()=='0.00' ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber al menos un producto con precio').parent().removeClass('d-none'); pantallaOver(false)
	}else if( $('.cardHijoProducto').first().find('.sltFiltroProductos').selectpicker('val')== null ){
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Debe haber seleccionar al menos un producto').parent().removeClass('d-none'); pantallaOver(false)
	}else{
		var jsonCliente= [];
		if( $('#txtDniBoleta').val()!='' && $('#txtRazonBoleta').val()!='' ){
			jsonCliente.push({dni: $('#txtDniBoleta').val(),
				razon: $('#txtRazonBoleta').val(),
				direccion: $('#txtDireccionBoleta').val(),
				contado: $.creditos.length==0 ? 1 : 2,
				fechaCredito : $('#txtDateVencimiento').val(),
				adelanto: 0,
				montoCredito:0,
				observaciones: $('#txtObservaciones').val()
			});
		}else{
			jsonCliente.push({
				dni:'00000000',
				razon: 'Cliente sin documento',
				direccion: '',
				contado: $.creditos.length==0 ? 1 : 2,
				fechaCredito : $('#txtDateVencimiento').val(),
				adelanto: 0,
				montoCredito:0,
				observaciones: $('#txtObservaciones').val()
			})
		}
		var jsonProductos= [];
		$.each( $('.cardHijoProducto'), function (i, elem) {
			if($(elem).find('.divNombProducto').attr('data-tipo')=='libre'){
					productVariable = $(elem).find('.campoTextoLibre').val();
				}else{
					productVariable = $(elem).find('.divNombProducto button').attr('title')
				}
			jsonProductos.push({cantidad: $(elem).find('.campoCantidad').val(),
				descripcionProducto: productVariable,
				precioProducto: $(elem).find('.campoPrecioUnit').val(),
				unidadProducto: $(elem).find('.divUnidadProducto button').attr('title'),
				unidadSunat: $(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val'),
				unidadCorto: $.undMap[$(elem).find('.divUnidadProducto .sltFiltroUnidad').selectpicker('val')],
				subtotal: $(elem).find('.campoSubTotal').val(),
				afecto: $(elem).find('#sltFiltroGravado').selectpicker('val'),
				idProd: $(elem).attr('data-producto')
			});
		});
		var dniRc ='', razon='';
		if($('#txtDniBoleta').val()!=''){
			dniRc=$('#txtDniBoleta').val();
			razon=$('#txtRazonBoleta').val()
		}else{
			dniRc='00000000';
			razon='Cliente sin documento';
		}
		$.ajax({url: 'php/insertarBoleta.php', type: 'POST', data: { emitir: 1, queSerie: $('#sltSeriesBoleta').val(), dniRUC: dniRc, razonSocial: razon, cliDireccion: $('#txtDireccionBoleta').val(), jsonProductos: jsonProductos, jsonCliente: jsonCliente, fecha: $('#txtFechaComprobante').val(), creditos: ($.creditos) }}).done(function(resp) {
			console.log(resp)
			$.jTicket = JSON.parse(resp); console.log( $.jTicket );
			if($.jTicket.length >=1){
				$('#modalEmisionBoleta').modal('hide');
				$('#modalArchivoBien').modal('show');
			}
			pantallaOver(false)
		});
	}
});

$('#modalArchivoBien').on('hidden.bs.modal', function () { 
	location.reload();
});

$('#btnPrintTicketera').click(function() { console.log( 'ticketera' );
	imprimitEnTicketera()
});

function imprimitEnTicketera(){
	$.ajax({url: 'http://127.0.0.1/'+$.casaHost+'/printComprobante.php', type: 'POST', data: {
				tipoComprobante: $.jTicket[0].tipoComprobante,
				rucEmisor: $.jTicket[0].rucEmisor,
				queEs: $.jTicket[0].queSoy,
				serie: $.jTicket[0].serie,
				correlativo: $.jTicket[0].correlativo,
				tipoCliente: $.jTicket[0].tipoCliente,
				fecha: $.jTicket[0].fechaEmision,
				fechaLat: moment($.jTicket[0].fechaEmision, 'YYYY-MM-DD').format('DD/MM/YYYY'),
				cliente: $.jTicket[0].razonSocial,
				docClient: $.jTicket[0].ruc,
				monedas: $.jTicket[0].letras,
				descuento: parseFloat($.jTicket[0].descuento).toFixed(2),
				costoFinal: parseFloat($.jTicket[0].costoFinal).toFixed(2),
				igvFinal: parseFloat($.jTicket[0].igvFinal).toFixed(2),
				totalFinal: parseFloat($.jTicket[0].totalFinal).toFixed(2),
				productos: $.jTicket[1],
				direccion:$.jTicket[0].direccion,
				exonerado: parseFloat($.jTicket[0].exonerado).toFixed(2),
			}}).done(function(resp) {
				console.log(resp)
			});
}

$('#btnPrintA4').click(function() {
	window.open('printComprobanteA4.php?serie=' + encodeURIComponent($.jTicket[0].serie) + '&correlativo=' + encodeURIComponent($.jTicket[0].correlativo) + '&tipo=' + $.jTicket[0].tipoComprobante ,'_blank');
	location.reload();
});

$('#btnPrintPDF').click(function() {
	window.open('printComprobantePDF.php?serie=' + encodeURIComponent($.jTicket[0].serie) + '&correlativo=' + encodeURIComponent($.jTicket[0].correlativo) + '&tipo=' + $.jTicket[0].tipoComprobante,'_blank');
	location.reload();
});

function quitarPlaceholderProductos() {
	$('#placeholderProductos').remove();
}

$('#btnAgregarProducto').click(function() {
	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	var $ultimo = $('#divProductos .sltFiltroProductos').last();
	if ($ultimo.length && $ultimo.is(':visible') && !$.isNumeric($ultimo.selectpicker('val'))) {
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Falta seleccionar un producto').parent().removeClass('d-none');
		return;
	}
	if ($('#divProductos .cardHijoProducto').length && !$('#divProductos .sltFiltroUnidad').last().selectpicker('val')) {
		$('#modalEmisionBoleta .lblError').html('<i class="bi bi-chat-dots"></i> Olvidó rellenar una unidad').parent().removeClass('d-none');
		return;
	}
	$.ajax({url: 'php/filaNueva.php', type: 'POST' }).done(function(resp) {
		quitarPlaceholderProductos();
		$('#divProductos').append(resp);
		$('.selectpicker').selectpicker('render');
	});
});

$('#btnAgregarLibre').click(function() {
	$('#modalEmisionBoleta .lblError').parent().addClass('d-none');
	$.ajax({url: 'php/filaNueva.php', type: 'POST' }).done(function(resp) {
		quitarPlaceholderProductos();
		$('#divProductos').append(resp);
		$('.selectpicker').selectpicker('render');
		var $row = $('#divProductos .cardHijoProducto').last();
		$row.find('.divNombProducto').attr('data-tipo', 'libre');
		var $select = $row.find('.sltFiltroProductos');
		var libreVal = $select.find('option').first().val();
		if (libreVal) $select.selectpicker('val', libreVal);
		$select.addClass('d-none');
		$row.find('.campoTextoLibre').removeClass('d-none').focus();
		$row.find('.sltFiltroUnidad').selectpicker('val', 'NIU');
		$row.find('.sltFiltroPrecios').selectpicker('val', '0');
		$row.find('.campoPrecioUnit').prop('readonly', false).val('0.00');
		$row.find('.sltFiltroGravado').selectpicker('val', $.precios[0].idGravado); 
		
	});
});

$('#divProductos').on('changed.bs.select', '.sltFiltroProductos', function (e, clickedIndex, isSelected, previousValue) {
	var padre = $(this).parent().parent();
	
	if( $('.sltFiltroProductos').selectpicker('val')!=null && $('.sltFiltroProductos').selectpicker('val')!='' ){
		var queProd= $('.sltFiltroProductos').selectpicker('val');
		
		$.each( $.precios , function(i, prodObj){
			if(prodObj.idProductos==queProd){
				padre.attr('data-producto', prodObj.idProductos );
				padre.find('.sltFiltroUnidad #sltfiltroTemporal').selectpicker('val', prodObj.undSunat ).selectpicker('refresh');;
				padre.find('.sltFiltroGravado').selectpicker('val', prodObj.idGravado ).selectpicker('refresh');
				padre.find('.campoPrecioUnit').val(parseFloat(prodObj.prodPrecio).toFixed(2));
				padre.find('.campoSubTotal').val(parseFloat(prodObj.prodPrecio).toFixed(2)).attr('data-exonerado', padre.find('#sltFiltroGravado').selectpicker('val'));
				padre.find('.campoCantidad').val(1).focus();

				padre.find('.selectpicker').selectpicker('refresh');
			}
		});

		if( clickedIndex ==1){
			padre.find('.sltFiltroProductos').addClass('d-none');
			padre.find('.campoTextoLibre').removeClass('d-none').focus();
			padre.find('.sltFiltroPrecios').selectpicker('val', 0);
			padre.find('.campoPrecioUnit').prop('readonly', false);
		}
		else if(clickedIndex>1){
			padre.find('.sltFiltroPrecios').selectpicker('val', 1);
			padre.find('.campoPrecioUnit').prop('readonly', true);
		}
		padre.find('.sltFiltroUnidad').selectpicker('val', 'NIU')
		sumaTodo();
	}
});

$('#divProductos').on('click', '.borrarFila', function (e) {
	var padre=$(this).parent().parent();
	if($('.cardHijoProducto').length>1){
		padre.remove();
	}else{
		padre.remove();
		$('#divProductos').append('<div class="text-muted py-3" id="placeholderProductos"><i class="bi bi-chevron-down"></i> Seleccione una opción</div>');
	}
	sumaTodo();
});

$('#divProductos').on('click', '.optPrecios', function (e) {
	var padre = $(this).parent().parent().parent().parent().parent().parent().parent();
	padre.find('.campoPrecioUnit').prop('readonly',true);
	
	switch ( padre.find('#sltFiltroPrecios').selectpicker('val')) {
		case "0":
			padre.find('.campoPrecioUnit').prop('readonly',false).focus().val('0.00');
		case "1":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecio).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		case "2":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecioMayor).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		case "3":
			$.each( $.precios , function(i, prodObj){
				if(prodObj.idProductos == padre.attr('data-producto') ){
					padre.find('.campoPrecioUnit').val( parseFloat(prodObj.prodPrecioDescto).toFixed(2) ).keyup(); sumaTodo(); return false;
				}
			});
			break;
		default:
			break;
	}
	
});

var divFecha = document.getElementById('divFecha');
var divSeries = document.getElementById('divSeries');
var divCreditos = document.getElementById('divCreditos');
function mostrarFecha(){
	$('#txtDateVencimiento').val(moment().format('YYYY-MM-DD'))
	divFecha.classList.toggle('d-none'); ocultarPadre() }
function mostrarSeries(){ divSeries.classList.toggle('d-none'); ocultarPadre() }
function mostrarCreditos(){
	$('#txtDateVencimiento').val(moment().add(1, 'day').format('YYYY-MM-DD'))
	$('#txtMontoCredito').val($('#spTotalBoleta').text())
	divCreditos.classList.toggle('d-none'); ocultarPadre()
}
function ocultarPadre(){
	if($('#cardAtributos .d-none').length == 6 ){
		$('#cardAtributos').addClass('d-none')
	}else{
		$('#cardAtributos').removeClass('d-none')
	}
}

$("#txtDniBoleta").keyup(function(e){
	var code = e.which;
	if($('#txtDniBoleta').val().length==11){
		$('#btnReniec').parent().addClass('d-none')
		$('#btnSunat').parent().removeClass('d-none')
	}else{
		$('#btnReniec').parent().removeClass('d-none')
		$('#btnSunat').parent().addClass('d-none')
	}

	if( code==13 ){
		e.preventDefault();
		buscarReniec()
	}
});

function buscarReniec(){
	pantallaOver(true);

	if( ![0,8,11].includes($("#txtDniBoleta").val().length) ){
		alertify.error('<i class="bi bi-exclamation-diamond"></i> Datos del DNI no son correctos.', 8000);
		pantallaOver(false);
		return
	}
	$('#txtDniBoleta').val( $.trim($('#txtDniBoleta').val()) )	
	$.ajax({url: 'php/dataSunat.php', type: 'POST', data: { ruc: $('#txtDniBoleta').val() }}).done(function(resp) {
		try {
			dato = JSON.parse(resp);
			if(dato.length=!0){	
				$('#txtRazonBoleta').val( dato.razon_social);
				$('#txtDireccionBoleta').val( dato.domicilio_fiscal);
			}
		} catch (error) {}
		pantallaOver(false);
	});
}

$('#txtPagaCuanto').keyup(function() {
	calcularVuelto()
});

function calcularVuelto(){
	if( $('#txtPagaCuanto').val()!=''){
		if( $('#txtPagaCuanto').val() > parseFloat($('#spTotalBoleta').text()) ){
			$('#spanVuelto').text( parseFloat(parseFloat($('#txtPagaCuanto').val()) - parseFloat($('#spTotalBoleta').text())).toFixed(2) );
			$('#spanVuelto').parent().parent().removeClass('d-none')
		}else{
			$('#spanVuelto').parent().parent().addClass('d-none')
		}
	}else{
		$('#spanVuelto').parent().parent().addClass('d-none')
	}
}

$('#btnAddCredito').click(()=>{
	$('#modalEmisionBoleta').modal('hide')
});

$('#btnCerrarCredito').click(()=>{
	if($('#txtCreditoFecha').val() !='' && $('#txtCreditoMonto').val()!='' )
		$.creditos.push({fecha:$('#txtCreditoFecha').val(), monto: $('#txtCreditoMonto').val() })
	$('#modalCreditos').modal('hide')
	dibujarCreditos()
});

function dibujarCreditos(){
	var html = ''
	$.creditos.forEach(credito=>{
		html +='<li>'+ fechaLatam(credito.fecha) +' - S/ '+ parseFloat(credito.monto).toFixed(2) + '</li>'
	})
	$('#divCuantosCreditos').html(html)
}

function fechaLatam(fechita){
	if(fechita) return moment(fechita).format('DD/MM/YYYY')
}

$('#txtFechaComprobante').focusout(function() {
	let hoy = moment( moment().format('YYYY-MM-DD'), 'YYYY-MM-DD')
	let comprobante = moment($('#txtFechaComprobante').val(), 'YYYY-MM-DD')
	let diferencia = hoy.diff(comprobante, 'days')
	if( diferencia<0 ){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}else if(diferencia>4){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}else if( isNaN(diferencia)){
		$('#txtFechaComprobante').val(moment().format('YYYY-MM-DD'))
	}
});
