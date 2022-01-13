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


<!DOCTYPE html>
<html>

<head>
	<title>Editar Orden</title>
	<meta charset="utf-8">
</head>

<body>
	<center>
		<h3>EDITAR ORDEN: <?php echo $orden->id_sg ?> </h3>
		<form method="POST" action="editar_ordenprocess.php">
			<table border=1>
				<tr>
					<td>MODELO DE AUTO: </td>
					<td><input type="text" name="modelo" placeholder="Modelo" value="<?php echo $orden->modelo_coche ?>" required></td>
				</tr>
				<tr>
					<td>PLACAS: </td>
					<td><input type="text" name="placas" placeholder="Placas" value="<?php echo $orden->placas_coche ?>" required></td>
				</tr>
				<tr>
					<td>FALLAS: </td>
					<td><input type="text" name="fallas" placeholder="Fallas" value="<?php echo $orden->falla_coche ?>" required></td>
				</tr>
				<tr>
					<td>OBSERVACIONES: </td>
					<td><input type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $orden->observaciones_coche ?>" required></td>
				</tr>
				<tr>
					<td>ESTADO DE LA ORDEN: </td>
					<td><input type="text" name="estado" placeholder="Estado del coche" value="<?php echo $orden->estado_orden ?>" required></td>
				</tr>
				<tr>
					<td>INFORME: </td>
					<td><input type="text" name="informe" value="<?php echo $orden->informe_tecnico ?>" required></td>
				</tr>
				<tr>
					<label for="curso" class="form-label">ESTATUS: </label>
					<select class="form-select" id="curso" name="estatus">
						<option value=""><?php echo $orden->estatus ?></option>
						<option value="Recepción">Recepción</option>
						<option value="En Espera">En espera</option>
						<option value="En Proceso">En proceso</option>
						<option value="Finalizado">Finalizado</option>
						<option value="Insumos">Insumos</option>
					</select>

				<tr>
					<input type="hidden" name="oculto">
					<input type="hidden" name="id2" value="<?php echo $orden->id_sg ?>">
					<td colspan="2"><input type="submit" value="ACTUALIZAR CLIENTE" style="display: block; margin: 0 auto;"></td>
				</tr>
			</table>
		</form>
	</center>
</body>

</html>


<style>
	body {
		background-color: crimson;
		background-image: linear-gradient(to top, rgba(32, 6, 6, 0.77) 0%, hsla(0, 0%, 0%, 0.36) 100%), url("https://mod2021cas.s3.us-west-1.amazonaws.com/C%26CS/Images/Fondos/img+(27).webp");
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