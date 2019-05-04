<?php
date_default_timezone_set('America/Lima');
include "conexion.php";

$sql="SELECT p.*, case `prodActivo` when 1 then 'Activo' else 'Inactivo'end as estActivo, g.gravDescripcion  FROM `productos` p
inner join gravados g on p.idGravado = g.idGravado;"; // WHERE `prodActivo`=1

$resultado=$cadena->query($sql);
$numero = $resultado ->num_rows;
if($numero==0){ ?>
<tr>
	<td colspan="6">No existen productos.</td>
</tr>
<?php }
$i=1;
while($row=$resultado->fetch_assoc()){ 
	?>
	<tr>
					<td class='text-center'><?= $i; ?></td>
					<td class='text-capitalize tdProdNombre'><?= $row['prodDescripcion'];?></td>
					<td class='text-center'>S/ <?= number_format($row['prodPrecio'],2); ?></td>
					<td class='text-center'>S/ <?= number_format($row['prodPrecio'],2); ?></td>
					<td class='text-center'>S/ <?= number_format($row['prodPrecio'],2); ?></td>
					<td><?= $row['prodStock'];?> Unds.</td>
					<td class="tdGrabado" data-value="<?= $row['idGravado'];?>"><?= $row['gravDescripcion']; ?></td>
					<td><?= $row['estActivo']; ?></td>
					<td>
						<button class="btn btn-outline-primary btn-sm border border-light btnEditProducto" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar Producto"><i class="icofont-flag"></i></button>
						<button class="btn btn-outline-success btn-sm border border-light btnPreciosProducto" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cambiar Precio"><i class="icofont-list"></i></button>
						<button class="btn btn-outline-dark btn-sm border border-light btnStockProducto" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modificar Stock"><i class="icofont-magic"></i></button>
					</td>
				</tr>
	<tr>
<?php  $i++; }

?>