<?php
if( !isset($_COOKIE['ckUsuario']) ){ 
	header("Location: index.html");
	die();
}else{
	if($_COOKIE['ckUsuario']!= 'cpariona'){
		header("Location: index.html");
	die();
	}
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<title>Facturador electrónico - Desarrollado por: Infocat Soluciones</title>
	<?php include 'headers.php'; ?>
	<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

</head>
<body>
<style>
	
</style>
<?php include 'menu-wrapper.php'; ?>
<div class="container" id="app">
	<h1>Enviar facturas</h1>
	<p>Todas las facturas que no han sido enviadas aún a SUNAT. </p>
	<div class="row">
		<button class="btn btn-outline-primary mb-3" @click="enviarComprobantes()"><i class="icofont-copy"></i> Generar comprobantes TXT</button>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>ID</th>
				<th>Fecha</th>
				<th>Comprobante</th>
				<th>Estado</th>
				<th><i class="icofont-plus"></i></th>
			</tr>
		</thead>
		<tbody>
			
				<tr v-for="(comprobante, index) in comprobantes">
					<td>{{index+1}}</td>
					<td>{{comprobante.idComprobante}}</td>
					<td>{{comprobante.fecha}}</td>
					<td>{{comprobante.factSerie}} {{comprobante.factCorrelativo}}</td>
					<td>{{comprobante.estado}}</td>
					<td><label @click="enlistar($event.target.checked, comprobante.idComprobante)"><input type="checkbox" id="cbox1" > </label></td>
				</tr>
				<?php
			
			?>
		</tbody>
	</table>	
</div>

<script>
	var app = new Vue({
  el: '#app',
  data: {
    comprobantes:[],
		seleccionados:[]
  },
	methods:{
		todaData(){
			axios.get('php/listarComprobantesRestantesSUNAT.php')
      .then(function (response) { console.log( response );
				app.comprobantes = response.data;
      })
      .catch(function (error) {
         console.log(error);
      });
		},
		enlistar( estado, idComprobante ){ //console.log( 'estado' + estado );
			if (estado){
				this.seleccionados.push(idComprobante)
			}else{
				/* console.log( 'borrando '+ idComprobante );
				console.log( this.seleccionados ); */
				const posicion = this.seleccionados.indexOf(idComprobante);
				//console.log( posicion );
				if(posicion >-1){
					this.seleccionados.splice(posicion, 1)
				}
			}
		},
		enviarComprobantes(){
			
			axios.post('php/crearArchivosFacturacion.php', {
				comprobantes: app.seleccionados
			})
			.then( function (response) {
				console.log( response.data );
			})
			.catch(function (error) {
				console.log( error );
			})
		}
		
	}
});
app.todaData()
</script>
</body>
</html>