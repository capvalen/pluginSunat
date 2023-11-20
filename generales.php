<?php
//Rellenar por cada Cliente:
$dirBaseSunat = 'C:\SFS_v1.3.4.4\sunat_archivos\sfs';
$directorio = $dirBaseSunat. '\DATA/';
$dirRespuestas = $dirBaseSunat. '\RPTA/';
$rucEmisor ='10198436670';
$nombreEmisor = "Polleria Doradito\nDe: Samaniego Palomino Marta Ida";
$direccionEmisor = "Psje. Mercaderes 108 Huancayo - Huancayo - Junín";
$celularEmisor = "(064) 204832";
$nombrePrint = 'TP300'; //TM-T20II

$casaHost = "pluginsunat";




$separador ='|';

//De la cabecera:
$tipoOperacion = '0101';
$fechaVencimiento = '-';
$domicilioFiscal = '0000';  //cambiar a 1 si es sucursal
$descuento = '0.00';
$sumaCargos ='0.00';
$anticipos ='0.00';
$versionUbl ='2.1';
$customizacion ='2.0';


//Del detalle:
$codSunat = '-';
$tipoTributo='1000';
$nombreTributo = 'IGV';
$tributoExtranjero = 'VAT';
$afectacion = '10';
$porcentajeIGV = $_COOKIE['igvGlobal'];
$porcentajeIGV1 = 1+($porcentajeIGV)/100;
$tributoISC = '-';
$codigoISC = '0.00';
$montoISC = '0.00';
$baseISC = '';
$nombreISC = '';
$codeISC = '';
$tipoISC = '';
$porcentajeISC = '15.00';
$tributo99 = '-';
$tributoOtro = '0.00';
$tributoOtroItem = '0.00';
$baseOtroItem = '';
$codigoOtroItem = '';
$porcentajeOtroItem = '15.00';
$invoce = '11.80';
$ventaInvoce = '11.80';
$valorVentaInvoce='10.00';
$gratuito ='0.00';

//Actualizacion de Creditos
$monedaC = "PEN";
$token = '';

?>