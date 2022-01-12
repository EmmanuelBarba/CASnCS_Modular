<?php

require_once 'config/functions.php';

$conexion = connect($server,$db,$user,$pass);
if(!$conexion){
    header('Location: config/404.php');
}
session_start();//se crea la sesion

if(isset($_SESSION['acceso'])){
    header('Location: acceso_cas.php');
}
//se verifica si existe el envio de datos. Inicio de sesion
if(isset($_POST['login'])){
    $user = ($_POST['name']);
    $state = $conexion->prepare("SELECT nombre_taller, pass_taller, type FROM admin_taller WHERE nombre_taller = :user");
    // $state = $conexion->prepare("SELECT name, pass, type FROM users WHERE name = :user");//busqueda preparada
    $state->bindValue(':user', $user);//se utiliza la variable de usuario en la validacion
    $state->execute();//se ejecuta la busqueda

    $result = $state->fetch(PDO::FETCH_ASSOC);

    if($result === false){
        $error2="";
    }else{
        if(password_verify($_POST['pass'], $result['pass_taller'])) {
            $_SESSION['acceso'] = $result['nombre_taller'];//se asigna en nombre
            $_SESSION['permisos'] = $result['type'];//se asigna el permiso
            header('Location: acceso_cas.php');
           }else{
            $error2="";
            echo '<script type="text/javascript">
            alert("Usuario o contraseña incorrectos, por favor intente de nuevo.");
            window.location.href="index_cas.php";
            </script>';
        }
    }

}

if(isset($_SESSION['acceso'])){
    if($_SESSION['permisos']=="admin"){
        $name="admin";
    }else{
        $name=($_SESSION['acceso']);
    }
    
}else{
    $name="Guess";
}

//Se verifica si existe el envio de datos. Registro
if(isset($_POST['reg'])){
    $name = $_POST["name"];//variable con el nombre de usuario
    $pass = $_POST["pass"];//variable con la contraseña
    $telefono  = $_POST["telefono"];
    $email = $_POST["email"];
    $domicilio = $_POST["domicilio"];
    
    //queremos saber si existe
    $validar = $conexion->prepare("SELECT nombre_taller FROM admin_taller WHERE  nombre_taller = '$name'");
    $validar->execute([$name]);
    //Ver cuántas filas devuelve
    $filas = $validar->rowCount();

    //Si son 0 o menos, significa que no existe
    if ($filas <= 0) {
        $passHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
        $insert = $conexion->prepare("INSERT INTO admin_taller (nombre_taller, tel_taller, mail_taller, domicilio_taller, pass_taller,
         type) VALUES (:name, :telefono, :email, :domicilio, :pass, :type)");//registro de datos
        $insert->execute(array(
            ':name' => $_POST['name'],
            ':pass' => $passHash,
            ':email' => $_POST['email'],
            ':telefono' => $_POST['telefono'],
            ':domicilio' => $_POST['domicilio'],
            ':type' => "admin"
        ));
        //  $state->bindParam(':nombre_taller', $name, PDO::PARAM_STR);
        //  $state->bindParam(':tel_taller', $telefono, PDO::PARAM_STR);
        //  $state->bindParam(':mail_taller', $email, PDO::PARAM_STR);
        //  $state->bindParam(':pass_taller', $passHash, PDO::PARAM_STR);
        //  $state->bindParam(':domicilio_taller', $domicilio, PDO::PARAM_STR);
        //  $state->execute();

        $insert = $conexion->prepare("INSERT INTO users (name, email, pass, type) VALUES (:name, :email, :pass, :type)");//registro de datos
        $insert->execute(array(
            ':name' => $_POST['name'],
            ':email' => $_POST['email'],
            ':pass' => $passHash,
            ':type' => "admin"
        ));
        //se crea la tabla para el usuario
        $conexion->exec("CREATE TABLE ".$name." (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(35),
            intro TEXT,
            descripcion TEXT,
            image VARCHAR(255)
        );");

        $_SESSION['acceso'] = $_POST["name"];//se asigna en nombre
        $_SESSION['permisos'] = "user";//se asigna el permiso

        mkdir("img/admins/$name", 0755);//se crea su propia carpeta

        header('Location: acceso_cas.php');
        
     } else {
         $name="Guess";
         $error = "";
         echo '<script type="text/javascript">
        alert("El usuario ya existe");
        window.location.href="index_cas.php";
        </script>';
    }
}

?>