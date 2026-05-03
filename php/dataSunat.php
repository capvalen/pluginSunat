<?php
include __DIR__."/conexion.php";
include __DIR__. "/../generales.php";

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
			"ruc" => '00000000',
			"razon_social" => 'Cliente sin documento',
			"domicilio_fiscal" => '-',
			"activo" => 'HABIDO'
		);
		echo json_encode($fila);
	}
	if( strlen($_POST['ruc'])==8){
		$info = consultarDNI( $_POST['ruc'], $token );
	}
	if( strlen($_POST['ruc'])==11){
		$info = consultarRUC( $_POST['ruc'], $token );
	}
	echo json_encode($info, true);
}

function consultarDNI($dni, $token ){
	$url = "https://dniruc.apisperu.com/api/v1/dni/{$dni}?token={$token}";

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	$response = curl_exec($ch);

	// Si hay error de cURL, devolver fila vacía
	if (curl_errno($ch)) {
		curl_close($ch);
		return filaVacia();
	}
	
	// Obtener código HTTP
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	// Si no es 200, devolver fila vacía
	if ($httpCode !== 200) { return filaVacia(); }
	
	// Decodificar JSON
	$data = json_decode($response, true);
	
	// Si no se encontraron resultados, devolver fila vacía
	if (isset($data['message']) && $data['message'] === 'No se encontraron resultados.') {
		return filaVacia();
	}
	
	// Si tiene los datos esperados, devolver fila con datos
	if (isset($data['dni'], $data['nombres'], $data['apellidoPaterno'], $data['apellidoMaterno'])) {
			return array(
					"razon_social" => limpiarTexto($data['apellidoPaterno']) . ' ' . limpiarTexto($data['apellidoMaterno']) . ' ' . limpiarTexto($data['nombres']),
					"domicilio_fiscal" => '',
					"activo" => 'ACTIVO',
					"paterno" => limpiarTexto($data['apellidoPaterno']),
					"materno" => limpiarTexto($data['apellidoMaterno']),
					"nombres" => limpiarTexto($data['nombres'])
			);
	}
	
	// Cualquier otro caso, devolver fila vacía
	return filaVacia();

}

function filaVacia() {
	return array(
		"razon_social" => '',
		"domicilio_fiscal" => '',
		"activo" => 'ACTIVO',
		"paterno" => '',
		"materno" => '',
		"nombres" => ''
	);
}
function consultarRUC($ruc, $token) {
	$url = "https://dniruc.apisperu.com/api/v1/ruc/{$ruc}?token={$token}";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	
	// Agregar header Content-Type: application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
	));
	
	$response = curl_exec($ch);
	
	if (curl_errno($ch)) {
			curl_close($ch);
			return filaVaciaRUC();
	}
	
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if ($httpCode !== 200) {
		return filaVaciaRUC();
	}
	
	$data = json_decode($response, true);
	//var_dump($data);
	
	if (isset($data['message']) && $data['message'] === 'No se encontraron resultados.') {
		return filaVaciaRUC();
	}  
	
	if (isset($data['razonSocial'])) {
		return array(
			"razon_social" => limpiarTexto($data['razonSocial']),
			"domicilio_fiscal" => isset($data['direccion']) ? limpiarTexto($data['direccion']) : '',
			"activo" => (isset($data['estado']) && $data['estado'] === 'ACTIVO') ? 'ACTIVO' : 'INACTIVO'
		);
	}
	
	return filaVaciaRUC();
}


function filaVaciaRUC() {
	return array(
		"razon_social" => '',
		"domicilio_fiscal" => '',
		"activo" => 'ACTIVO'
	);
}

function limpiarTexto($texto) {
    if ($texto === null) return '';
    // Elimina comillas dobles al inicio y final, y espacios extra
    $texto = trim($texto, ' "');
    // Elimina espacios múltiples internos
    $texto = preg_replace('/\s+/', ' ', $texto);
    return trim($texto);
}