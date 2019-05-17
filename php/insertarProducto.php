<?php 

date_default_timezone_set('America/Lima');
include "conexion.php";

$sql="INSERT INTO `productos`(`idProductos`, `prodDescripcion`, `idUnidad`, `prodPrecio`, `prodPrecioMayor`, `prodPrecioDescto`, `prodStock`, `idGravado`, `prodActivo`) 
select null, '{$_POST['nombre']}', u.idUnidad, {$_POST['precio']}, {$_POST['mayor']}, {$_POST['descuento']}, 0, {$_POST['gravado']}, 1
from unidades u where u.undSunat = '{$_POST['unidad']}'
";
$resultado=$cadena->query($sql);
echo "ok";
?>