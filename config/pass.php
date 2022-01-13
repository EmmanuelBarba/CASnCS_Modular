<?php
include 'config.php';

if (isset($_POST['newpass'])) {

    $state = $conexion->prepare("SELECT id_taller, pass_taller, mail_taller FROM admin_taller WHERE nombre_taller = :user"); //busqueda preparada
    $state->execute(array(':user' => $name)); //se utiliza la variable de usuario en la validacion
    $state->execute(); //se ejecuta la busqueda
    $result = $state->fetch();

    if (password_verify($_POST['pass'], $result['pass_taller'])) {
        $npass = $_POST["npass"];
        $cpass = $_POST["cpass"];
        if ($npass == $cpass) {
            $passHash = password_hash($_POST['npass'], PASSWORD_BCRYPT, array("cost" => 12));
            $state = $con->prepare("UPDATE admin_taller SET pass_taller = :npass WHERE id_taller = :id");
            $state->execute(array(
                ':id' => $result['id_taller'],
                ':npass' => $passHash
            ));
            $ok = "";
            echo '<script type="text/javascript">
                alert("La contraseña ha sido actualizada correctamente.");
                window.location.href="acceso_cas.php";
            </script>';
        } else {
            echo '<script type="text/javascript">
                alert("Las contraseñas no coiciden, por favor verifique sus datos.");
                window.location.href="acceso_cas.php";
            </script>';
            $error_pass = "";
        }
    } else {
        echo '<script type="text/javascript">
            alert("La contraseña actual es incorrecta, por favor verifique sus datos.");
             window.location.href="acceso_cas.php";
        </script>';
        $error_pass = "";
    }
}
