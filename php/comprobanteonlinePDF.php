<?php
// ticket.php
// Requiere la librería: composer require tecnickcom/tcpdf

require_once('../vendor/autoload.php');
$logo_path = '../bitmap.jpg';


// Crear nuevo documento PDF
$pdf = new TCPDF('P', 'mm', array(80, 170), true, 'UTF-8', false);
$pdf->setPrintHeader(false); // Elimina la línea y texto del encabezado
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);

$permissions = array( 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-high');
$pdf->SetProtection($permissions, null, 'infocat@carlos', 0);


$pdf->SetMargins(5,5,5); //setear márgenes
$pdf->SetAutoPageBreak(true, 5);

// Agregar página
$pdf->AddPage();

// Usar celdas en lugar de HTML para mejor control
$y = $pdf->GetY();

// ============ LOGO ============
if (file_exists($logo_path)) {
    // Image(ruta, x, y, ancho, alto, tipo, enlace, align, resize, dpi)
    $pdf->Image($logo_path, 8, 5, 60, 0, 'JPG', '', '', true, 300);
}
$pdf->SetY(22);
// ============ ENCABEZADO ============
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 6, 'CENTRO SALUD EXCELENTEMENTE E.I.R.L.', 0, 1, 'C');
$pdf->SetFont('helvetica', 'b', 8);
$pdf->Cell(0, 4, 'R.U.C.: 10486113532', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(0, 4, 'Av Huayna Capac N° 321 Of. 202', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, '064 603228 - 984894659 - 996644350', 0, 1, 'C');

// Separador eliminado
$pdf->Ln(2);

// ============ TIPO DOCUMENTO ============
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(0, 5, 'BOLETA ELECTRÓNICA', 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 4, 'B001-00000152', 0, 1, 'C');

// Separador eliminado
$pdf->Ln(2);

// ============ DATOS DEL CLIENTE ============
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(15, 4, 'Cliente:', 0, 0);
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, 'JUAN PEREZ', 0, 1);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(15, 4, 'D.N.I.:', 0, 0);
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, '12345678', 0, 1);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(15, 4, 'Fecha:', 0, 0);
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, '16/04/2018', 0, 1);

$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(15, 4, 'Moneda:', 0, 0);
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, 'SOLES', 0, 1);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(20, 4, 'Tipo de pago:', 0, 0);
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, 'Contado', 0, 1);

// Separadores eliminados
$pdf->Ln(1);

// ============ TABLA DE ITEMS ============

//Cabecera de productos:

/* $pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(12, 5, 'CANT', 0, 0);
$pdf->Cell(38, 5, 'DESCRIPCION', 0, 0);
$pdf->Cell(20, 5, 'P.UNIT', 0, 1, 'R');
// Item
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(12, 4, '1.00', 0, 0);
$pdf->Cell(38, 4, 'SERVICIO INFORMATICA', 0, 0);
$pdf->Cell(20, 4, '423.73', 0, 1, 'R'); */

//Cabecera para servicios:
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(50, 5, 'DESCRIPCIÓN', 0, 0);
$pdf->Cell(20, 5, 'COSTO', 0, 1, 'R');

$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(50, 4, 'SERVICIO INFORMATICA', 0, 0);
$pdf->Cell(20, 4, '423.73', 0, 0, 'R');


// Separadores eliminados
$pdf->Ln(6);

// ============ TOTALES ============
$pdf->Cell(55, 4, 'OP. GRAVADAS:', 0, 0);
$pdf->Cell(0, 4, 'S/ 423.73', 0, 1, 'R');

$pdf->Cell(55, 4, 'I.G.V. (18%):', 0, 0);
$pdf->Cell(0, 4, 'S/ 76.27', 0, 1, 'R');

$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(55, 6, 'TOTAL:', 0, 0);
$pdf->Cell(0, 6, 'S/ 500.00', 0, 1, 'R');

// Monto en letras
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(0, 4, 'SON: QUINIENTOS Y 00/100 SOLES', 0, 1);

// Calcular posición centrada (ancho del papel 80mm - ancho QR 25mm) / 2 = 27.5mm
$qr_width = 30;
$paper_width = 80;
$x_center = ($paper_width - $qr_width) / 2; // Resultado: 27.5mm

$qr_text = '20123456789 | 01 | F001 | 000123 | 18.00 | 118.00 | 2026-03-29 | 6 | 20556677889 |';
$style = array(
    'border' => 0,  // Sin borde
    'vpadding' => 'auto',
    'hpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => array(255,255,255),
    'module_width' => 1,
    'module_height' => 1
);
$pdf->write2DBarcode($qr_text, 'QRCODE,L', $x_center, $pdf->GetY(), $qr_width, $qr_width, $style);
$pdf->Ln(30); // Avanzar después del QR


// ============ LEYENDA ============
$pdf->SetFont('helvetica', '', 6);
$texto_largo = 'Representación de Boleta Electrónica. Puede ser consultada en: https://e-consulta.sunat.gob.pe. Visible en SUNAT a partir de 24 - 48 horas posterior a la emisión mediante Resolución de Superintendencia N° 0150-2021/SUNAT.';
$pdf->MultiCell(0, 3, $texto_largo, 0, 'C', 0, 1);
$pdf->Cell(0, 3, '¡Gracias por su compra!', 0, 1, 'C');

// Generar el PDF
$pdf->Output('boleta_electronica.pdf', 'I');
?>
