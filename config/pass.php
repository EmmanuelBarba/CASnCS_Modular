<?php
    require_once 'functions.php';

    $conexion = connect($server, $db, $user, $pass);

    if (!$conexion) {
        header('Location: 404.php');
    }

    session_start();//sesion
    //verificar la sesion
    if(isset($_SESSION['acceso'])){
        if($_SESSION['permisos']=="admin"){
            $name=($_SESSION['permisos']);
        }else{
            $name=($_SESSION['acceso']);
        } 
    }

    if(isset($_POST['newpass'])){
        
        $state = $conexion->prepare("SELECT id, pass FROM users WHERE name = :user");//busqueda preparada
        $state->execute(array(
            ':user' => $name
        ));//se utiliza la variable de usuario en la validacion

        $state->execute();//se ejecuta la busqueda

        $result = $state->fetch();

        if(password_verify($_POST['pass'], $result['pass'])) {
            $passHash = password_hash($_POST['npass'], PASSWORD_BCRYPT, array("cost" => 12));
            $state = $conexion->prepare("UPDATE users SET pass = :pass WHERE id = :id");
            $state->execute(array(
                ':id' => $result['id'],
                ':pass' => $passHash
            ));
            $ok="";
           }else{
            $error2="";
        }
    }


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NEOCMS</title>
    <link rel="shortcut icon" href="../assets/icons/gallery.png" type="image/png">
    <link rel="stylesheet" href="../assets/styles/styleGallery.css">
    <link rel="stylesheet" href="../assets/styles/boton.css">
    <link rel="stylesheet" href="../assets/styles/styleUpload.css">
    <script src="../scripts/jquery-3.4.1.js"></script>
    <script src="../scripts/jquery-3.4.1.min.js"></script>
</head>
<body>
    <a href="" class="subir sleep" ></a>
    <div class="loader"><img src="../img/preloader.png" alt=""></div>
    <header>
        <img src="../img/logo.png" alt="">  
    </header>
    <div id="nav">
        <a href="../galeria.php"><img src="../assets/icons/back.svg" alt=""></a>
        <h1 id="h1demo2">Configuracion</h1>
    </div>

    <div class="contenedor">
        <div class="bloqueUP">
            <form action="pass.php" class="form" method="post" >

                <legend>Cambiar contraseña</legend>

                <label for="pass">Ingresa la contraseña actual</label>
                <input type="password" name="pass" id="pass" required><br>
                <?php if (isset($error2)){ echo "<label style='color:red'>Contraseña incorrecta</label><br>";} ?>
                <?php if (isset($ok)){ echo "<label style='color:green'>Contraseña actualizada</label><br>";} ?>
                
                <label for="pass">Ingresa la nueva contraseña</label>
                <input class="npass" type="password" name="npass" id="npass" required><br>

                <label for="pass">Repite la contraseña</label>
                <input class="npass" type="password" id="cpass" required><br>

                <div class="alerta" style="display: none;"></div>

                <input type="submit" name="newpass" value="Crear" class="b1">
                <input type="reset" value="Limpiar" class="b1">
                
                
            </form>
        </div>

    </div>
    <script src="../scripts/jquery.js"></script>
</body>
</html>