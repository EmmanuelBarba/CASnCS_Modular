<?php
    // print_r($_GET);
    if(!isset($_GET['id'])){
      header('Location: acceso_cas.php');
	}

    $codigo = $_GET['id'];
    include 'config.php';
    $consulta = $con->prepare("DELETE FROM clientes WHERE id_clientes = ?;");
    $resultado = $consulta->execute([$codigo]);
    
    if ($resultado === TRUE) {
      echo '<script type="text/javascript">
            alert("El Cliente ha sido eliminado con exito.");
            window.location.href="../acceso_cas.php";
            </script>';

            // echo '<script type="text/javascript">
            // confirm("El Cliente a sido eliminado con exito.");
            // document.location.href="../acceso_cas.php";
            // </script>';

      // header("Location: ../index_cas.php");
	}else{
		echo "Error";
	}

?>