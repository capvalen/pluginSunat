<?php
include "conexion.php";
$sql="SELECT `idProductos`, `prodDescripcion`, p.`idUnidad`, `prodPrecio`, `prodActivo`, u.undDescipcion
FROM `productos` p inner join unidades u on u.idUnidad = p.idUnidad 
WHERE `prodActivo`=1";
$resultado=$cadena->query($sql);

$sqlUnd="SELECT `idUnidad`, `undDescipcion`, `undSunat`, `undCorto` FROM `unidades` WHERE undActivo =1;";
$resultadoUnd=$esclavo->query($sqlUnd);

?>

<div class="row mb-1 cardHijoProducto" data-producto="1">

	<div class="col-5 divNombProducto">
		<select class="selectpicker sltFiltroProductos" data-live-search="true" title="&#xed12; Productos" data-width="100%">
		<?php 
		while($row=$resultado->fetch_assoc()){ ?>
		<option value="<?= $row['idProductos'];?>"><?= $row['prodDescripcion'];?></option>
	
		<?php 
		}		
		?>
		</select>
	</div>
	<div class="col-1 p-0"><input type="number" class="form-control text-center esMoneda campoCantidad" value="0" step="0.5" min="0"></div>
	<div class="col-2 divUnidadProducto">
		<select class="selectpicker sltFiltroUnidad" data-live-search="true" title="&#xed12; Unds." data-width="100%">
			<?php 
			while($rowUnd=$resultadoUnd->fetch_assoc()){  ?>
			<option value="<?= $rowUnd['undSunat'];?>" data-unidad="<?= $rowUnd['undCorto']?>"><?= $rowUnd['undDescipcion'];?></option>
		
			<?php 
			}		
			?>
			</select>
	</div>
	<div class="col-2"><input type="number" class="form-control esMoneda campoPrecioUnit" id="txtPrecioPetroleo" step='0.1' min="0" value="0.00"></div>
	<div class="col-2"><input type="number" class="form-control text-center esMoneda campoSubTotal" id="txtCampoPrecioPetroleo" value="0.00"></div>
</div>