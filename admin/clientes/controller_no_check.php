<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$reprogramar="NO";
$llamada=$_POST["llamada"];
$id_cliente=$_POST["id_cliente"];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$fecha_llamada = NULL;
$hora_llamada = NULL;

$detalle = $_POST['detalle'];
$detalle2 = $_POST['detalle2'];
$detalle_unido = ($detalle) . "\n* " . ($detalle2);


if ($llamada=="NO CONTESTO") {

    $sentencia = $pdo->prepare('UPDATE tb_clientes SET nombres=:nombres, apellidos=:apellidos, reprogramar=:reprogramar, detalle_llamada=:detalle_llamada, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada, detalle=:detalle WHERE id_cliente=:id_cliente');


    $sentencia->bindParam(':nombres',$nombre);
    $sentencia->bindParam(':apellidos',$apellido);
    $sentencia->bindParam(':reprogramar',$reprogramar);
    $sentencia->bindParam(':detalle_llamada',$llamada);
    $sentencia->bindParam(':id_cliente',$id_cliente);

    $sentencia->bindParam(':fecha_llamada',$fecha_llamada);
    $sentencia->bindParam(':hora_llamada',$hora_llamada);

    $sentencia->bindParam(':detalle',$detalle_unido);

}
else {
    if ($llamada=="SIN_INTERES") {
        
        $sentencia = $pdo->prepare('UPDATE tb_clientes SET nombres=:nombres, apellidos=:apellidos, reprogramar=:reprogramar, detalle_llamada=:detalle_llamada, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada, detalle=:detalle WHERE id_cliente=:id_cliente');


        $sentencia->bindParam(':nombres',$nombre);
        $sentencia->bindParam(':apellidos',$apellido);
        $sentencia->bindParam(':reprogramar',$reprogramar);
        $sentencia->bindParam(':detalle_llamada',$llamada);
        $sentencia->bindParam(':id_cliente',$id_cliente);
    
        $sentencia->bindParam(':fecha_llamada',$fecha_llamada);
        $sentencia->bindParam(':hora_llamada',$hora_llamada);
    
        $sentencia->bindParam(':detalle',$detalle_unido);   
    }
}



if ($sentencia->execute()) {
    header('location:'.$URL.'/admin/clientes/');
}  




    




?>