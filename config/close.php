<?php

    session_start();

    if(isset($_SESSION['acceso'])){
        session_destroy();
        header("Location: ../index_cas.html");
    }

?>