<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="buscar.php" method="post">
            <input type="text" name="buscar" id="">
            <input type="submit" value="Buscar">
            <a href="nuevo.php">Añadir Nuevo</a>
        </form>
    </div>
    <div>
        <table>
            <tr>
                <td>ID</td>
                <td>SERVICIO</td>
                <td>EMPRESA</td>
                <td>NOMBRE</td>
                <td>APELLIDO</td>
                <td>CORREO</td>
                <td>DIRECCION</td>
                <td>TELEFONO</td>
            </tr>
            <?php
                $buscar = $_POST['buscar'];
                $conexion = mysqli_connect("localhost", "root", "", "formulario");
                $sql = "SELECT id, servicio, empresa, nombre, apellido, correo, direccion, telefono FROM clientes 
                WHERE nombre like '$buscar' '%' order by id desc";
                $resultado = mysqli_query($conexion, $sql);
                while ($mostrar = mysqli_fetch_row($resultado)) {
                    ?>
                    <tr>
                        <td><?php echo $mostrar[0] ?></td>
                        <td><?php echo $mostrar[1] ?></td>
                        <td><?php echo $mostrar[2] ?></td>
                        <td><?php echo $mostrar[3] ?></td>
                        <td><?php echo $mostrar[4] ?></td>
                        <td><?php echo $mostrar[5] ?></td>
                        <td><?php echo $mostrar[6] ?></td>
                        <td><?php echo $mostrar[7] ?></td>
                        <td>
                            <a href="editar.php?
                            id=<?php echo $mostrar[0] ?> &
                            servicio=<?php echo $mostrar[1] ?> &
                            empresa=<?php echo $mostrar[2] ?> &
                            nombre=<?php echo $mostrar[3] ?> &
                            apellido=<?php echo $mostrar[4] ?> &
                            correo=<?php echo $mostrar[5] ?> &
                            direccion=<?php echo $mostrar[6] ?> &
                            telefono=<?php echo $mostrar[7] ?>
                            ">Editar</a>
                            <a href="speliminar.php? id=<?php echo $mostrar[0] ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
        </table>
    </div>
</body>
</html>