<?php 
require("../conexion.php");

$filas=array();
$i=0;

$sql="SELECT * FROM `productos` where prodActivo=1;";
$resultado=$cadena->query($sql);
while($row=$resultado->fetch_assoc()){ 
	$filas[$i]= $row;
	$i++;
}

echo json_encode($filas);

?>