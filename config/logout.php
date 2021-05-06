<?php
    session_start();
    if(isset($_SESSION['acceso'])){//cambiar tipo segun nuetros archivos de configuracion
        session_destroy();
        header("Location: ../index_cas.php");
    }
?>