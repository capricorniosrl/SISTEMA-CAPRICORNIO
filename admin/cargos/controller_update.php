<?php

include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$error="";

// verificamos si existe el campo
if (empty($_POST['nombre_cargo'])) {
    
    $error = "* INGRESE UN NOMBRE"."<br>";

}else {

    // si existe el campo validamos la informacion para que no entre vados o codigo malicioso
    $nombre=$_POST['nombre_cargo'];

    // limpiamos el campo
    $nombre = filter_var($nombre,FILTER_SANITIZE_STRING);

    // CON TRIM LIMPIAMOS SI EL USUARIO PONE UN ESPACIO EN BLANCO AL PRINCIPIO DEL INPUT
    $nombre = trim($nombre);
    if ($nombre=="") {
        $error .= "* EL NOMBRE ESTA VACIO INGRESE UN NOMBRE VERDADERO <br>";
    }

}

$id_cargo=$_POST['id_cargo'];




if ($error=='') {
 
    
    $sentencia = $pdo->prepare('UPDATE tb_cargo SET nombre_cargo=:nombre_cargo,updated_at=:updated_at WHERE id_cargo=:id_cargo');

    $sentencia->bindParam(':nombre_cargo',$nombre);
    $sentencia->bindParam(':updated_at',$fechayhora);
    $sentencia->bindParam(':id_cargo',$id_cargo);


    if ($sentencia->execute()) {
        echo "exito";
    }
    

    
} else {
    echo $error;
    
}



?>