<?php

include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$error="";

// verificamos si existe el campo
if (empty($_POST['nombre_urbanizacion'])) {
    
    $error = "* INGRESE UN NOMBRE"."<br>";

}else {

    // si existe el campo validamos la informacion para que no entre vados o codigo malicioso
    $nombre=$_POST['nombre_urbanizacion'];

    // limpiamos el campo
    $nombre = filter_var($nombre,FILTER_SANITIZE_STRING);

    // CON TRIM LIMPIAMOS SI EL USUARIO PONE UN ESPACIO EN BLANCO AL PRINCIPIO DEL INPUT
    $nombre = trim($nombre);
    if ($nombre=="") {
        $error .= "* EL NOMBRE ESTA VACIO INGRESE UN NOMBRE VERDADERO <br>";
    }

}

$id_urbanizacion=$_POST['id_urbanizacion'];




if ($error=='') {
 
    
    $sentencia = $pdo->prepare('UPDATE tb_urbanizacion SET nombre_urbanizacion=:nombre_urbanizacion,updated_at=:updated_at WHERE id_urbanizacion=:id_urbanizacion');

    $sentencia->bindParam(':nombre_urbanizacion',$nombre);
    $sentencia->bindParam(':updated_at',$fechayhora);
    $sentencia->bindParam(':id_urbanizacion',$id_urbanizacion);


    if ($sentencia->execute()) {
        echo "exito";
    }
    

    
} else {
    echo $error;
    
}



?>