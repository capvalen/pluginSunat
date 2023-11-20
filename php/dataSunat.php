<?php
include "conexion.php";
include "../generales.php";

$fila = array();
$sql="SELECT * FROM `clientes`
where cliRuc = '{$_POST['ruc']}' and cliActivo =1";
$resultado=$cadena->query($sql);
if($resultado->num_rows>=1){
	$row=$resultado->fetch_assoc();
	$fila = array(
		"razon_social" => $row['cliRazonSocial'],
		"domicilio_fiscal" => $row['cliDomicilio'],
		"activo" => 'HABIDO'
	);
	echo json_encode($fila);
}else{
	/* $json = file_get_contents("https://infocatsoluciones.com/app/consorcioSoriano/dataSunat.php?ruc={$_POST['ruc']}");
	$obj = json_decode($json);
	//echo $obj->access_token;
	//var_dump($obj->ruc);
	echo json_encode($obj); 
	$fila = array(
		"razon_social" => '',
		"domicilio_fiscal" => ''
	);*/
	if(strlen($_POST['ruc'])<8){
		$fila = array(
			"razon_social" => '00000000',
			"domicilio_fiscal" => 'Cliente sin documento',
			"activo" => 'HABIDO'
		);
		echo json_encode($fila);
	}
	if( strlen($_POST['ruc'])==8){
		buscarDNI( $token, $_POST['ruc'] );
	}
	if( strlen($_POST['ruc'])==11){
		buscarRUC( $token, $_POST['ruc'] );
	}	
}

function buscarDNI($token, $ruc){
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $ruc,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Referer: http://apis.net.pe/api-ruc',
			'Authorization: Bearer ' . $token
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	$empresa = json_decode($response);
	$fila = array(
		"razon_social" => $empresa->apellidoPaterno . " ". $empresa->apellidoMaterno . " ".$empresa->nombres,
		"domicilio_fiscal" => '',
		"activo" => 'ACTIVO'
	);
	echo json_encode($fila);

}
function buscarRUC($token, $ruc){
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_CUSTOMREQUEST => 'GET',
		CURLOPT_HTTPHEADER => array(
			'Referer: http://apis.net.pe/api-ruc',
			'Authorization: Bearer ' . $token
		),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	// Datos de empresas según padron reducido
	$empresa = json_decode($response);
	//var_dump( $empresa); die();
	$fila = array(
		"razon_social" => $empresa->razonSocial,
		"domicilio_fiscal" => $empresa->direccion . " - ".$empresa->provincia ." - ". $empresa->departamento,
		"activo" => $empresa->estado
	);
	echo json_encode($fila);
}
?>