<?php

    $server= "localhost";
    $user= "root";
    $pass= "";
    $db= "modular";
    
    try{
        $con = new PDO("mysql:host=$server;dbname=$db",$user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        //echo "Conexion ok";
    }catch (PDOException $e){
        echo "Conexion Fallida: ".$e->getMessage();
    }

?>