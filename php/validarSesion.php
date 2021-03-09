<?php 
// ini_set("session.cookie_lifetime","7200");
// ini_set("session.gc_maxlifetime","7200");
//session_start();
//header('Content-Type: text/html; charset=utf8');
include 'conexion.php';
$clavePrivada= 'Es sencillo hacer que las cosas sean complicadas, pero difícil hacer que sean sencillas. Friedrich Nietzsche';
$local='/';
$log = mysqli_query($cadena,"select * from  usuario u  where usuNick = '".$_POST['user']."' and usuPass='".md5($_POST['pws'])."';");
//echo "select * from  usuario u  where usuNick = '".$_POST['user']."' and usuPass='".md5($_POST['pws'])."';";
$row = mysqli_fetch_array($log, MYSQLI_ASSOC);
$expira=time()+60*60*3; //cookie para 3 horas
if ($row['idUsuario']>=1){
	// $_SESSION['idSucursal']=$row['idSucursal'];
	// $_SESSION['Sucursal']=$row['sucLugar'];
	// $_SESSION['Atiende']=$row['usuNombres'];
	// $_SESSION['nomCompleto']=$row['usuNombres'].', '.$row['usuApellido'];
	// $_SESSION['Power']=$row['usuPoder'];
	// $_SESSION['idUsuario']=$row['idUsuario'];
	// $_SESSION['oficina']=$_POST['offi'];
	if( $row['usuActivo']=='1' ){
		
		setcookie('ckAtiende', $row['usuNombres'], $expira, $local);
		setcookie('cknomCompleto', $row['usuNombres'].', '.$row['usuApellido'], $expira, $local);
		setcookie('ckPower', $row['usuPoder'], $expira, $local);
		setcookie('ckidUsuario', $row['idUsuario'], $expira, $local);
		setcookie('ckUsuario', $row['usuNick'], $expira, $local);
		
	

		$sqlConf = "SELECT `idConf`, `confVariable`, `confValor` FROM `configuracion` where 1;";
		$resultadoConf=$esclavo->query($sqlConf);
		while($rowConf=$resultadoConf->fetch_assoc()){ 
			setcookie($rowConf['confVariable'], $rowConf['confValor'], $expira, $local);
		}


		echo 'concedido';
	}else{
		echo 'inhabilitado';
	}
	
	//echo $row['idUsuario'];
	
}else{
	echo 'nada';
}




/* liberar la serie de resultados */
mysqli_free_result($log);
/* cerrar la conexión */
mysqli_close($cadena);
?>