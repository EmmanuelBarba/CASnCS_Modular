<?php
    require_once 'config/functions.php';
    $conexion = connect($server,$db,$user,$pass);
    if(!$conexion){
    header('location: index.php');
    }

    session_start();//crea sesion

    //revisa las sesiones
    if(isset($_SESSION['acceso'])){
        if($_SESSION['permisos']=="admin"){
            $name="admin";
        }else{
            $name=($_SESSION['acceso']);
        }
        
    }else{
        $name="admin";
    }

    $state = $conexion->prepare("SELECT id,title,intro,image FROM ".$name."");//se genera la busqueda
    $state ->execute();

    $result = $state->fetchAll();

    // session_start();

    // if(isset($_SESSION['acceso'])){
    //     session_destroy();
    //     header("Location: ../index_cas.php");
    // }
   
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NEOCMS</title>
    <link rel="shortcut icon" href="assets/icons/gallery.png" type="image/png">
    <link rel="stylesheet" href="assets/styles/styleGallery.css">
    <link rel="stylesheet" href="assets/fonts/fonts.css">
    <link rel="stylesheet" href="assets/styles/boton.css">
    <script src="scripts/jquery-3.4.1.js"></script>
    <script src="scripts/jquery-3.4.1.min.js"></script>
</head>

<body>
        <a href="" class="subir sleep" ></a>
        <div class="loader"><img src="img/preloader.png" alt=""></div>
        <header>
            <img src="img/logo.png" alt="">
        </header>
        <div id="nav">
            <?php if(isset($_SESSION['acceso'])){
                        if($_SESSION['permisos']=="admin"){
                            echo "<a href='config/upload.php'><img src='assets/icons/add.svg' alt=''></a>";
                            echo "<a href='config/admin.php'><img src='assets/icons/sql.svg' alt=''></a>";
                            echo " <h1 id='h1user'>Galería</h1>";
                            echo "<a href='config/pass.php'><img src='assets/icons/config.svg' alt=''></a>";
                            echo "<a href='config/close.php'><img src='assets/icons/out.svg' alt=''></a>";
                        }else{
                            echo "<a href='config/upload.php'><img src='assets/icons/add.svg' alt=''></a>";
                            echo " <h1 id='h1user'></h1>";
                            echo " <h1 id='h1user'>Galería</h1>";
                            echo "<a href='config/pass.php'><img src='assets/icons/config.svg' alt=''></a>";
                            echo "<a href='config/close.php'><img src='assets/icons/out.svg' alt=''></a>";
                        }
                    } else{
                        echo "<a href='index.php'><img src='assets/icons/home.svg' alt=''></a>";
                        echo "<h1 id='h1demo'>Galería</h1>";
                    }
            ?>     
            
        </div>
        
        <div class="contenedor">
            <?php if($result==null){ echo "<h1 id='msj'>Hola, $name<br>te invitamos a agregar nuevos articulos a tu galeria</h1>";} ?>
           <?php foreach($result as $article): ?>
            <div class="bloque">
                <img src="img/<?php echo $name;?>/<?php echo $article['image']?>" alt="">
                <a href="imagen.php?img=<?php echo $article['id']?>"><h4><?php echo $article['title']?></h4></a>
                <p><?php echo $article['intro']?></p>
            </div>
            <?php endforeach;?>
        </div>
        <script src="scripts/jquery.js"></script>
</body>
<iframe width="350" height="430" allow="microphone;" src="https://console.dialogflow.com/api-client/demo/embedded/9c7656be-7921-441f-b4c9-408a4646b170"></iframe>
</html>

