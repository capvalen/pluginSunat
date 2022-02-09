<?php
//Rellenar por cada Cliente:
$dirBaseSunat = 'D:\SFS_1.3.4.4\sunat_archivos\sfs';
$directorio = $dirBaseSunat. '\DATA/';
$dirRespuestas = $dirBaseSunat. '\RPTA/';

$rucEmisor ='20568763832';
$nombreEmisor = "I.G. BARSAM S.R.L.";
$direccionEmisor = "Sucursal: Cal. 09 de Octubre N° 1584\n Pblo Huamancaca Chico - Chupaca - Junín\nPrincipal: Jr. José Olaya N° 152 - \nHuancayo - Junín";
$celularEmisor = "972981671";
$nombrePrint = 'CAJA'; //TM-T20II

$casaHost = "pluginSunat";

$generarArchivo = false;



$separador ='|';

//De la cabecera:
$tipoOperacion = '0101';
$fechaVencimiento = '-';
$domicilioFiscal = '0000'; //cambiar a 1 si es sucursal
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
$porcentajeIGV = '18.00';
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


?>