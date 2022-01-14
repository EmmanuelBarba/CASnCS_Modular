<?php

require_once 'config/functions.php';
// require_once 'config/login.php';
$conexion = connect($server, $db, $user, $pass);
if (!$conexion) {
    header('location: 404.php');
}

//revisa las sesiones
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['permisos'] == "admin") {
        $name = ($_SESSION['acceso']);
    } else {
        $name = ($_SESSION['acceso']);
    }
} else {
    header('Location: index_cas.php');
}


if (isset($_POST['enviar_orden'])) { //revisar nombre del boton
    //queremos saber si existe
    $taller = $name;
    $validar = $conexion->prepare("SELECT id_taller, nombre taller FROM admin_taller WHERE  nombre_taller= .$taller. LIMIT 1;");
    // $validar = $conexion->prepare("SELECT id_clientes FROM clientes where nombre_cliente = .$taller. LIMIT 1;");
    $validar->execute([$taller]);
    // //Ver cuántas filas devuelve
    $filas = $validar->rowCount();


    if ($filas <= 0) {

        $sql = $conexion->prepare("SELECT id_taller FROM admin_taller where nombre_taller = '$name'");
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $sql->execute();
        $data = array();
        $i = 0;
        while ($id = $sql->fetch()) {
            // echo $id["id_taller"];
            $id_taller = implode("", $id);
            // echo $id_taller;
        }

        $id_nom_client = $_POST['id_orden'];
        $sql_2 = $conexion->prepare("SELECT id_clientes FROM clientes where nombre_cliente = '$id_nom_client'");
        $sql_2->setFetchMode(PDO::FETCH_ASSOC);
        $sql_2->execute();
        $data_2 = array();
        $i = 0;
        while ($id = $sql_2->fetch()) {
            // echo $id["id_nom_client"];
            $id_nom_client = implode("", $id);
            // echo $id_nom_client;
        }
        // `id_sg`, `fecha_orden`, `client_hasorden`, `modelo_coche`, `placas_coche`, `falla_coche`, 
        // `observaciones_coche`, `taller_hasordenes`, `estado_orden`, `informe_tecnico`, `estatus`
        $insert = $conexion->prepare("INSERT INTO orden_servicio (client_hasorden, modelo_coche, placas_coche, falla_coche, observaciones_coche, 
        taller_hasordenes, estado_orden, informe_tecnico, estatus) 
        VALUES (:client_hasorden, :modelo_coche, :placas_coche, :falla_coche, :observaciones_coche, :taller_hasordenes, 
        :estado_orden, :informe_tecnico, :estatus)"); //registro de datos
        $insert->execute(array(
            ':client_hasorden'      => $id_nom_client,
            ':modelo_coche'         => $_POST['modelo_coche'],
            ':placas_coche'         => $_POST['placas_coche'],
            ':falla_coche'          => $_POST['falla_coche'],
            ':observaciones_coche'  => $_POST['observaciones_coche'],
            ':taller_hasordenes'    => $id_taller,
            ':estado_orden'         => "Orden aceptada por el mecánico",
            ':informe_tecnico'      => "Aún sin reparar",
            ':estatus'              => "En Espera"
        ));
        echo '<script type="text/javascript">
                alert("Los datos fuerón guardados con exito.");
                window.location.href="acceso_cas.php";
            </script>';
    } else {
        // $error = "";
        // echo '<script type="text/javascript">
        //         alert("El cliente no existe.");
        //         window.location.href="acceso_cas.php";
        //     </script>';
    }
}
