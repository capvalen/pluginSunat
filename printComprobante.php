<?php
include('phpqrcode/qrlib.php'); 
include "generales.php";

require __DIR__ . '/vendor/mike42/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage; //librería de imagen


include "vendor/autoload.php";

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;


$separador ='|';
$tempDir = './';
$filename = "qrtemp";
$body =  $_POST['rucEmisor'] .$separador. $_POST['tipoComprobante'] .$separador. $_POST['serie'] .$separador. $_POST['correlativo'] .$separador. $_POST['igvFinal'] .$separador. $_POST['totalFinal'] . $separador. $_POST['fecha'] . $separador. $_POST['tipoCliente'] . $separador. $_POST['docClient']. $separador ;

$qrCode = new QrCode($body);
$qrCode->setSize(260);
$qrCode->setWriterByName('png');
$qrCode->setMargin(10);
$qrCode->setEncoding('UTF-8');
$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::LOW));
$qrCode->writeFile(__DIR__.'/qrcode.png');


$productos=$_POST['productos'];
$todoProd= '';
foreach ($productos as $variable) {
    $todoProd = $todoProd.$variable['cantidad']." ".$variable['undCorto']." | ". "S/ ". $variable['preProducto']." | ". ucwords($variable['descripcion']) .'  S/ '. number_format($variable['precio'],2)."\n";
}
//echo $todoProd;


$connectorV31 = new WindowsPrintConnector("smb://127.0.0.1/".$nombrePrint);
try {

    $tux = EscposImage::load("bitmap.jpg", false);
    $tuxQR = EscposImage::load("qrcode.png", false);

    $printer = new Printer($connectorV31);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> bitImage($tux);
    $printer -> setEmphasis(true);
    $printer -> text("\nAGRO DISTRIBUCIONES MAYRA EIRL\n");
    $printer -> text("RUC: 20601638810\n");
    $printer -> setEmphasis(false);
    $printer -> text("Jr. Petrona Apoalaya N° 398 Pblo Chupaca Chupaca Junín\n");
    $printer -> setEmphasis(true);
    $printer -> text("{$_POST['queEs']} ELECTRÓNICA\n");
    $printer -> text("{$_POST['serie']} - {$_POST['correlativo']}\n"); //Cambniar Codigooooooooo
    $printer -> setEmphasis(false);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Fecha de emisión: ".date('d/m/Y')."\n");
    $printer -> text("Doc. Ident.: {$_POST['docClient']}\n");
    $printer -> text("Señor(es): ".strtoupper($_POST['cliente'])."\n");
    if($_POST['direccion']==''){
        $printer -> text("Dirección: ---\n");
    }else{
        $printer -> text("Dirección: ".strtoupper($_POST['direccion'])."\n");}
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("CANT |  P.UNIT.  |  PRODUCTO  |  SUBTOTAL  |\n");
    $printer -> text("{$todoProd}\n");
    $printer -> text("--------------------------------\n");
    $printer -> text("Descuento: S/ {$_POST['descuento']} \n");
    $printer -> text("Sub Total: S/ {$_POST['costoFinal']} \n");
    $printer -> text("IGV (18%): S/ {$_POST['igvFinal']} \n");
    $printer -> text("Total: S/ {$_POST['totalFinal']} \n");
    $printer -> text("SON: {$_POST['monedas']} \n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer -> bitImage($tuxQR);
    $printer -> text("--------------------------------\n");
    $printer -> text("Gracias por tu preferencia\n\n");
    $printer -> text("Esta es una representación impresa de la factura electrónica, generada en el Sistema de SUNAT. Puede verificarla utilizando su Clave SOL.\n");
    $printer -> cut();
    // Close printer 
    $printer -> close();
} catch (Exception $e) {
    echo "No se pudo imprimir en la impresora: " . $e -> getMessage() . "\n";
}