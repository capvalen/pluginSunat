<?php
require 'conexion.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Token no proporcionado");
}

// Buscar token en BD
$stmt = $datab->prepare("SELECT * FROM usuario WHERE token = ?");
$stmt->execute([$token]);
$data = $stmt->fetch();

if (!$data) {
    die("Token inválido");
}

/*// Validar expiración      <----- Implementar a futuro
if (strtotime($data['expires_at']) < time()) {
    die("Token expirado");
}*/

// Iniciar sesión
$_POST['user'] = $data['usuNick'];
$_POST['token'] = $token;
$_POST['entrada'] = 'token';
ob_start();
include "validarSesion.php";
$response = ob_get_clean();

// Redirigir
// Evaluar respuesta
if (trim($response) === "concedido") {
    header("Location: ../facturador.php");
    exit;
} else {
    echo "Acceso denegado";
}
exit;