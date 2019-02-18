<?php
include('phpqrcode/qrlib.php'); 

require __DIR__ . '/vendor/mike42/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage; //librería de imagen

$separador ='|';
$tempDir = './';
$filename = "qrtemp";
$body =  $_POST['rucEmisor'] .$separador. $_POST['tipoComprobante'] .$separador. $_POST['serie'] .$separador. $_POST['correlativo'] .$separador. $_POST['igvFinal'] .$separador. $_POST['totalFinal'] . $separador. $_POST['fecha'] . $separador. $_POST['tipoCliente'] . $separador. $_POST['docClient']. $separador;
$codeContents = $body; 
QRcode::png($codeContents, $tempDir.''.$filename.'.png', QR_ECLEVEL_L, 5);


$productos=$_POST['productos'];
$todoProd= '';
foreach ($productos as $variable) {
    $todoProd = $todoProd.$variable['cantidad']." UND ". $variable['descripcion'] .'  S/ '. number_format($variable['precio'],2)."\n";
}
//echo $todoProd;


$connectorV31 = new WindowsPrintConnector("smb://127.0.0.1/xp-58");
try {

    $tux = EscposImage::load("bitmap.jpg", false);
    $tuxQR = EscposImage::load("qrtemp.png", false);

    $printer = new Printer($connectorV31);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> bitImage($tux);
    $printer -> setEmphasis(true);
    $printer -> text("\nINVERSIONES PORTAIMPORT S.A.C.\n");
    $printer -> text("RUC: 20568472862\n");
    $printer -> setEmphasis(false);
    $printer -> text("Cal. Los Lirios N°256 Urb. Primavera Lima El Agustino\n");
    $printer -> setEmphasis(true);
    $printer -> text("{$_POST['queEs']} ELECTRÓNICA\n");
    $printer -> text("{$_POST['serie']} - {$_POST['correlativo']}\n"); //Cambniar Codigooooooooo
    $printer -> setEmphasis(false);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Fecha de emisión: 15/02/2018\n");
    $printer -> text("Doc. Ident.: {$_POST['docClient']}\n");
    $printer -> text("Señor(es): {$_POST['cliente']}\n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("{$todoProd}\n");
    $printer -> text("---------------------------------\n");
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