<?php
    //print_r($_GET);
    if(!isset($_GET['id'])){
		exit();
	}

    $codigo = $_GET['id'];
    include 'config.php';
    $consulta = $con->prepare("DELETE FROM orden_servicio WHERE id_sg = ?;");
    $resultado = $consulta->execute([$codigo]);
    
    if ($resultado === TRUE) {
      echo '<script type="text/javascript">
      alert("La orden SG ha sido eliminada con exito.");
      window.location.href="../acceso_cas.php";
      </script>';
	}else{
		echo "Error";
	}

?>