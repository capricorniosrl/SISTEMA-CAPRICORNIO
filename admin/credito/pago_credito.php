<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$error="";

if (empty($_POST['recibo'])) {
    $error.="FALTA INGRESAR EL NUMERO DE RECIBO O TRANSFERENCIA";
}

$id_creadito=$_POST['id_credito'];
$monto_cancelar=$_POST['monto_cancelar'];
$recibo=$_POST['recibo'];
$id_cuota=$_POST['id_cuota'];
$fecha_pago=$_POST['fecha_pago'];
$tipo_pago=$_POST['tipo_pago'];

if ($error=="") {
    $sql = $pdo->prepare('UPDATE tb_cuotas_credito SET monto=:monto,tipo_pago=:tipo_pago,fecha_registro_pago=:fecha_registro_pago,numero_recibo=:numero_recibo WHERE id_credito_fk=:id_credito_fk AND id_cuota=:id_cuota ');

    $sql->bindParam(':monto',$monto_cancelar);
    $sql->bindParam(':tipo_pago',$tipo_pago);
    $sql->bindParam(':fecha_registro_pago',$fecha_pago);
    $sql->bindParam(':numero_recibo',$recibo);
    
    $sql->bindParam(':id_credito_fk',$id_creadito);
    $sql->bindParam(':id_cuota',$id_cuota);
    
    if ($sql->execute()) {
        echo "exito";
    }
    
} else {
    echo $error;
}

















?>