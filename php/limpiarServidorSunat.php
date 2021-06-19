<?php 
sleep(15);
$current_dir = dirname(__FILE__);

include "../generales.php";

$directorio="../comprobantes/";


if(is_dir($directorio)){
	//echo "es directorio";
	if ($dir = opendir($directorio)) {
		echo '<ul>'; //Abrimos una lista HTML para mostrar los archivos

		while (($archivoSinFirma = readdir($dir)) !== false){ //Comenzamos a leer archivo por archivo, validamos si es un archivo real

			if ($archivoSinFirma != '.' && $archivoSinFirma != '..' && strpos($archivoSinFirma, '.cab')){//Omitimos los archivos del sistema . y ..

				echo '<li>';
				
				echo 'Archivo: '.$archivoSinFirma; //simplemente imprimimos el nombre del archivo actual
				
				
					$archivoConFirma = str_replace('.cab','',$archivoSinFirma);
					echo "BASE: ". $archivoConFirma;
					
						//Actualizar estado en la DB
						actualizarDB($archivoConFirma, $directorio);
					
				
				'</li>'; 
			}

		}//finaliza While
		echo '</ul>';//Se cierra la lista
		$arZip = $directorio."datosSunat.zip";
		if(file_exists($arZip)){ unlink($arZip); }
		
	}
}else{
	echo "La ruta del Facturador es erronea";
}

function actualizarDB($archivoConFirma, $dirBase){
	$tempCabecera = $dirBase . $archivoConFirma.'.cab';
	$tempDetalle = $dirBase . $archivoConFirma.'.det';
	$tempLeyenda = $dirBase . $archivoConFirma.'.ley';
	$tempTri = $dirBase . $archivoConFirma.'.tri';

	if(file_exists($tempCabecera)){ unlink($tempCabecera); }
	if(file_exists($tempDetalle)){ unlink($tempDetalle); }
	if(file_exists($tempLeyenda)){ unlink($tempLeyenda); }
	if(file_exists($tempTri)){ unlink($tempTri); }
		
}


?>