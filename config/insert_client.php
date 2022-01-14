<?php

require_once 'config/functions.php';
// require_once 'config/login.php';
$conexion = connect($server,$db,$user,$pass);
if(!$conexion){
header('location: 404.php');
}

session_start();//crea sesion

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

$state = $conexion->prepare("SELECT id,title,intro,image FROM ".$name."");//se genera la busqueda
$state ->execute();

// $result = $state->fetchAll();

if(isset($_POST['enviar'])){//revisar nombre del boton

    //queremos saber si existe
    $taller = $name;
    $validar = $conexion->prepare("SELECT id_taller, nombre taller FROM admin_taller WHERE  nombre_taller= .$taller. LIMIT 1;");
    $validar->execute([$taller]);
    // //Ver cuántas filas devuelve
    $filas = $validar->rowCount();
  

    if ($filas <= 0) {

        $sql = $conexion->prepare("SELECT id_taller FROM admin_taller where nombre_taller = '$name'");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql -> execute(); 
        $data = array();
        $i = 0;
        while($id = $sql->fetch()){
            // echo $id["id_taller"];
            $id_taller = implode ("", $id);
            // echo $id_taller;
        }

        $passHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
        $insert = $conexion->prepare("INSERT INTO clientes (nombre_cliente, domicilio_cliente, correo_cliente, tel_cliente, pass_client, 
        taller_hasclient, type) 
        VALUES (:nombre_cliente, :domicilio_cliente, :correo_cliente, :tel_cliente, :pass_client, :taller_hasclient, :type)");//registro de datos
        $insert->execute(array(
            ':nombre_cliente' => $_POST['nombre_cliente'],
            ':domicilio_cliente' =>$_POST['domicilio_cliente'],
            ':correo_cliente' => $_POST['correo_cliente'],
            ':tel_cliente' => $_POST['tel_cliente'],
            ':pass_client' => $passHash,
            ':taller_hasclient' => $id_taller,
            ':type' => "user"
        ));
        echo '<script type="text/javascript">
                alert("Los datos fuerón guardados con exito.");
                window.location.href="acceso_cas.php";
            </script>';
    } else {
        // $error = "";
        echo "<b><h3>Conexion no exitosa</h3></b>";
    }
}
