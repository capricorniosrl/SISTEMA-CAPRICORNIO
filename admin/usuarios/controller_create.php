<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");


    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];
    $ci = $_POST['ci'];
    $celular = $_POST['celular'];
    $cargo = $_POST['cargo'];
    $direccion = $_POST['direccion'];
    $correo = $_POST['correo'];
    $exp=$_POST['exp'];
    

    // ENCRIPTAR Y GENERAR SU PASSWORD
    $password_encriptado=password_hash($ci,PASSWORD_DEFAULT);

    $sentencia = $pdo->prepare('INSERT INTO tb_usuarios (nombre, ap_paterno, ap_materno, ci,exp, celular, cargo, email, direccion, password,created_at, estado) VALUE (:nombre, :ap_paterno, :ap_materno, :ci, :exp, :celular, :cargo, :email, :direccion, :password, :created_at, :estado)');

   
    
    $sentencia->bindParam(':nombre',$nombre);
    $sentencia->bindParam(':ap_paterno',$paterno);
    $sentencia->bindParam(':ap_materno',$materno);
    $sentencia->bindParam(':ci',$ci);
    $sentencia->bindParam(':exp',$exp);
    $sentencia->bindParam(':celular',$celular);
    $sentencia->bindParam(':cargo',$cargo);
    $sentencia->bindParam(':email',$correo);
    $sentencia->bindParam(':direccion',$direccion);
    $sentencia->bindParam(':password',$password_encriptado);
    $sentencia->bindParam('created_at',$fechayhora);
    $sentencia->bindParam(':estado',$estado);


    if ($sentencia->execute()) {
        header('location:'.$URL.'/admin/usuarios/create.php');


    } else {

    }
    
    
