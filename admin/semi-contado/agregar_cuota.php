<?php


include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


$id_semicontado= $_POST['id_semicontado'];

$sql=$pdo->prepare("SELECT COUNT(*) as cuota, fecha_pago FROM tb_cuotas WHERE id_semicontado_fk='$id_semicontado=' ORDER BY fecha_pago DESC
LIMIT 1");



$sql->execute();
$dato=$sql->fetch(PDO::FETCH_ASSOC);

echo $cuota1=$dato['cuota'];
echo "<br>";

echo $cuota=($dato['cuota']+1)."° Cuota";
echo "<br>";

echo $fecha_act=$dato['fecha_pago'];
echo "<br>";



echo "<br>".$timestamp = strtotime($fecha_act);
echo "<br>".$timestamp_nueva = strtotime("+$cuota1 months", $timestamp);
echo "<br> acual". $fecha_nueva = date('Y-m-d', $timestamp_nueva);


$nueva_cuota=1;



$sq4 = $pdo->prepare("INSERT INTO tb_cuotas (id_semicontado_fk, nombre_cuota, fecha_pago,nueva_cuota) VALUES (:id_semicontado_fk, :nombre_cuota, :fecha_pago,:nueva_cuota)");

$sq4->bindParam(':id_semicontado_fk', $id_semicontado);
$sq4->bindParam(':nombre_cuota', $cuota);
$sq4->bindParam(':fecha_pago', $fecha_nueva);
$sq4->bindParam(':nueva_cuota', $nueva_cuota);
$sq4->execute();

echo "La cuota ha sido agregada exitosamente.";


?>