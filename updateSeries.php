<?php
include "conexion.php";

$sql="UPDATE `fact_series` SET `serieFactura`='{$_POST['serFact']}',`serieBoleta`='{$_POST['serBol']}' WHERE 1;";
$resultado=$cadena->query($sql);
if( $resultado ){
	echo 'ok';
}else{
	echo "Hubo un error interno";
}
?>