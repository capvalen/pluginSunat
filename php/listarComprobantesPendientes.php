<?php 
date_default_timezone_set('America/Lima');
include 'conexion.php';

$sql="SELECT `idFacturador`, f.`idComprobante`, case `estado` when 0 then 'Falta' else 'otro caso' end as estado, date_format(`fechaEmision`, '%d/%m/%y %h:%i %p') as factFecha, fc.factSerie, fc.factCorrelativo, fc.fechaEmision as fecha, fc.factTipoDocumento
FROM `facturador` f 
inner join fact_cabecera fc on fc.idComprobante = f.idComprobante
WHERE estado =0 and factTipoDocumento<>0; ";
$resultado=$cadena->query($sql);
$respuesta = array();

$facturas = ['fechaAnterior' => null, 'contador' => 0 ];
$boletas = ['fechaAnterior' => null, 'contador' => 0 ];

while($row=$resultado->fetch_assoc()){

	$fechaActual = $row['fecha'];

	if( $row['factTipoDocumento']==1){ //caso de facturas
		// Si es la primera iteración O la fecha actual es más antigua que la guardada
		if ($facturas['fechaAnterior'] === null || strtotime($fechaActual) < strtotime($facturas['fechaAnterior'])) {
				$facturas['fechaAnterior'] = $fechaActual;
		}
		$facturas['contador']++;
	}
	if( $row['factTipoDocumento']==3){ //caso de boletas
		// Si es la primera iteración O la fecha actual es más antigua que la guardada
		if ($boletas['fechaAnterior'] === null || strtotime($fechaActual) < strtotime($boletas['fechaAnterior'])) {
				$boletas['fechaAnterior'] = $fechaActual;
		}
		$boletas['contador']++;
	}
	
}

//Calculamos los días
$hoy = new DateTime('now');
$diferenciaFactura = 0;
$diferenciaBoleta = 0;
if($facturas['fechaAnterior']){
	$ultimaFactura = new DateTime($facturas['fechaAnterior']);
	$diferenciaFactura = $hoy->diff($ultimaFactura)->days;
}
if($boletas['fechaAnterior']){
	$ultimaBoleta = new DateTime($boletas['fechaAnterior']);
	$diferenciaBoleta = $hoy->diff($ultimaBoleta)->days;
}
$diasRestantesFactura = 2-$diferenciaFactura;
$diasRestantesBoleta = 5-$diferenciaBoleta;

$formato = new IntlDateFormatter(
    'es_PE',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'America/Lima',
    IntlDateFormatter::GREGORIAN,
    "EEEE, d 'de' MMMM"
);

$dia = '';
$texto = '';

//Armamos el texto:
if ($facturas['contador'] > 0 || $boletas['contador'] > 0) {
    $dia = 'Día: '. $formato->format($hoy);
    $texto .= ($facturas['contador']>0 ? "Hay {$facturas['contador']} factura" . (($facturas['contador'] >1) ? "s" : '') . ", faltan {$diasRestantesFactura} días.\n" : '');
    $texto .=  ($boletas['contador']>0 ? "Hay {$boletas['contador']} boleta" . (($boletas['contador']>1 )? 's' :'' ) . ", faltan {$diasRestantesBoleta} días." :'');
}

echo json_encode(array(
	'facturas'=> $facturas,
	'boletas'=> $boletas,
	'diferenciaFactura'=>$diferenciaFactura,
	'diferenciaBoleta'=>$diferenciaBoleta,
	'diasRestantesFactura'=>$diasRestantesFactura,
	'diasRestantesBoleta'=>$diasRestantesBoleta,
	'dia' => $dia,
	'comentario' => $texto,
));	
