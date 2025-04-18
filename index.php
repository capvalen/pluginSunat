<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Facturador electrónico</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="shortcut icon" href="images/VirtualCorto.png" type="image/png">
</head>
<body>
<style>
#imagen {
	background-color: #eee;
	background: url(images/fondo.jpg);
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
	position: fixed; /* Sit on top of the page content */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 0; /* Specify a stack order in case you're using a different order for other elements */
	/* filter:blur(4px); */
}
.card{border-radius: .45rem;}
#overlay{
	position: fixed; /* Sit on top of the page content */
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #00000054; /* Black background with opacity */
  z-index: 0; /* Specify a stack order in case you're using a different order for other elements */
}
.card {
	border-radius: .45rem;
	color: white;
	border: 1px solid rgb(78 78 78);
	background-color: #0000008f;
}
.form-control{ background-color: transparent!important; height: calc(2.8rem + 2px); color:white!important; text-align: center; font-size: 1.5rem;}
.form-control:focus{border-color: #f0ff80;box-shadow: 0 0 0 0.2rem rgb(255 233 0 / 25%);}
.btn-outline-light:hover {
	color: #fbfdff;
	background-color: #4e2e5d;
	border-color: #995bd0;
}
button{height: calc(2.8rem + 2px);}
small{font-size: 68%;}
#messenger{
	width: 60px;
	height: 60px;
	/* background: url('');
	background-repeat: no-repeat;
	background-size: cover; */
	z-index: 3;
	position: absolute;
	bottom:40px;
	right: 40px;
}
#messenger img:hover{
	margin-top: -5px;
	cursor: pointer;
	-webkit-filter: drop-shadow(4px 5px 7px rgb(221, 221, 221));;
  filter: drop-shadow(4px 5px 7px rgb(221, 221, 221));;
}
</style>
<div id="imagen"></div>
<div id="overlay"></div>
<section class="p-md-5 m-md-5">
	<div class="container p-3 col-sm-4">
		<div class="card">
			<div class="card-body py-5">
				<center><img src="images/VirtualCorto.png" alt=""></center>
				<h4 class="card-title text-center" style="font-weight: 300;">Bienvenido al Facturador </h4>
				<label for="">Usuario:</label>
				<input type="text" class="form-control" id="txtNegocioLog" value="" autocomplete="nope">
				<label for="">Contraseña:</label>
				<input type="password" class="form-control" id="txtlocalLog" value="" autocomplete="nope">
				<button class="btn btn-outline-light mt-3 btn-block " id="btnAcceder"><i class="icofont-key-hole"></i> Acceder</button>
				<div class="mt-3" id="divError"><span id="spanError2"></span></div>
			
				<p class='mt-3 mb-0 text-right'><small>Versión <?= include "php/version.php"; ?></small></p>
			</div>
		</div> 
		
	</div>
</section>
<div id="messenger"><a href="https://m.me/infocatsoluciones" target="_blank"><img src="images/messenger.png" class="w-100"></a></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
	$('#txtNegocioLog').focus();
});
$('#txtNegocioLog').keyup(function (e) {
	if (e.which ==13){ $('#btnAcceder').click(); }
})
$('#txtlocalLog').keyup(function (e) {
	if (e.which ==13){ $('#btnAcceder').click(); }
})
$('#btnAcceder').click(function() {
	$.ajax({
		type:'POST',
		url: 'php/validarSesion.php',
		data: {user: $('#txtNegocioLog').val(), pws: $('#txtlocalLog').val()},
		success: function(resp) { console.log( "respuesta " + resp);
			//if (parseInt(iduser)>0){//console.log('el id es '+data)
			if( resp=='concedido' ){
				console.log(resp)
				window.location="facturador.php";
			}else if(resp=='inhabilitado'){
				$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Tu usuario fue inhabilitado temporalmente. No inista y llame a soporte informático.');
				$('#divError').removeClass('hidden');
				$('#txtUser_app').select();
				$('.fa-spin').addClass('sr-only');$('.icofont-ui-lock').removeClass('sr-only');
				$('#txtPassw').val(''); $('#txtPassw').focus();
				console.log('error en los datos')
			}else if( resp == 'nada' ){
				$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Sus datos usuario o contraseña están errados.');
				$('#divError').removeClass('hidden');
				//var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
				// $('#btnAcceder').addClass('animated wobble' ).one(animationEnd, function() {
				// 		$(this).removeClass('animated wobble');
				// });
				$('#txtUser_app').select();
				$('.fa-spin').addClass('sr-only');$('.icofont-ui-lock').removeClass('sr-only');
				//console.log(resp);
				$('#txtPassw').val(''); $('#txtPassw').focus();
				console.log('error en los datos')
			}else{
				$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Error interno del servidor');
				$('#divError').removeClass('hidden');
				$('#txtUser_app').select();
				$('.fa-spin').addClass('sr-only');$('.icofont-ui-lock').removeClass('sr-only');
				//console.log(resp);
				$('#txtPassw').val(''); $('#txtPassw').focus();
				console.log('error en los datos')
			}
		}
	});
});
</script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
	/* (function(){ var widget_id = 'ucFX66lIdV';var d=document;var w=window;function l(){
		var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
		s.src = '//code.jivosite.com/script/widget/'+widget_id
			; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
		if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
		else{w.addEventListener('load',l,false);}}})(); */
	</script>
	<!-- {/literal} END JIVOSITE CODE -->
</body>
</html>