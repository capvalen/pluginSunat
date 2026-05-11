<?php
header('Content-Type: application/json');
include __DIR__ . "/conexion.php";

if (empty($_POST['id']) || empty($_POST['ruc']) || empty($_POST['razonSocial'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$id = intval($_POST['id']);
$ruc = $cadena->real_escape_string(trim($_POST['ruc']));
$razonSocial = $cadena->real_escape_string(trim($_POST['razonSocial']));
$direccion = $cadena->real_escape_string(trim($_POST['direccion']));

$sql = "UPDATE `fact_cabecera` SET `dniRUC` = '$ruc', `razonSocial` = '$razonSocial', `cliDireccion` = '$direccion' WHERE `idComprobante` = $id";

if ($cadena->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Campos actualizados correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $cadena->error]);
}
