<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$reprogramar = "SI";
$nombre = $_POST['nombre'];
$llamada= $_POST['llamada'];
$apellidos = $_POST['apellido'];
$fecha_llamada = $_POST['fecha_llamada'];
$hora_llamada = $_POST['hora_llamada'];
$detalle = $_POST['detalle'];
$fecha_registro = $_POST['fecha_registro'];
$urbanizacion=$_POST['urbanizacion'];



$detalle = $_POST['detalle'];
$detalle2 = $_POST['detalle2'];
$detalle_unido = ($detalle) . "\n* " . ($detalle2);

$id_cliente = $_POST['id_cliente'];

$sentencia = $pdo->prepare('UPDATE tb_clientes SET

nombres=:nombres,
apellidos=:apellidos,
fecha_llamada=:fecha_llamada,
hora_llamada=:hora_llamada,
detalle=:detalle,
fecha_registro=:fecha_registro,
tipo_urbanizacion=:tipo_urbanizacion,
reprogramar=:reprogramar,
detalle_llamada=:detalle_llamada
WHERE id_cliente=:id_cliente');


$sentencia->bindParam(':nombres',$nombre);
$sentencia->bindParam(':apellidos',$apellidos);
$sentencia->bindParam(':fecha_llamada',$fecha_llamada);
$sentencia->bindParam(':hora_llamada',$hora_llamada);
$sentencia->bindParam(':detalle',$detalle_unido);
$sentencia->bindParam(':fecha_registro',$fecha_registro);
$sentencia->bindParam(':tipo_urbanizacion',$urbanizacion);
$sentencia->bindParam(':reprogramar',$reprogramar);
$sentencia->bindParam(':detalle_llamada',$llamada);
$sentencia->bindParam(':id_cliente',$id_cliente);


if ($sentencia->execute()) {

    header('location:'.$URL.'/admin/clientes/');
}  

?>