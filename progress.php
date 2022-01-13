<?php

include 'config/config.php';

$id = $_GET['id'];
// $id_nom_client = $id;

$consulta = $con->prepare("SELECT * FROM orden_servicio where id_sg = ?;");
$consulta->execute([$id]);
$orden = $consulta->fetch(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Images/Logos/Engranes.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/CSS/slick.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- EN CASO DE PEDO BORRAR LA LINEA DE ABAJO -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<!-- MODAL DE FORMULARIO -->
	<link rel="stylesheet" href="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/CSS/modal.css">
	<link rel="stylesheet" href="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/CSS/jquery.modally.css">
	<!-- APLICACIÓN PARA LA FIRMA  -->
	<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
	<script src="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/JS/jspdf.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
	<!--  FIN APLICACIÓN PARA LA FIRMA  -->
	<title>C&CS</title>
</head>

<body>


	<!-- <h1>Our Process</h1><br>  -->
	<div class="positioner">
		<!-- SOCIAL  -->
		<div class="menu">
			<?php echo "<div class='menu-title'><p>ID SG: $id</p></div>"; ?>

			<a href="acceso_cas.php">
				<div class="menu-item" href="#Cliente_form" target="_modal:open">
					<input type="radio" class="toggle" name="menu_group" id="sneaky-toggle2">
					<div class="expander">
						<label for="sneaky_toggle2">
							<i class="fa fa-arrow-circle-left" href="#Cliente_form" target="_modal:open"></i>
							<span class="menu-text">Regresar</span>
						</label>
					</div>
				</div>
			</a>
		</div>
	</div>


	<br><br>
	<center>
		<div class="process-wrapper">

			<h2>PROGRESO DE LA ORDEN</h2>
			<div id="progress-bar-container">
				<ul>
					<li class="step step01 active">
						<div class="step-inner">INFORMACIÓN</div>
					</li>
					<li class="step step02">
						<div class="step-inner">RECEPCIÓN</div>
					</li>
					<li class="step step03">
						<div class="step-inner">EN ESPERA</div>
					</li>
					<li class="step step04">
						<div class="step-inner">EN PROCESO</div>
					</li>
					<li class="step step05">
						<div class="step-inner">FINALIZADO</div>
					</li>
				</ul>

				<div id="line">
					<div id="line-progress"></div>
				</div>
			</div>

			<div id="progress-content-section">
				<div class="section-content discovery active">
					<?php echo "<h2>$orden->modelo_coche</h2>" ?><br>
					<p>Esta orden de servicio ha sido registrada en la base de datos para dar seguimiento con la reparación o mantenimiento,
						con la información del registro en la recepción, Las órdenes de servicio se generan desde los módulos gestión de llamadas, Planificación de servicio y
						conceptos e Infor LN Proyecto. Aunque las órdenes de servicio también se pueden crear manualmente. Si es necesario,
						puede crear la orden de servicio a partir del portal, en esta sección debes preparar la autorización del mantenimiento o revisión.</p>
				</div>

				<div class="section-content strategy">
					<?php echo "<h2>$orden->modelo_coche</h2>" ?><br>
					<p>El vehiculo ha pasado por el registro principal del sistema y se encuentra a la espera de
						un mecánico para el proceso de revisión, las revisiones pueden demorar para realizarse segun la carga de trabajo
						de la empresa.
					</p>
				</div>

				<div class="section-content creative"><br>
					<?php echo "<h2>$orden->modelo_coche</h2>" ?><br>
					<p>En esta etapa aun no se tiene información del servicio, debido a que el vehiculo
						aún no ha sido revisado, hacer el chequeo de la orden pede ayudar a mejorar el estatus...(Aqui hacer la consulta del fallo del vehiculo).
					</p>
				</div>

				<div class="section-content production">
					<?php echo "<h2>$orden->modelo_coche</h2>" ?><br>
					<p>(Aqui consultar el estatus del proceso de la orden de servicio).</p>
				</div>

				<div class="section-content analysis">
					<?php echo "<h2>$orden->modelo_coche</h2>" ?><br>
					<p>(Aqui consultar el reporte final de la reparación).</p>
				</div>
			</div>

		</div>

	</center>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<!-- JAVASCRIPT -->

	<!-- <script src="assets/js/jquery-3.1.1.min.js"></script>    -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/JS/main.js"></script>
	<script type="text/javascript" src="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/JS/jquery.modally.js"></script>
	<script src="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/JS/slick.min.js"></script>

	<!-- DIALOGFLOW CHAT BETA -->

	<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
	<df-messenger intent="WELCOME" chat-title="C&CS" agent-id="9c7656be-7921-441f-b4c9-408a4646b170" chat-icon="https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Assets/Icons/chatbot.png" language-code="es"></df-messenger>

	<!-- FIN SCRIPT PARA EL CHATBOT -->
	<script>
		$(".step").click(function() {
			$(this).addClass("active").prevAll().addClass("active");
			$(this).nextAll().removeClass("active");
		});

		$(".step01").click(function() {
			$("#line-progress").css("width", "3%");
			$(".discovery").addClass("active").siblings().removeClass("active");
		});

		$(".step02").click(function() {
			$("#line-progress").css("width", "25%");
			$(".strategy").addClass("active").siblings().removeClass("active");
		});

		$(".step03").click(function() {
			$("#line-progress").css("width", "50%");
			$(".creative").addClass("active").siblings().removeClass("active");
		});

		$(".step04").click(function() {
			$("#line-progress").css("width", "75%");
			$(".production").addClass("active").siblings().removeClass("active");
		});

		$(".step05").click(function() {
			$("#line-progress").css("width", "100%");
			$(".analysis").addClass("active").siblings().removeClass("active");
		});
	</script>
</body>

</html>

<style>
	body {
		margin: 0;
		font-family: 'Roboto Condensed', sans-serif;
	}

	/* --- Start progress bar --- */

	.process-wrapper {
		margin: auto;
		max-width: 1080px;
		z-index: 0;
		position: inherit;
	}

	#progress-bar-container {
		position: relative;
		width: 90%;
		margin: auto;
		height: 100px;
		margin-top: 65px;
	}

	#progress-bar-container ul {
		padding: 0;
		margin: 0;
		padding-top: 23px;
		z-index: 9999;
		position: absolute;
		width: 100%;
		margin-top: -40px
	}

	#progress-bar-container li:before {
		content: " ";
		display: block;
		margin: auto;
		width: 30px;
		height: 30px;
		border-radius: 10px;
		border: solid 2px crimson;
		transition: all ease 0.3s;

	}

	#progress-bar-container li.active:before,
	#progress-bar-container li:hover:before {
		border: solid 2px crimson;

		background: linear-gradient(to right, crimson 0%, #5e0000 100%);
		border-radius: 10px;
	}

	#progress-bar-container li {
		list-style: none;
		float: left;
		width: 20%;
		text-align: center;
		color: crimson;
		text-transform: uppercase;
		font-size: 11px;
		cursor: pointer;
		font-weight: 700;
		transition: all ease 0.2s;
		vertical-align: bottom;
		height: 60px;
		position: relative;
	}

	#progress-bar-container li .step-inner {
		position: absolute;
		width: 100%;
		bottom: 0;
		font-size: 14px;
	}

	#progress-bar-container li.active,
	#progress-bar-container li:hover {
		color: #fff;
	}

	#progress-bar-container li:after {
		content: " ";
		display: block;
		width: 8px;
		height: 8px;
		background: crimson;
		margin: auto;
		border: solid 3px #5e0000;
		/*! border-radius:50%; */
		margin-top: 43px;
		box-shadow: 0 2px 13px -1px crimson;
		transition: all ease 0.2s;

		border-radius: 4px;
		/*! border-color: linear-gradient(to right, crimson 0%,#000000c9 100%); */
	}

	#progress-bar-container li:hover:after {
		background: #5e0000;
	}

	#progress-bar-container li.active:after {
		background: #5e0000;
	}

	#progress-bar-container #line {
		width: 80%;
		margin: auto;
		background: linear-gradient(to right, black 0%, #dc143c00 100%);
		height: 6px;
		position: absolute;
		left: 10%;
		top: 57px;
		z-index: 1;
		border-radius: 50px;
		transition: all ease 0.9s;
	}

	#progress-bar-container #line-progress {
		content: " ";
		width: 3%;
		height: 100%;
		/* background: #207893;	  */
		background: linear-gradient(to right, #5e0000 0%, crimson 100%);
		position: absolute;
		z-index: 2;
		border-radius: 50px;
		transition: all ease 0.9s;
	}

	#progress-content-section {
		width: 90%;
		margin: auto;
		background: #ffffff26;
		border-radius: 20px;
		box-shadow: 0 0 1.5rem rgb(233 233 233);
	}

	#progress-content-section .section-content {
		padding: 30px 40px;
		text-align: center;
	}

	#progress-content-section .section-content h2 {
		font-size: 25px;
		text-transform: uppercase;
		color: #fff;
		letter-spacing: 1px;
	}

	#progress-content-section .section-content p {
		font-weight: 600;
		text-shadow: 0.1em 0.1em 5.2em #ffffff96;
		font-size: 22px;
		line-height: 1.6em;
		color: #000000;
	}

	#progress-content-section .section-content {
		display: none;
		animation: FadeInUp 700ms ease 1;
		animation-fill-mode: forwards;
		transform: translateY(15px);
		opacity: 0;
	}

	#progress-content-section .section-content.active {
		display: block;
	}

	@keyframes FadeInUp {
		0% {
			transform: translateY(15px);
			opacity: 0;
		}

		100% {
			transform: translateY(0px);
			opacity: 1;
		}
	}
</style>

<style>
	body {
		overflow-y: hidden;
		background-color: crimson;
		background-image: linear-gradient(to top, rgba(32, 6, 6, 0.77) 0%, hsla(0, 0%, 0%, 0.36) 100%), url("https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Images/Fondos/img+(41).webp");
		background-size: cover;
		background-attachment: fixed;
		width: 100%;
		height: 100vh;
		/* filter: drop-shadow(3px 3px 3px #dc143c69); */
	}

	form {
		margin: 0 auto;
		width: 500px;
		background-color: #2d2d2d;
		padding: 10px;
		border-radius: 10px;
	}

	input,
	textarea {
		padding: 5px;
	}

	label {
		display: block;
		padding: 5px;
		color: #ffff;
	}

	.btn btn-primary mb-4 {
		margin-top: 20px;
	}

	button {
		width: 40%;
		margin-left: 30%;
		background-color: crimson;
		border-radius: 10px;
	}

	canvas {
		background-color: crimson;
		border-radius: 10px;
		opacity: 40%;
	}

	span {
		color: #ffff;
		margin-left: 35%;
	}

	h1 {
		margin-left: 30%;
		color: #ffff;
	}

	h3,
	h2 {
		margin: 0 auto;
		width: 500px;
		color: #ffff;
	}


	colgroup {
		color: crimson;
		color: #ffff;
		color: #969696;
		color: #2d2d2d;
		color: #0000;
	}
</style>

<!-- ESTILO MENÚ NAVIGATION  -->
<style>
	.menu {
		font-family: sans-serif;
		display: table;
		position: fixed;
		z-index: 1;
		right: 2.2px;
		box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
		/* padding: .5rem; */
		box-shadow: 0 0 0.5rem rgb(255 255 255);
		cursor: pointer;
	}

	.menu-title {
		color: white;
		font-size: 2rem;
		display: inline-flex;
		/* float: left; */
		line-height: 4rem;
		padding: 1;
		box-shadow: 0 0 0.5rem rgb(255 255 255);
		cursor: pointer;
	}

	.menu-title p {
		margin: 1px 0px 0px;
		padding: 5px;
	}

	label {
		display: inline-block;
		max-width: 100%;
		margin-top: 5px;
		font-weight: 600;
		cursor: pointer;
		color: crimson;
	}

	.menu:before {
		left: -0.50rem;
	}

	.menu:after {
		left: -0.50rem;
	}

	.menu-item {
		display: block;
		float: left;
		white-space: nowrap;
		color: crimson;
		font-size: 2rem;
		line-height: 1.5rem;
		/* font-size: 2rem; */
		box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
		font-family: 'Poppins', sans-serif;
		cursor: pointer;
	}

	.fa {
		display: inline-block;
		font: normal normal normal 29px/1 FontAwesome;
		font-size: 27px;
		text-rendering: auto;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		cursor: pointer;
		height: 4rem;
	}

	.menu-item .expander {
		max-width: 43px;
		overflow: hidden;
		transition: all cubic-bezier(0.46, 0.03, 0.52, 0.96) 340ms;
		padding-left: 5px;
		height: 5rem;
		cursor: pointer;
	}

	.menu-item:last-child {
		margin-right: 0;
	}

	.menu-item .toggle {
		display: none;
	}

	.menu-item .toggle:checked~.expander {
		max-width: 16rem;
		background: #222;
		cursor: pointer;
	}

	.menu-item .toggle:checked~.expander .menu-icon {
		color: white;
		animation: none;
	}

	.menu-item .toggle:checked~.expander .menu-text {
		color: white;
	}

	.menu-item .expander:hover {
		background: rgba(133, 133, 136, 0.637);
		padding-right: 13rem;
		height: 5rem;
	}

	.menu-item .expander:hover .menu-icon {
		color: white;
		animation: jiggle ease-in-out 400ms infinite;
	}

	.menu-item menu-icon {
		display: inline-block;
		font-size: 5rem;
		line-height: 3rem;
		vertical-align: middle;
		width: 4rem;
		text-align: center;
		margin-right: 0.5rem;
		transition: color ease-in-out 80ms;
		cursor: pointer;
	}

	.menu-item menu-text {
		line-height: 0rem;
		color: transparent;
		display: inline-block;
		vertical-align: middle;
		padding-right: 1.5rem;
		transition: color ease-in-out 333ms;
		box-shadow: 0 0 .5rem rgba(0, 0, 0, 0.42);
	}

	.positioner {
		display: table;
	}

	@keyframes jiggle {
		0% {
			transform: none;
		}

		25% {
			transform: rotateZ(5deg);
		}

		75% {
			transform: rotateZ(-5deg);
		}

		100% {
			transform: none;
		}

	}
</style>


<!-- STYLE PARA CHATBOT -->
<style>
	df-messenger {
		--df-messenger-bot-message: crimson;
		--df-messenger-button-titlebar-color: #2e2e2ebf;
		--df-messenger-chat-background-color: #2e2e2e;
		--df-messenger-font-color: rgb(255 255 255);
		--df-messenger-send-icon: #ff0000;
		--df-messenger-user-message: #5d5d5d;
		/*#420404*/
		--df-messenger-input-box-color: #2e2e2e;
		--df-messenger-input-font-color: #ffff;
	}

	button#widgetIcon .df-chat-icon {
		height: 50px;
		left: 1px;
		opacity: 1;
		position: absolute;
		top: 0px;
		transition: opacity 0.5s;
		width: 50px;
	}
</style>
<!-- STYLE PARA CHATBOT -->