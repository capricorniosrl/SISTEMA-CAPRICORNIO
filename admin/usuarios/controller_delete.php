<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");


    $id_usuario = $_POST['id_usuario'];

    $estado=0;
    $sentencia = $pdo->prepare("UPDATE tb_usuarios SET fyh_eliminacion='$fechayhora',estado='$estado' WHERE id_usuario='$id_usuario'");


    if ($sentencia->execute()) {
        header('location:'.$URL.'/admin/usuarios/');
        // echo "SE ACTUALIZO LA INFORMACION CORRECTAMENTE";
    } else {
        echo "ERROR EN EL REGISTRO DE LA INFORMACION";
    }
    
    
