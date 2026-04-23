<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
	function Header()
	{
		$isLandscape = ($this->CurOrientation == 'L');

		if ($isLandscape) {
			$this->SetFillColor(255, 165, 0);
			$this->Rect(0, 0, 297, 20, 'F');

			$this->SetFont('DejaVuSans', 'B', 12);
			$this->SetTextColor(255, 255, 255);

			$this->Cell(0, 5, utf8_decode('Reporte Mensual de Facturación Electronica - Abril 2026'), 0, 1, 'C');

			$this->Line(0, 20, 297, 20);
		} else {
			$this->SetFillColor(255, 165, 0);
			$this->Rect(0, 0, 210, 20, 'F');

			$this->SetFont('DejaVuSans', 'B', 12);
			$this->SetTextColor(255, 255, 255);
			$this->Cell(0, 5, utf8_decode('Reporte Mensual de Facturación Electronica - Abril 2026'), 0, 1, 'C');

			$this->Line(0, 20, 210, 20);
		}
		$this->Ln(10);
	}

	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('DejaVuSans', 'I', 8);
		$this->SetTextColor(0, 0, 0);
		$this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
	}

	function ResumenEjecutivo($datos)
	{
		$this->SetFont('DejaVuSans', 'B', 9);
		$this->SetFillColor(252, 195, 144);
		$this->SetTextColor(26, 15, 0);
		$this->Cell(0, 10, 'RESUMEN EJECUTIVO', 0, 1, 'L', true);
		$this->Ln(1);
		
		$this->SetFont('DejaVuSans', '', 8);
		$this->Cell(0, 10, 'Cifras globales obtenidas:', 0, 1);
		$this->SetFillColor(255, 255, 255);
		$this->SetDrawColor(184, 180, 180);
		foreach ($datos as $key => $value) {
			$this->Cell(90, 7, $key, 1, 0, 'L', true);
			$this->Cell(90, 7, $value, 1, 1, 'L', true);
		}
		$this->Ln(5);
	}

	function TablaVentas($ventas)
	{
		$this->SetFont('DejaVuSans', 'B', 9);
		$this->SetFillColor(245, 173, 42);
		$this->SetTextColor(255, 255, 255);

		$this->Cell(15, 7, 'N' . chr(176), 1, 0, 'C', true);
		$this->Cell(25, 7, 'Tipo Doc.', 1, 0, 'C', true);
		$this->Cell(30, 7, 'Numero', 1, 0, 'C', true);
		$this->Cell(50, 7, 'Cliente', 1, 0, 'C', true);
		$this->Cell(25, 7, 'Fecha', 1, 0, 'C', true);
		$this->Cell(30, 7, 'Subtotal', 1, 0, 'C', true);
		$this->Cell(25, 7, 'IGV', 1, 0, 'C', true);
		$this->Cell(30, 7, 'Total', 1, 0, 'C', true);
		$this->Cell(30, 7, 'Estado', 1, 1, 'C', true);

		$this->SetFont('DejaVuSans', '', 8);
		$this->SetFillColor(255, 240, 220);
		$fill = false;
		foreach ($ventas as $indice=> $venta) {
			$this->SetTextColor(0, 0, 0);
			$this->Cell(15, 7, $indice+1, 1, 0, 'C', $fill);
			$this->Cell(25, 7, utf8_decode($venta['tipo']), 1, 0, 'C', $fill);
			$this->Cell(30, 7, $venta['documento'], 1, 0, 'C', $fill);
			$this->Cell(50, 7, utf8_decode($venta['cliente']), 1, 0, 'L', $fill);
			$this->Cell(25, 7, $venta['fecha'], 1, 0, 'C', $fill);
			$this->Cell(30, 7, $venta['subtotal'], 1, 0, 'R', $fill);
			$this->Cell(25, 7, $venta['igv'], 1, 0, 'R', $fill);
			$this->Cell(30, 7, $venta['total'], 1, 0, 'R', $fill);
			if( strtolower($venta['estado']) =='anulado')
				$this->SetTextColor(230, 0, 69);
			else
				$this->SetTextColor(25, 48, 255);

			$this->Cell(30, 7, $venta['estado'], 1, 1, 'C', $fill);
			//$fill = !$fill;  //Para intercalar el relleno de las filas, en este caso todo false
		}
	}
}

// Datos de ejemplo
$datosResumen = [
	"Periodo del reporte" => "01 mar. 2026 al 30 mar. 2026",
	"Facturas emitidas" => "45",
	"Boletas emitidas" => "30",
	"Facturas dadas de baja" => "2",
	"Boletas anuladas" => "1",
	"Total facturado" => "S/ 25,000.00",
	"IGV total" => "S/ 4,500.00",
	"Monto anulado" => "S/ 1,200.00"
];

$ventas = [
	["numero" => "0", "tipo" => "Factura", "documento" => "F001-00012", "cliente" => "Importadora del sur", "fecha" => "01/04/2026", "subtotal" => "33.98", "igv" => "61.02", "total" => "400.00", "estado" => "Vigente"],
	["numero" => "1", "tipo" => "Nota de débito", "documento" => "F001-00012", "cliente" => "Importadora del sur", "fecha" => "01/04/2026", "subtotal" => "42.37", "igv" => "7.63", "total" => "50.00", "estado" => "Vigente"],
	["numero" => "2", "tipo" => "Boleta", "documento" => "B001-5678", "cliente" => "Cliente B", "fecha" => "02/04/2026", "subtotal" => "800.00", "igv" => "144.00", "total" => "944.00", "estado" => "Vigente"],
	["numero" => "3", "tipo" => "Factura", "documento" => "F001-1235", "cliente" => "Empresa SAC", "fecha" => "03/04/2026", "subtotal" => "2,500.00", "igv" => "450.00", "total" => "2,950.00", "estado" => "Vigente"],
	["numero" => "4", "tipo" => "Boleta", "documento" => "B001-5679", "cliente" => "Juan Pérez", "fecha" => "03/04/2026", "subtotal" => "150.00", "igv" => "27.00", "total" => "177.00", "estado" => "Vigente"],
	["numero" => "5", "tipo" => "Nota de Crédito", "documento" => "NC001-001", "cliente" => "Cliente A", "fecha" => "04/04/2026", "subtotal" => "-300.00", "igv" => "-54.00", "total" => "-354.00", "estado" => "Anulado"],
	["numero" => "6", "tipo" => "Factura", "documento" => "F001-1236", "cliente" => "Comercial XYZ", "fecha" => "05/04/2026", "subtotal" => "4,200.00", "igv" => "756.00", "total" => "4,956.00", "estado" => "Vigente"],
	["numero" => "7", "tipo" => "Boleta", "documento" => "B001-5680", "cliente" => "María López", "fecha" => "06/04/2026", "subtotal" => "320.50", "igv" => "57.69", "total" => "378.19", "estado" => "Vigente"],
	["numero" => "8", "tipo" => "Factura", "documento" => "F001-1237", "cliente" => "Distribuidora ABC", "fecha" => "07/04/2026", "subtotal" => "1,850.00", "igv" => "333.00", "total" => "2,183.00", "estado" => "Pendiente"],
	["numero" => "9", "tipo" => "Boleta", "documento" => "B001-5681", "cliente" => "Carlos Ruiz", "fecha" => "08/04/2026", "subtotal" => "95.00", "igv" => "17.10", "total" => "112.10", "estado" => "Vigente"],
	["numero" => "10", "tipo" => "Factura", "documento" => "F001-1238", "cliente" => "Tech Solutions", "fecha" => "09/04/2026", "subtotal" => "3,100.00", "igv" => "558.00", "total" => "3,658.00", "estado" => "Vigente"],
	["numero" => "11", "tipo" => "Boleta", "documento" => "B001-5682", "cliente" => "Ana García", "fecha" => "10/04/2026", "subtotal" => "425.75", "igv" => "76.64", "total" => "502.39", "estado" => "Vigente"],
	["numero" => "12", "tipo" => "Factura", "documento" => "F001-1239", "cliente" => "Importadora del Sur", "fecha" => "11/04/2026", "subtotal" => "5,600.00", "igv" => "1,008.00", "total" => "6,608.00", "estado" => "Vigente"],
	["numero" => "13", "tipo" => "Nota de Débito", "documento" => "ND001-001", "cliente" => "Comercial XYZ", "fecha" => "12/04/2026", "subtotal" => "200.00", "igv" => "36.00", "total" => "236.00", "estado" => "Vigente"],
	["numero" => "14", "tipo" => "Boleta", "documento" => "B001-5683", "cliente" => "Luis Mendoza", "fecha" => "13/04/2026", "subtotal" => "180.00", "igv" => "32.40", "total" => "212.40", "estado" => "Anulado"],
	["numero" => "15", "tipo" => "Factura", "documento" => "F001-1240", "cliente" => "Servicios Globales", "fecha" => "14/04/2026", "subtotal" => "2,750.00", "igv" => "495.00", "total" => "3,245.00", "estado" => "Vigente"],
	["numero" => "16", "tipo" => "Boleta", "documento" => "B001-5684", "cliente" => "Patricia Flores", "fecha" => "15/04/2026", "subtotal" => "67.50", "igv" => "12.15", "total" => "79.65", "estado" => "Vigente"],
	["numero" => "17", "tipo" => "Factura", "documento" => "F001-1241", "cliente" => "Constructora Norte", "fecha" => "16/04/2026", "subtotal" => "8,900.00", "igv" => "1,602.00", "total" => "10,502.00", "estado" => "Pendiente"],
	["numero" => "18", "tipo" => "Boleta", "documento" => "B001-5685", "cliente" => "Roberto Sánchez", "fecha" => "17/04/2026", "subtotal" => "299.99", "igv" => "54.00", "total" => "353.99", "estado" => "Vigente"],
	["numero" => "19", "tipo" => "Factura", "documento" => "F001-1242", "cliente" => "Alimentos Andinos", "fecha" => "18/04/2026", "subtotal" => "1,450.00", "igv" => "261.00", "total" => "1,711.00", "estado" => "Vigente"],
	["numero" => "20", "tipo" => "Boleta", "documento" => "B001-5686", "cliente" => "Carmen Díaz", "fecha" => "19/04/2026", "subtotal" => "510.25", "igv" => "91.85", "total" => "602.10", "estado" => "Vigente"],
	["numero" => "21", "tipo" => "Factura", "documento" => "F001-1243", "cliente" => "Logística Express", "fecha" => "20/04/2026", "subtotal" => "3,300.00", "igv" => "594.00", "total" => "3,894.00", "estado" => "Vigente"],
	["numero" => "22", "tipo" => "Nota de Crédito", "documento" => "NC001-002", "cliente" => "Tech Solutions", "fecha" => "21/04/2026", "subtotal" => "-500.00", "igv" => "-90.00", "total" => "-590.00", "estado" => "Vigente"],
	["numero" => "23", "tipo" => "Boleta", "documento" => "B001-5687", "cliente" => "Fernando Torres", "fecha" => "22/04/2026", "subtotal" => "125.00", "igv" => "22.50", "total" => "147.50", "estado" => "Vigente"],
	["numero" => "24", "tipo" => "Factura", "documento" => "F001-1244", "cliente" => "Minera del Pacífico", "fecha" => "23/04/2026", "subtotal" => "12,500.00", "igv" => "2,250.00", "total" => "14,750.00", "estado" => "Pendiente"],
	["numero" => "25", "tipo" => "Boleta", "documento" => "B001-5688", "cliente" => "Isabel Ramos", "fecha" => "24/04/2026", "subtotal" => "89.90", "igv" => "16.18", "total" => "106.08", "estado" => "Vigente"],
	["numero" => "26", "tipo" => "Factura", "documento" => "F001-1245", "cliente" => "Farmacia Central", "fecha" => "25/04/2026", "subtotal" => "980.00", "igv" => "176.40", "total" => "1,156.40", "estado" => "Vigente"],
	["numero" => "27", "tipo" => "Boleta", "documento" => "B001-5689", "cliente" => "Miguel Ángel Castro", "fecha" => "26/04/2026", "subtotal" => "445.80", "igv" => "80.24", "total" => "526.04", "estado" => "Anulado"],
	["numero" => "28", "tipo" => "Factura", "documento" => "F001-1246", "cliente" => "Textiles del Valle", "fecha" => "27/04/2026", "subtotal" => "2,100.00", "igv" => "378.00", "total" => "2,478.00", "estado" => "Vigente"],
	["numero" => "29", "tipo" => "Boleta", "documento" => "B001-5690", "cliente" => "Sofía Vargas", "fecha" => "28/04/2026", "subtotal" => "215.60", "igv" => "38.81", "total" => "254.41", "estado" => "Vigente"],
	["numero" => "30", "tipo" => "Factura", "documento" => "F001-1247", "cliente" => "Electrónica Moderna", "fecha" => "30/04/2026", "subtotal" => "1,675.00", "igv" => "301.50", "total" => "1,976.50", "estado" => "Vigente"],
];

// Crear PDF
$pdf = new PDF();
//Registro de fuentes
$pdf->AddFont('DejaVuSans', '', 'DejaVuSans.php');
$pdf->AddFont('DejaVuSans', 'B', 'DejaVuSans-Bold.php');
$pdf->AddFont('DejaVuSans', 'I', 'DejaVuSans-Oblique.php');
$pdf->SetFont('DejaVuSans', '', 10);

$pdf->AliasNbPages();

// Primera página (resumen ejecutivo, orientación vertical)
$pdf->AddPage('P');
$pdf->ResumenEjecutivo($datosResumen);

// Segunda página (tabla de ventas, orientación landscape)
$pdf->AddPage('L');
$pdf->TablaVentas($ventas);

$pdf->Output('Reporte mensual.pdf', 'I');
