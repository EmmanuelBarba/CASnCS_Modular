<?php 

    include 'config.php';

    if(!$conexion){
		header('location: 404.php');
		}

		//revisa las sesiones
		if(isset($_SESSION['acceso'])){
			if($_SESSION['permisos']=="admin"){
				$name=($_SESSION['acceso']);
			}else{
				$name=($_SESSION['acceso']);
			}
			
		}else{
			header('Location: index_cas.php');
	}

    $sql_4 = $con->prepare("SELECT id_taller FROM admin_taller where nombre_taller = '$name'");
	$sql_4->setFetchMode(PDO::FETCH_ASSOC);
	$sql_4 -> execute(); 
	$data = array();
	$i = 0;
	while($id = $sql_4->fetch()){
		$id_taller = implode ("", $id);
	}

    $consulta = $con->query("SELECT * FROM orden_servicio where taller_hasordenes = '$id_taller'");
	$orden = $consulta->fetchAll(PDO::FETCH_OBJ);

?>
