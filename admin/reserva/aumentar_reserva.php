<?php

include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


$monto=$_POST['monto'];
$id_informe=$_POST['id_informe'];

$sql=$pdo->prepare("SELECT monto FROM tb_informe WHERE id_informe='$id_informe'");
$sql->execute();
$dato=$sql->fetch(PDO::FETCH_ASSOC);

echo $monto_update = $dato['monto']+$monto;

$sql_update=$pdo->prepare("UPDATE tb_informe SET monto='$monto_update' WHERE id_informe='$id_informe'");


if ($sql_update->execute()) {
    header('location:'.$URL.'/admin/reserva/');
    // echo "SE ACTUALIZO LA INFORMACION CORRECTAMENTE";
} else {
    echo "ERROR EN EL REGISTRO DE LA INFORMACION";
}



?>