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
		$info = consultarDNI( $_POST['ruc'], $api_dni );
	}
	if( strlen($_POST['ruc'])==11){
		$info = consultarRUC( $_POST['ruc'], $token );
	}
	echo json_encode($info, true);
}

function consultarDNI($dni, $token_dni){
	$url = "https://dnis.infocat.workers.dev/api/dni/{$dni}/{$token_dni}";

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
	
	// Si hay error en la respuesta (Formato incorrecto o DNI no encontrado)
	if (isset($data['error'])) {
		return filaVacia();
	}
	
	// Si tiene los datos esperados, devolver fila con datos
	if (isset($data['dni'], $data['apellido'], $data['nombre'])) {
			return array(
					"razon_social" => limpiarTexto($data['completo'] ?? $data['apellido'] . ', ' . $data['nombre']),
					"domicilio_fiscal" => isset($data['direccion']) ? limpiarTexto($data['direccion']) : '',
					"activo" => 'ACTIVO',
					"paterno" => limpiarTexto($data['apellido']),
					"materno" => '',
					"nombres" => limpiarTexto($data['nombre'])
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