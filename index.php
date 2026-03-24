<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Facturador electrónico</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="icofont.min.css">
	<link rel="shortcut icon" href="images/VirtualCorto.png" type="image/png">

	<style>
		body,
		html {
			height: 100%;
			margin: 0;
		}

		#imagen {
			background: url('images/fondo.webp') center center / cover no-repeat;
			position: fixed;
			top:0;
			left:0;
			width: 100%;
			height: 100%;
			z-index: -1;
		}

		#overlay {
			position: fixed;
			width: 100%;
			height: 100%;
			background: #00000054;
			z-index: -1;
		}

		.main-container {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.card {
			border-radius: .45rem;
			color: white;
			border: 1px solid rgb(78 78 78);
			background-color: #0000008f;
		}

		.form-control {
			background-color: transparent !important;
			height: calc(2.8rem + 2px);
			color: white !important;
			text-align: center;
			font-size: 1.3rem;
		}

		.form-control:focus {
			border-color: #f0ff80;
			box-shadow: 0 0 0 .2rem rgb(255 233 0 / 25%);
		}

		.btn-outline-light:hover {
			color: #fbfdff;
			background-color: #4e2e5d;
			border-color: #995bd0;
		}

		#messenger {
			width: 60px;
			height: 60px;
			position: fixed;
			bottom: 20px;
			right: 20px;
			z-index: 5;
		}
		#whatsapp {
			width: 60px;
			height: 60px;
			position: fixed;
			bottom: 90px;
			right: 20px;
			z-index: 5;
		}

		#messenger img:hover, #whatsapp img:hover {
			margin-top: -5px;
			cursor: pointer;
			filter: drop-shadow(4px 5px 7px rgb(221, 221, 221));
		}

		.logo {
			max-width: 120px;
			margin-bottom: 15px;
		}

		@media (max-width:576px) {

			.card-body {
				padding: 2rem 1.5rem;
			}

			.form-control {
				font-size: 1.1rem;
			}

		}
	</style>
</head>

<body>

	<div id="imagen"></div>
	<div id="overlay"></div>

	<div class="main-container">

		<div class="container">
			<div class="row justify-content-center">

				<div class="col-lg-6 col-md-6 col-sm-8 col-12">

					<div class="card">
						<div class="card-body text-center py-4">

							<img src="images/VirtualCorto.png" class="logo">

							<h4 class="mb-4" style="font-weight:300;">Facturador Electrónico</h4>

							<label>Usuario</label>
							<input type="text" class="form-control" id="txtNegocioLog">

							<label class="mt-3">Contraseña</label>
							<input type="password" class="form-control" id="txtlocalLog">

							<button class="btn btn-outline-light mt-4 btn-block" id="btnAcceder">
								<i class="icofont-key-hole"></i> Acceder
							</button>

							<div class="mt-3" id="divError">
								<span id="spanError2"></span>
							</div>

							<p class="mt-3 mb-0 text-right">
								<small><?= include "php/version.php"; ?></small>
							</p>

						</div>
					</div>

				</div>
			</div>
		</div>

	</div>

	<div id="messenger">
		<a href="https://m.me/infocatsoluciones" target="_blank">
			<img src="images/messenger.png" class="w-100">
		</a>
	</div>
	<div id="whatsapp">
		<a href="https://wa.me/51977692108?text=Hola%20requiero%ayuda%20con%20el%20facturador" target="_blank">
			<img src="images/whatsapp.png" class="w-100">
		</a>
	</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
	$(document).ready(function() {
		$('#txtNegocioLog').focus();
	});
	$('#txtNegocioLog').keyup(function(e) {
		if (e.which == 13) {
			$('#btnAcceder').click();
		}
	})
	$('#txtlocalLog').keyup(function(e) {
		if (e.which == 13) {
			$('#btnAcceder').click();
		}
	})
	$('#btnAcceder').click(function() {
		$.ajax({
			type: 'POST',
			url: 'php/validarSesion.php',
			data: {
				user: $('#txtNegocioLog').val(),
				pws: $('#txtlocalLog').val()
			},
			success: function(resp) {
				console.log("respuesta " + resp);
				//if (parseInt(iduser)>0){//console.log('el id es '+data)
				if (resp == 'concedido') {
					console.log(resp)
					window.location = "facturador.php";
				} else if (resp == 'inhabilitado') {
					$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Tu usuario fue inhabilitado temporalmente. No inista y llame a soporte informático.');
					$('#divError').removeClass('hidden');
					$('#txtUser_app').select();
					$('.fa-spin').addClass('sr-only');
					$('.icofont-ui-lock').removeClass('sr-only');
					$('#txtPassw').val('');
					$('#txtPassw').focus();
					console.log('error en los datos')
				} else if (resp == 'nada') {
					$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Sus datos usuario o contraseña están errados.');
					$('#divError').removeClass('hidden');
					//var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
					// $('#btnAcceder').addClass('animated wobble' ).one(animationEnd, function() {
					// 		$(this).removeClass('animated wobble');
					// });
					$('#txtUser_app').select();
					$('.fa-spin').addClass('sr-only');
					$('.icofont-ui-lock').removeClass('sr-only');
					//console.log(resp);
					$('#txtPassw').val('');
					$('#txtPassw').focus();
					console.log('error en los datos')
				} else {
					$('#spanError2').html('<i class="icofont-cat-alt-3"></i> Error interno del servidor');
					$('#divError').removeClass('hidden');
					$('#txtUser_app').select();
					$('.fa-spin').addClass('sr-only');
					$('.icofont-ui-lock').removeClass('sr-only');
					//console.log(resp);
					$('#txtPassw').val('');
					$('#txtPassw').focus();
					console.log('error en los datos')
				}
			}
		});
	});
</script>

</html>