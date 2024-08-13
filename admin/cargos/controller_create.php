<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");
    $error="";




    // verificamos si existe el campo
    if (empty($_POST['nombre'])) {
        
        $error = "* INGRESE UN NOMBRE"."<br>";

    }else {

        // si existe el campo validamos la informacion para que no entre vados o codigo malicioso
        $nombre=$_POST['nombre'];

        // limpiamos el campo
        $nombre = filter_var($nombre,FILTER_SANITIZE_STRING);

        // CON TRIM LIMPIAMOS SI EL USUARIO PONE UN ESPACIO EN BLANCO AL PRINCIPIO DEL INPUT
        $nombre = trim($nombre);
        if ($nombre=="") {
            $error .= "* EL NOMBRE ESTA VACIO INGRESE UN NOMBRE VERDADERO <br>";
        }

    }

    

    if ($error=='') {

        $sql = $pdo->prepare('INSERT INTO tb_cargo (nombre_cargo, created_at, updated_at,estado) VALUES (:nombre_cargo, :created_at, :updated_at, :estado)');


        $sql->bindParam(':nombre_cargo',$nombre);
        $sql->bindParam(':created_at',$fechayhora);
        $sql->bindParam(':updated_at',$fechayhora);
        $sql->bindParam(':estado',$estado);

        if ($sql->execute()) {
            echo "exito";
        } else {
            // echo $errorSQL='ERROR 1: '.mysqli_error($sql);
        }
        

        
    } else {
        echo $error;
        
    }
    





?>