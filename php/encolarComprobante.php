<?php
include "conexion.php";

$sql = $cadena->prepare("INSERT INTO `facturador`(`idComprobante`, `estado`, `factFecha`) VALUES (?, 0, current_timestamp() );");
if($resP = $sql->execute([ $_POST['id'] ])){
	echo 'ok';
}else{
	echo 'error';
}

