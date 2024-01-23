<?php
//include('phpqrcode/qrlib.php'); 
include "generales.php";


//require __DIR__ . '/vendor/mike42/escpos-php/autoload.php';
require __DIR__ . '/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;

use Mike42\Escpos\EscposImage; //librería de imagen


include "vendor/autoload.php";

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


$separador ='|';
$tempDir = './';
$filename = "qrtemp";
$body =  $_POST['rucEmisor'] .$separador. $_POST['tipoComprobante'] .$separador. $_POST['serie'] .$separador. $_POST['correlativo'] .$separador. $_POST['igvFinal'] .$separador. $_POST['totalFinal'] . $separador. $_POST['fecha'] . $separador. $_POST['tipoCliente'] . $separador. $_POST['docClient']. $separador ;

/* $qrCode = new QrCode($body);
$qrCode->setSize(260);
$qrCode->setWriterByName('png');
$qrCode->setMargin(10);
$qrCode->setEncoding('UTF-8');
$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::LOW));
$qrCode->writeFile(__DIR__.'/qrcode.png'); */

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create($body)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
    ->setSize(300)
    ->setMargin(10)
    ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));


$result = $writer->write($qrCode);

// Save it to a file
$result->saveToFile(__DIR__.'/qrcode.png');


$productos=$_POST['productos'];
$todoProd= '';
foreach ($productos as $variable) {
    $todoProd = $todoProd .  ucwords($variable['descripcion'])."\n              ".$variable['cantidad']." ".$variable['undCorto']."   ". "S/ ". number_format($variable['preProducto'],2).'   S/ '. number_format($variable['precio'],2)."\n";
}
//echo $todoProd;
if($_POST['queEs']!='PROFORMA' && $_POST['queEs']!="NOTA DE PEDIDO"){ $queEs = $_POST['queEs'] . " ELECTRÓNICA"; }else{ $queEs = $_POST['queEs']; }
if (isset($_POST['ticketera'])){ $nombrePrint= $_POST['ticketera'];}

$connectorV31 = new WindowsPrintConnector("smb://127.0.0.1/CAJA");

//$connectorV31 = new WindowsPrintConnector("smb://127.0.0.1/".$nombrePrint);
try {
    $printer = new Printer($connectorV31);


    $tux = EscposImage::load("bitmap.jpg", false);
    $tuxQR = EscposImage::load("qrcode.png", false);

    $printer = new Printer($connectorV31);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> bitImage($tux);
    $printer -> setEmphasis(true);
    $printer -> text($nombreEmisor."\n");
    $printer -> text("RUC: ".$rucEmisor."\n");
    $printer -> setEmphasis(false);
    $printer -> text("".$direccionEmisor."\n");
    $printer -> setEmphasis(true);
    $printer -> text("{$queEs}\n");
    $printer -> text("{$_POST['serie']}-{$_POST['correlativo']}\n"); //Cambniar Codigooooooooo
    $printer -> setEmphasis(false);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Fecha de emisión: ". $_POST['fechaLat'] ."\n");
    $printer -> text("Doc. Identidad: {$_POST['docClient']}\n");
    $printer -> text("Señor(es): ".strtoupper($_POST['cliente'])."\n");
    if($_POST['direccion']==''){
        $printer -> text("Dirección: ---\n");
    }else{
        $printer -> text("Dirección: ".strtoupper($_POST['direccion'])."\n");}
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("DESCRIPCION  | CANT |  P.UNIT.  |  SUBTOTAL  |\n");
    $printer -> text("{$todoProd}\n");
    $printer -> text("--------------------------------\n");
    $printer -> text("Exonerado: S/ {$_POST['exonerado']} \n");
    $printer -> text("Sub Total: S/ {$_POST['costoFinal']} \n");
    $printer -> text("IGV (18%): S/ {$_POST['igvFinal']} \n");
    $printer -> text("Total: S/ {$_POST['totalFinal']} \n");
    $printer -> text("SON: {$_POST['monedas']} \n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer -> text("Tipo de pago: Contado\n");
	if($_POST['serie']==''){
    $printer -> text("Contacto: ".$celularEmisor."\n");
	
		$printer -> text("No olvide reclamar su comprobante\n");
	}else{
		$printer -> bitImage($tuxQR);
		$printer -> text("--------------------------------\n");
    $printer -> text("Contacto: ".$celularEmisor."\n");
    $printer -> setTextSize(1, 1);
    $printer -> text("Esta es una representación impresa de la factura electrónica, generada en el Sistema de SUNAT. Puede verificarla utilizando su Clave SOL.\n");
	}	
    $printer -> text("Gracias por tu preferencia\n");
    
    $printer -> cut();
    // Close printer 
    $printer -> close();
} catch (Exception $e) {
    echo "No se pudo imprimir en la impresora: " . $e -> getMessage() . "\n";
}