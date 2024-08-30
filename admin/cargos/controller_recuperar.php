<?php

include ("../../app/config/config.php");
include ("../../app/config/conexion.php");


$datos_cargo = $_POST['datos_cargo'];
// Procesar los datos aquí
//echo "Datos eliminados correctamente";
echo "datos: ".$datos_cargo;
$query = $pdo->prepare("UPDATE tb_cargo set estado = 1 where id_cargo = :id_cargo");
$query->bindParam(':id_cargo',$datos_cargo);
$query->execute();
?>