<?php

/* Change to the correct path if you copy this example! */
require __DIR__ . '/vendor/mike42/escpos-php/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\EscposImage; //librería de imagen
/**
 * Assuming your printer is available at LPT1,
 * simpy instantiate a WindowsPrintConnector to it.
 *
 * When troubleshooting, make sure you can send it
 * data from the command-line first:
 *  echo "Hello World" > LPT1
 */
 
    //$connector = new WindowsPrintConnector("smb://192.168.1.131/TM-U220");
$connectorV31 = new WindowsPrintConnector("smb://192.168.0.3/XP-58");
try {
    // A FilePrintConnector will also work, but on non-Windows systems, writes
    // to an actual file called 'LPT1' rather than giving a useful error.
    // $connector = new FilePrintConnector("LPT1");
    /* Print a "Hello world" receipt" */
    $tux = EscposImage::load("bitmap.png", false);

    $printer = new Printer($connectorV31);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> bitImage($tux);
    $printer -> setEmphasis(true);
    $printer -> text("\nINFOCAT SOLUCIONES S.A.C.\n");
    $printer -> text("RUC: 20602337147\n");
    $printer -> setEmphasis(false);
    $printer -> text("Av. Huancavelica 435 - El Tambo - Huancayo -\n");
    $printer -> text("Cel: 977692108\n");
    $printer -> setEmphasis(true);
    $printer -> text("BOLETA ELECTRÓNICA\n");
    $printer -> text("EB01-19\n"); //Cambniar Codigooooooooo
    $printer -> setEmphasis(false);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Fecha de emisión: 15/02/2018\n");
    $printer -> text("Señor(es): Perucash\n");
    $printer -> text("Doc. Ident.: 00000000\n");
    $printer -> text("Dirección: Las Retamas\n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("1 UND Teclado Logitec K120 USB \n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer -> text("S/ 33.00 \n");
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("---------------------------------\n");
    $printer -> text("Sub Total: S/ 27.97 \n");
    $printer -> text("IGV (18%): S/ 5.03 \n");
    $printer -> text("Total: S/ 33.00 \n");
    $printer -> text("SON: TREINTA Y TRES SOLES 00/100 \n");
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer -> text("--------------------------------\n");
    $printer -> text("www.infocatsoluciones.com\n");
    $printer -> text("Gracias por tu preferencia\n\n");
    
    $printer -> text("--------------------------------\n");
    $printer -> text("Esta es una representación impresa de la factura electrónica, generada en el Sistema de SUNAT. Puede verificarla utilizando su Clave SOL.\n");
    $printer -> cut();
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "No se pudo imprimir en la impresora: " . $e -> getMessage() . "\n";
}