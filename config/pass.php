<?php
    require_once 'functions.php';

    $conexion = connect($server, $db, $user, $pass);


    if(isset($_POST['newpass'])){
        
        $state = $conexion->prepare("SELECT id_taller, pass_taller FROM admin_taller WHERE name = :user");//busqueda preparada
        $state->execute(array(
            ':user' => $name
        ));//se utiliza la variable de usuario en la validacion

        $state->execute();//se ejecuta la busqueda

        $result = $state->fetch();


        if(password_verify($_POST['pass'], $result['pass_taller'])) {
            $passHash = password_hash($_POST['npass'], PASSWORD_BCRYPT, array("cost" => 12));
            $state = $conexion->prepare("UPDATE admin_taller SET pass_taller = :pass WHERE id_taller = :id");
            $state->execute(array(
                ':id' => $result['id'],
                ':pass' => $passHash
            ));
            echo $name;
           }else{
            $error2="";
        }
    }


    
?>

