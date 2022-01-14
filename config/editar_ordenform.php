<?php
if (!isset($_GET['id'])) {
	header('Location: form_orden.php');
}

include 'config.php';
$id = $_GET['id'];
// $id_nom_client = $id;

$consulta = $con->prepare("SELECT * FROM orden_servicio where id_sg = ?;");
$consulta->execute([$id]);
$orden = $consulta->fetch(PDO::FETCH_OBJ);

?>


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


<div class="positioner">
	<!-- SOCIAL  -->
	<div class="menu">
		<?php echo "<div class='menu-title'><p>ID SG: $id</p></div>"; ?>

		<a href="../acceso_cas.php">
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
</div><br><br><br><br>
<center>
	<form class="formulario" method="POST" action="editar_ordenprocess.php">
		<!-- class="form-control" -->
		<h3>EDITAR ORDEN: <?php echo $orden->id_sg ?> </h3>
		<div>
			<label class="form-label">Modelo auto:</label>
			<input class="form-control" type="text" name="modelo" placeholder="Modelo" value="<?php echo $orden->modelo_coche ?>" required>
		</div>

		<div>
			<label class="form-label">Placas:</label>
			<input class="form-control" type="text" name="placas" placeholder="Placas" value="<?php echo $orden->placas_coche ?>" required>
		</div>

		<div>
			<label class="form-label">Fallas:</label>
			<input class="form-control" type="text" name="fallas" placeholder="Fallas" value="<?php echo $orden->falla_coche ?>" required>
		</div>

		<div>
			<label class="form-label">Observaciones:</label>
			<input class="form-control" type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $orden->observaciones_coche ?>" required>
		</div>

		<div>
			<label for="estado" class="form-label">Estado de la orden:</label>
			<textarea class="form-control" name="estado" id="estado" placeholder="<?php echo $orden->estado_orden ?>" required></textarea>
		</div>

		<div>
			<label for="Informe" class="form-label">Informe técnico (final):</label>
			<textarea class="form-control" name="informe" id="informe" placeholder="<?php echo $orden->informe_tecnico ?>" required></textarea>
		</div>

		<label for="curso" class="form-label">ESTATUS: </label>
		<select class="form-select" id="curso" name="estatus">
			<option value=""><?php echo $orden->estatus ?></option>
			<option value="Recepción">Recepción</option>
			<option value="En Espera">En espera</option>
			<option value="En Proceso">En proceso</option>
			<option value="Finalizado">Finalizado</option>
			<option value="Insumos">Insumos</option>
		</select>

		<input type="hidden" name="oculto">
		<input type="hidden" name="id2" value="<?php echo $orden->id_sg ?>">
		<td colspan="2"><input type="submit" value="ACTUALIZAR SG" style="display: block; margin: 0 auto;"></td>

	</form>
</center>
</div>
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
		overflow-y: scroll;
		/* overflow-y: hidden; */
		background-color: crimson;
		background-image: linear-gradient(to top, rgba(0, 0, 0, 0.77) 30%, hsla(0, 100%, 47.1%, 0.36) 50%), url("https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Images/Fondos/img+(9).webp");
		background-size: cover;
		background-attachment: fixed;
		width: 100%;
		height: 100vh;
		/* filter: drop-shadow(3px 3px 3px #dc143c69); */
	}

	form {
		margin: 0 auto;
		width: 550px;
		background-color: #2d2d2d;
		padding: 35px;
		border-radius: 10px;
	}

	input,
	textarea {
		padding: px;
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

<!-- CSS para el formulario de login/registro  -->

<style>
	.contenedor-form {
		background-color: rgba(255, 255, 255, 0.5);
		max-width: 500px;
		border-radius: 10px;
		color: #fff;
		background-attachment: fixed;
		position: relative;
	}

	.contenedor-form .toggle {
		position: absolute;
		top: 7px;
		right: 7px;
		width: 100px;
		height: 30px;
		font-size: 12px;
		line-height: 25px;
		text-align: center;
		border-top: 2px solid #fff;
		border-bottom: 2px solid #fff;
		cursor: pointer;
		transition: all .5s ease;
	}

	.contenedor-form .toggle:hover {
		border-top: 2px solid crimson;
		border-bottom: 2px solid crimson;
	}

	.contenedor-form .toggle span {
		letter-spacing: 1px;
	}

	.contenedor-form h2 {
		margin: 0 0 28px 0;
		font-size: 20px;
		font-weight: 400;
		line-height: 1;
	}

	.contenedor-form input[type="text"],
	.contenedor-form input[type="password"],
	.contenedor-form input[type="email"] {
		outline: none;
		display: block;
		width: 100%;
		padding: 9px 16px;
		margin: -20px 100px 26px 0;
		background: rgba(0, 0, 0, .5);
		border: none;
		border-bottom-color: currentcolor;
		border-bottom-style: none;
		border-bottom-width: medium;
		border-radius: 7px;
		border-bottom: 3px solid #ffffff;
		box-sizing: border-box;
		font-size: 18px;
		transition: all .5s ease;
		font-family: 'Poppins', sans-serif;
	}

	.contenedor-form input[type="text"]:focus,
	.contenedor-form input[type="password"]:focus,
	.contenedor-form input[type="email"]:focus {
		border-bottom: 3px solid crimson;
	}

	.contenedor-form input[type="submit"] {
		background: #3a3a3aab;
		color: #FFF;
		width: 43%;
		padding: 5px 0;
		border: none;
		border-radius: 7px;
		border-bottom: 3px solid rgb(255 255 255);
		font-size: 18px;
		font-weight: normal;
		font-family: Roboto;
		letter-spacing: 1px;
		cursor: pointer;
		transition: all .5s ease;
		font-family: 'Poppins', sans-serif;
		transform: translate(65%, -10px);
	}

	.contenedor-form input[type="submit"]:hover {
		background: crimson;
	}

	.contenedor-form .reset-password {
		background: rgba(0, 0, 0, .5);
		width: 100%;
		padding: 9px 0;
		text-align: center;
		border-radius: 5px;
		transform: translateY(13px);
	}

	.contenedor-form .reset-password:hover {
		background: crimson;
	}

	.contenedor-form .reset-password a {
		color: #fff;
		text-decoration: none;
		font-size: 16px;
	}

	.contenedor-form .formulario {
		display: none;
		padding: 40px;
	}

	.contenedor-form .formulario:nth-child(2) {
		display: block;
	}
</style>

<!-- ESTILO PARA LAS TABLAS Y VENTANAS -->

<STYLE>
	.contenedor-form-tabla {
		max-width: auto;
		border-radius: 10px;
		color: #fff;
	}

	.contenedor-form-tabla .btn_buscar {
		color: #fff;
		border: solid 1px #ffffff;
		background-color: #2c2c2c;
		transition: all 0.3s;
		display: block;
		position: absolute;
		right: 300px;
	}

	.registro .toggle {
		position: absolute;
		top: 12px;
		width: 141px;
		height: 30px;
		line-height: 25px;
		text-align: center;
		border-top: 2px solid #fff;
		border-bottom: 2px solid #fff;
		cursor: pointer;
		transition: all .5s ease;
	}

	.registro .toggle:hover {
		border-top: 2px solid crimson;
		border-bottom: 2px solid crimson;
	}

	.registro .toggle a {
		letter-spacing: 1px;
		color: #fff;
		text-decoration: none;
	}

	.registro .title_cliente {
		position: absolute;
		top: 9px;
		margin: 0 300px 0;
	}

	.buscar {
		position: absolute;
		width: 35%;
		margin: 0 auto;
		left: 23%;
	}
</STYLE>

<!-- FIN ESTILO PARA LAS TABLAS Y VENTANAS -->

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