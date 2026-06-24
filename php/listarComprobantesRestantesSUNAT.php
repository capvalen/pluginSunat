<?php 

include __DIR__. '/conexion.php';

$sql="SELECT `idFacturador`, f.`idComprobante`, case when `estado` in (0,1) then 'Comprobante para enviar' when 2 then 'Baja de comprobante' else 'Otro caso' end as estado, date_format(`fechaEmision`, '%d/%m/%Y') as factFecha, date_format(f.factFecha, '%d/%m/%Y %h:%i %p') as fechaOcurrencia, fc.factSerie, fc.factCorrelativo
FROM `facturador` f 
inner join fact_cabecera fc on fc.idComprobante = f.idComprobante
WHERE f.estado in (0,1,2) and fc.factTipoDocumento<>0; ";
$resultado= $cadena->query($sql); $i=1;
$respuesta = array();
while($row=$resultado->fetch_assoc()){ 
	$respuesta[] = $row;
}
echo json_encode($respuesta);	
?>