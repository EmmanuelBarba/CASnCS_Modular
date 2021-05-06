<?php
    
    require 'config.php';

    function connect($srv, $db, $u, $p){
        try{
            $con = new PDO("mysql:host=$srv;dbname=$db", $u, $p);
            return $con;
        }catch(PDOException $e){
            return false;
        } 
    }

?>