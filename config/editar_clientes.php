<?php
// include 'form_clientes.php';
// if(!isset($_GET['id'])){
// 	header('Location: form_clientes.php');
// }

include 'config.php';


$id = $_GET['id'];

$consulta = $con->prepare("SELECT * FROM clientes where id_clientes = ?;");
$consulta->execute([$id]);
$cliente = $consulta->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>


<body>
	<center>
		<h3>EDITAR CLIENTE: <?php echo $cliente->nombre_cliente ?> con el ID: <?php echo $cliente->id_clientes ?> </h3>
		<form method="POST" action="editar_cliente.php">
			<table border="1">
				<tr>
					<td>NOMBRE: </td>
					<td><input type="text" name="nombre" placeholder="Nombre Cliente" value="<?php echo $cliente->nombre_cliente ?>" required></td>
				</tr>
				<tr>
					<td>DOMICILIO: </td>
					<td><input type="text" name="domicilio" placeholder="Domicilio" value="<?php echo $cliente->domicilio_cliente ?>" required></td>
				</tr>
				<tr>
					<td>CORREO: </td>
					<td><input type="text" name="correo" placeholder="Correo" value="<?php echo $cliente->correo_cliente ?>" required></td>
				</tr>
				<tr>
					<td>TELEFONO: </td>
					<td><input type="tel" name="telefono" placeholder="Telefono" value="<?php echo $cliente->tel_cliente ?>" required></td>
				</tr>
				<!-- <tr> -->
				<!-- <td>FECHA: </td> -->
				<!-- <td><input type="datetime" name="fecha" placeholder="Usuario"value=" -->
				<?php //echo $cliente->date_cliente
				?>
				<!-- " required></td> -->
				<!-- </tr>  -->
				<!-- <tr> -->
				<!-- <td>CONTRASEÑA: </td> -->
				<!-- <td><input type="text" name="contra" 	placeholder="Contraseña" value="<?php //echo $cliente->pass_client
																								?>" required></td> -->
				<!-- </tr> -->
				<tr>
					<input type="hidden" name="oculto">
					<input type="hidden" name="id2" value="<?php echo $cliente->id_clientes ?>">
					<!-- <td><input type="reset" value="Limpiar"></td> -->
					<td colspan="2"><input type="submit" value="ACTUALIZAR CLIENTE" style="display: block; margin: 0 auto"></td>
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