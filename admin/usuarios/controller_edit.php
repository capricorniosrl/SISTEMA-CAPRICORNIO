<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");


    $id_usuario = $_POST['id_usuario'];
    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $ci = $_POST['ci'];
    $exp=$_POST['exp'];
    $celular = $_POST['celular'];
    $cargo = $_POST['cargo'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
  
    
    $sentencia = $pdo->prepare('UPDATE tb_usuarios SET
    nombre=:nombre,
    ap_paterno=:ap_paterno,
    ap_materno=:ap_materno,
    ci=:ci,
    exp=:exp,
    celular=:celular,
    cargo=:cargo,
    email=:email,
    direccion=:direccion,
    updated_at=:updated_at WHERE id_usuario=:id_usuario
    
    ');


    
    $sentencia->bindParam(':nombre',$nombre);
    $sentencia->bindParam(':ap_paterno',$paterno);
    $sentencia->bindParam(':ap_materno',$materno);
    $sentencia->bindParam(':ci',$ci);
    $sentencia->bindParam(':exp',$exp);
    $sentencia->bindParam(':celular',$celular);
    $sentencia->bindParam(':cargo',$cargo);
    $sentencia->bindParam(':email',$correo);
    $sentencia->bindParam(':direccion',$direccion);
    $sentencia->bindParam(':updated_at',$fechayhora);
    $sentencia->bindParam(':id_usuario',$id_usuario);


    if ($sentencia->execute()) {
        header('location:'.$URL.'/admin/usuarios/');
        // echo "SE ACTUALIZO LA INFORMACION CORRECTAMENTE";
    } else {
        echo "ERROR EN EL REGISTRO DE LA INFORMACION";
    }
    
    
