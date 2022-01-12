<?php 
	if(!isset($_POST['oculto'])){
		header('Location: form_orden.php');
	}

	include 'config.php';

	$id2 = $_POST['id2'];
	$modelo = $_POST['modelo'];
	$placas = $_POST['placas'];
	$fallas = $_POST['fallas'];
	$observaciones = $_POST['observaciones'];
	$estado = $_POST['estado'];
    $informe = $_POST['informe'];
	$estatus = $_POST['estatus'];


	$consulta = $con->prepare("UPDATE orden_servicio SET modelo_coche= ?, placas_coche = ?, falla_coche = ?, 
								observaciones_coche = ?, estado_orden = ?, informe_tecnico = ?, estatus = ? WHERE id_sg = ?;");
	$orden = $consulta->execute([$modelo, $placas, $fallas, $observaciones, $estado, $informe, $estatus, $id2]);

	if ($orden === TRUE) {
			echo '<script type="text/javascript">
			alert("La orden SG ha sido modificada con exito.");
			window.location.href="../acceso_cas.php";
			</script>';
	}else{
		echo "Error";
	}
?>