<table class="table table-hover" id="tblProductosResultados">
<thead>
<tr>
	<th>Cod.</th>
	<th>Descripción</th>
	<th>Precio</th>
	<th>Stock</th>
	<th>Und.</th>
	<th>Afecto</th>
	<th>@</th>
</tr>
</thead>
<tbody>

<?php 

include 'conexion.php';

$sql="SELECT p.`idProductos`, lower(`prodDescripcion`) as prodDescripcion, p.`idUnidad`, `prodPrecio`, `prodStock`, p.`idGravado`, lower(u.undCorto) as undCorto, g.gravDescripcion FROM `productos`  p
inner join unidades u on u.idUnidad = p.idUnidad
inner join gravados g on g.idGravado = p.idGravado
/*inner join codigobarras cb on p.idProductos = cb.idProducto*/
where  p.prodDescripcion like concat('%','{$_POST['texto']}', '%') /*or cb.codCodigo=''*/ and  `prodActivo`=1
group by p.idProductos
order by p.prodDescripcion asc";
$resultado=$cadena->query($sql);
$i=0;
while($row=$resultado->fetch_assoc()){ ?>

<tr>
	<td> #<?=$row['idProductos']; ?> </td>
	<td class="text-capitalize"> <?=$row['prodDescripcion']; ?> </td>
	<td> <?=$row['prodPrecio']; ?> </td>
	<td> <?=$row['prodStock']; ?> </td>
	<td class="text-capitalize"> <?=$row['undCorto']; ?> </td>
	<td> <?=$row['gravDescripcion']; ?> </td>	
	<td> <button class="btn btn-sm btn-outline-primary border-0 btnAgregarProdCesta"><i class="icofont-rounded-down"></i></button> </td>
</tr>

<?php $i++; }
?>

</tbody>
</table>