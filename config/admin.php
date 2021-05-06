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
            $busqueda=$conexion->prepare("Select * from users");
            $busqueda->execute();
            $resultado = $busqueda->fetchAll();
        }else{
            header('Location: 403.php');
        }
    }else{
        header('Location: 403.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAS/title>
    <link rel="shortcut icon" href="../assets/icons/gallery.png" type="image/png">
    <link rel="stylesheet" href="../assets/styles/styleGallery.css">
    <link rel="stylesheet" href="../assets/styles/styleImg.css">
    <link rel="stylesheet" href="../assets/styles/boton.css">
    <link rel="stylesheet" href="../assets/styles/styleAdmin.css">
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
        <h1 id="h1demo">Admin</h1>
    </div>
    <h1 id="title">Tabla de usuarios</h1>
    <div class="contenedor2">
            <div class="bloque2">
                <table class="table users">
                <tr>
                    <th  scope="col">Id</th>
                    <th  scope="col">Usuario</th>
                    <th  scope="col">Contraseña</th>
                    <th  scope="col">Permisos</th>
                    <th  scope="col">Eliminar</th>
                    <th  scope="col">Ver</th>
                </tr>
                    <?php
                    foreach($resultado as $res)
                    {
                        $id=$res["id"];
                        $name=$res["name"];
                        if($res['id']==1){
                            echo "<tr>";
                            echo "<td>".$res["id"]."</td>";
                            echo "<td>".$res["name"]."</td>";
                            echo "<td>".$res["pass"]."</td>";
                            echo "<td>".$res["type"]."</td>";
                            echo "<td></td>";
                            echo "<td><a href='admin.php?view=$name'><img id='del' src='../assets/icons/view.svg'></a></td>";
                            echo "</tr>";

                        }else{
                            echo "<tr>";
                            echo "<td>".$res["id"]."</td>";
                            echo "<td>".$res["name"]."</td>";
                            echo "<td>".$res["pass"]."</td>";
                            echo "<td>".$res["type"]."</td>";
                            echo "<td><a  class='delimg' href='delete.php?id=$id'><img id='del' src='../assets/icons/delete.svg'></a></td>";
                            echo "<td><a href='admin.php?view=$name'><img id='del' src='../assets/icons/view.svg'></a></td>";
                            echo "</tr>";
                        }
                    }   
                    ?>
                </table>
            </div>
            <?php

                if(isset($_GET['view'])){
                    $us=$_GET['view'];
                    $busqueda=$conexion->prepare("Select * from ".$us."");
                    $busqueda->execute();
                    $resultado = $busqueda->fetchAll();
                    
                    if($resultado == null) {
                        
                        echo "<h1 id='title'>Galeria de $us vacia</h1>";
                    }else{
                        echo "<h1 id='title'>Tabla de $us</h1>";
                        echo "<div class='bloque2'>";
                        echo "<table class='table users'>";
                        echo "<tr>";
                            echo "<th scope='col'>Id</th>";
                            echo "<th scope='col'>Titulo</th>";
                            echo "<th scope='col'>Intro</th>";
                            echo "<th scope='col'>Descripcion</th>";
                            echo "<th scope='col'>Imagen</th>";
                            echo "<th scope='col'>Eliminar</th>";
                        echo "</tr>";
                        foreach($resultado as $res){
                            $id=$res["id"];
                            echo "<tr>";
                            echo "<td>".$res["id"]."</td>";
                            echo "<td>".$res["title"]."</td>";
                            echo "<td>".$res["intro"]."</td>";
                            echo "<td>".$res["descripcion"]."</td>";
                            echo "<td>".$res["image"]."</td>";
                            echo "<td><a  class='delimg' href='del.php?idimg=$id&name=$us'><img id='del' src='../assets/icons/delete.svg'></a></td>";
                            echo "</tr>";
                        }   
                        echo "</div>";
                    }
                }

            ?>
            
            
    </div>
    <script src="../scripts/jquery.js"></script>
</body>
</html>