<?php  
	if(!isset($_GET['id'])){
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
		<h3>EDITAR ORDEN: <?php echo $orden->id_sg?> </h3>
		<form method="POST" action="editar_ordenprocess.php">
			<table border=1>
				<tr>
					<td>MODELO DE AUTO: </td>
					<td><input type="text" name="modelo" placeholder="Modelo" value="<?php echo $orden->modelo_coche?>" required ></td>
				</tr>
				<tr>
					<td>PLACAS: </td>
					<td><input type="text" name="placas" placeholder="Placas" value="<?php echo $orden->placas_coche?>" required></td>
				</tr>
				<tr>
					<td>FALLAS: </td>
					<td><input type="text" name="fallas" placeholder="Fallas" value="<?php echo $orden->falla_coche?>" required></td>
				</tr>
				<tr>
					<td>OBSERVACIONES: </td>
					<td><input type="text" name="observaciones" placeholder="Observaciones" value="<?php echo $orden->observaciones_coche?>" required></td>
				</tr>
				<tr>
					<td>ESTADO DE LA ORDEN: </td>
					<td><input type="text" name="estado"  placeholder="Estado del coche" value="<?php echo $orden->estado_orden?>" required></td>
				</tr>  
                <tr>
					<td>INFORME: </td>
					<td><input type="text" name="informe" value="<?php echo $orden->informe_tecnico?>" required></td>
				</tr>
				<tr>
                        <label for="curso" class="form-label">ESTATUS: </label>
                        <select class="form-select" id="curso" name="estatus">
                            <option value=""><?php echo $orden->estatus?></option>
                            <option value="Recepción">Recepción</option>
                            <option value="En Espera">En espera</option> 
							<option value="En Proceso">En proceso</option> 
                            <option value="Finalizado">Finalizado</option> 
							<option value="Insumos">Insumos</option> 
                        </select>

				<tr>
					<input type="hidden" name="oculto">
					<input type="hidden" name="id2" value="<?php echo $orden->id_sg?>">
					<td colspan="2"><input type="submit" value="ACTUALIZAR CLIENTE" style="display: block; margin: 0 auto;"></td>
				</tr>
			</table>
		</form>
	</center>
</body>
</html>