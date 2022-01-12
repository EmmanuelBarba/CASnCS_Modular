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
	
	$id_taller = $name;
	$sql_3 = $con->prepare("SELECT id_taller FROM admin_taller where nombre_taller = '$name'");
	$sql_3->setFetchMode(PDO::FETCH_ASSOC);
	$sql_3 -> execute(); 
	$data = array();
	$i = 0;
	while($id = $sql_3->fetch()){
		$id_taller = implode ("", $id);
	}
	$consulta = $con->query("SELECT * FROM clientes where taller_hasclient = '$id_taller'");
	$clientes = $consulta->fetchAll(PDO::FETCH_OBJ);
