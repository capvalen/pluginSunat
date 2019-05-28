<?php
include "conexion.php";

$sql="SELECT * FROM `clientes`
where cliRuc = '{$_POST['ruc']}' and cliActivo =1";
$resultado=$cadena->query($sql);
if($resultado->num_rows>=1){
	$fila = array();

	$row=$resultado->fetch_assoc();
	$fila = array(
		"razon_social" => $row['cliRazonSocial'],
		"domicilio_fiscal" => $row['cliDomicilio']
	);
	echo json_encode($fila);

}else{
	$json = file_get_contents("https://infocatsoluciones.com/app/hospedajeBahamas/dataSunat.php?ruc={$_POST['ruc']}");
	$obj = json_decode($json);
	//echo $obj->access_token;
	//var_dump($obj->ruc);
	echo json_encode($obj);
}
?>