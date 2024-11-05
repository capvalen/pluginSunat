<?php
//Rellenar por cada Cliente:
$dirBaseSunat = 'C:\SFS_v1.3.4.2\sunat_archivos\sfs';
$directorio = $dirBaseSunat. '\DATA/';
$dirRespuestas = $dirBaseSunat. '\RPTA/';
$rucEmisor ='10210130557';
$nombreEmisor = "De: Alvarez Meneses Pablo Cesar";
$direccionEmisor = "Av. Industrial S/N  (Esquina Av. Industrial y Av. España) San Martin de Pangoa - Satipo - Junín";
$celularEmisor = "985 946 052";
$nombrePrint = 'HP1102W'; //TM-T20II
$casaHost = "pluginsunat";

$generarArchivo = false;


$separador ='|';

//De la cabecera:
$tipoOperacion = '0101';
$fechaVencimiento = '-';
$domicilioFiscal = '0000'; ; //cambiar a 1 si es sucursal
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
$porcentajeIGV = $_COOKIE['igvGlobal'] ?? 10; //10 en restaurantes, otros 18
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

$decimalesSuper = $_COOKIE['decimalesSuper'] ?? 6; //cambiar a 2 a facturador simple

//Actualización de créditos
$monedaC = "PEN";
$token = 'apis-token-6396.nevvtud4KzHZaULpHze3L-0DJ581fXeY';

?>