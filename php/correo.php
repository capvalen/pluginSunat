<?php
date_default_timezone_set('America/Lima');
require '../vendor/autoload.php';
require __DIR__ . '/conexion.php';
require '../generales.php';
require '../NumeroALetras.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'config/correo.php';

/** @var mysqli $cadena */

$correo = $_POST['correo'] ?? '';
$serie = $_POST['serie'] ?? '';
$correlativo = $_POST['correlativo'] ?? '';

if (!$correo || !$serie || !$correlativo) {
    echo 'Faltan datos requeridos';
    exit;
}

$tipo = $_POST['tipo'] ?? '';
$whereTipo = $tipo ? " and factTipoDocumento = '$tipo'" : '';

$sql = "SELECT fc.*, 
    case fc.factTipoDocumento when 1 then 'FACTURA' when 3 then 'BOLETA' when 4 then 'Nota de Crédito' when 5 then 'Nota de Débito' when -1 then 'PROFORMA' when 0 then 'TICKET INTERNO' end as queDoc
    FROM `fact_cabecera` fc 
    WHERE fc.factSerie='$serie' and fc.factCorrelativo = '$correlativo' $whereTipo 
    LIMIT 1";
$resultado = $cadena->query($sql);

if ($resultado->num_rows == 0) {
    echo 'Comprobante no encontrado';
    exit;
}

$row = $resultado->fetch_assoc();

$parteEntera = intval($row['totalFinal']);
$parteDecimal = ($row['totalFinal'] - $parteEntera) * 100;
if ($parteDecimal == '0') $parteDecimal = '00';
$letras = trim(NumeroALetras::convertir($parteEntera)) . ' SOLES con ' . $parteDecimal . '/100 MN';

$tipoDoc = '0';
if (strlen($row['dniRUC']) == 11) $tipoDoc = '6';
elseif (strlen($row['dniRUC']) == 8) $tipoDoc = '1';

$sqlDetalle = "SELECT fd.*, u.undCorto FROM `fact_detalle` fd 
    inner join unidades u on u.undSunat = fd.codUnidadMedida
    WHERE fd.facSerieCorre = '$serie-$correlativo'";
$resultadoDetalle = $cadena->query($sqlDetalle);

$productosHtml = '';
while ($prod = $resultadoDetalle->fetch_assoc()) {
    $precio = number_format($prod['mtoPrecioVenta'], 2);
    $cantidad = number_format($prod['cantidadItem'], 2);
    $productosHtml .= "<tr>
        <td style='padding:6px;border:1px solid #ddd;text-align:center;'>{$prod['cantidadItem']}</td>
        <td style='padding:6px;border:1px solid #ddd;'>{$prod['descripcionItem']}</td>
        <td style='padding:6px;border:1px solid #ddd;text-align:right;'>S/ {$precio}</td>
    </tr>";
}

$tipoComprobante = $row['queDoc'];
$total = number_format($row['totalFinal'], 2);
$fecha = date('d/m/Y', strtotime($row['fechaEmision']));
$cliente = $row['razonSocial'];
$docCliente = $row['dniRUC'];
$linkPdf = $webHost . "printComprobantePDF.php?serie=" . urlencode($serie) . "&correlativo=" . urlencode($correlativo);

$htmlBody = "
<html>
<head><meta charset='UTF-8'></head>
<body style='font-family:Arial,sans-serif;padding:20px;color:#333;'>
    <div style='max-width:600px;margin:0 auto;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;'>
        <div style='background:#7030a0;color:white;padding:20px;text-align:center;'>
            <h2 style='margin:0;'>Comprobante Electrónico</h2>
            <p style='margin:5px 0 0;opacity:0.9;'>{$tipoComprobante} {$serie}-{$correlativo}</p>
        </div>
        <div style='padding:20px;'>
            <p>Estimado(a) cliente,</p>
            <p>Adjuntamos su comprobante electrónico con los siguientes detalles:</p>
            <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
                <tr><td style='padding:6px;font-weight:bold;width:120px;'>Comprobante:</td><td style='padding:6px;'>{$tipoComprobante}</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Serie:</td><td style='padding:6px;'>{$serie}-{$correlativo}</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Fecha:</td><td style='padding:6px;'>{$fecha}</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Cliente:</td><td style='padding:6px;'>{$cliente}</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Doc.:</td><td style='padding:6px;'>{$docCliente}</td></tr>
                <tr><td style='padding:6px;font-weight:bold;'>Total:</td><td style='padding:6px;font-size:18px;color:#7030a0;'><strong>S/ {$total}</strong></td></tr>
            </table>
            <table style='width:100%;border-collapse:collapse;margin:15px 0;'>
                <thead><tr style='background:#f5f5f5;'><th style='padding:8px;border:1px solid #ddd;text-align:center;'>Cant.</th><th style='padding:8px;border:1px solid #ddd;text-align:left;'>Producto</th><th style='padding:8px;border:1px solid #ddd;text-align:right;'>Importe</th></tr></thead>
                <tbody>{$productosHtml}</tbody>
            </table>
            <p style='text-align:center;margin:20px 0;'>
                <a href='{$linkPdf}' style='display:inline-block;padding:12px 30px;background:#7030a0;color:white;text-decoration:none;border-radius:5px;font-weight:bold;'>Ver comprobante en PDF</a>
            </p>
            <p style='color:#999;font-size:12px;text-align:center;margin-top:20px;'>Gracias por su preferencia.</p>
        </div>
    </div>
</body>
</html>";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = CORREO_SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = CORREO_SMTP_USER;
    $mail->Password   = CORREO_SMTP_PASS;
    $mail->SMTPSecure = CORREO_SMTP_ENCRYPT;
    $mail->Port       = CORREO_SMTP_PORT;

    $mail->setFrom(CORREO_SMTP_FROM, CORREO_SMTP_FROM_NAME);
    $mail->addAddress($correo);
    $mail->addReplyTo(CORREO_SMTP_FROM, CORREO_SMTP_FROM_NAME);

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Comprobante Electrónico {$tipoComprobante} {$serie}-{$correlativo}";
    $mail->Body    = $htmlBody;

    $mail->send();
    echo 'Mensaje entregado';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
