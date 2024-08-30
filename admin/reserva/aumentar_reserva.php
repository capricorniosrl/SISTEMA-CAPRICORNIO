<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

$id_informe = $_POST['id_informe'];
$monto = $_POST['monto'];
$monto_literal = $_POST['monto_literal'];
$pago = $_POST['pago'];
$recibo = $_POST['recibo'];
$concepto = $_POST['concepto'];

$fecha_registro = $_POST['fecha_registro'];




$sql = $pdo->prepare("INSERT INTO tb_aumento_reserva (monto_aumento,literal_aumento,tipo_pago_aumento,concepto,num_recibo_aumento,fecha_registro_aumento,id_informe_fk) VALUES (:monto_aumento,:literal_aumento,:tipo_pago_aumento,:concepto,:num_recibo_aumento,:fecha_registro_aumento,:id_informe_fk)");

$sql->bindParam(':monto_aumento', $monto);
$sql->bindParam(':literal_aumento', $monto_literal);
$sql->bindParam(':tipo_pago_aumento', $pago);
$sql->bindParam(':concepto', $concepto);
$sql->bindParam(':num_recibo_aumento', $recibo);
$sql->bindParam(':fecha_registro_aumento', $fecha_registro);
$sql->bindParam(':id_informe_fk', $id_informe);


if ($sql->execute()) {
    header('location:' . $URL . '/admin/reserva/');
    // echo "SE ACTUALIZO LA INFORMACION CORRECTAMENTE";
} else {
    echo "ERROR EN EL REGISTRO DE LA INFORMACION";
}
