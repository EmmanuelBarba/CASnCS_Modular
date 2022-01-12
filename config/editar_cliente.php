<?php 
	// if(!isset($_POST['oculto'])){
	// 	header('Location: form_clientes.php');
	// }

	include 'config.php';

	$id2 = $_POST['id2'];
	$nombre = $_POST['nombre'];
	$domicilio = $_POST['domicilio'];
	$correo = $_POST['correo'];
	$telefono = $_POST['telefono'];
	// $fecha = $_POST['fecha'];
    // $contra = $_POST['contra'];


	$consulta = $con->prepare("UPDATE clientes SET nombre_cliente= ?, domicilio_cliente = ?, correo_cliente = ?, 
												tel_cliente = ? WHERE id_clientes = ?;");
	$clientes = $consulta->execute([$nombre, $domicilio, $correo, $telefono, $id2]);

	if ($clientes === TRUE) {
			echo '<script type="text/javascript">
			alert("El cliente ha sido modificado con exito.");
			window.location.href="../acceso_cas.php";
			</script>';
	}else{
		echo "Error";
	}
?>