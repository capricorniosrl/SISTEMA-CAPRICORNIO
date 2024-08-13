<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$fecha_registro=$_POST["fecha_registro"];

        // Convertir la fecha de registro en un objeto DateTime
        $date = new DateTime($fecha_registro);

        // Sumar 3 días a la fecha de registro
        $date->modify('+3 days');

        // Obtener la fecha de cierre en formato 'Y-m-d'
        $fecha_cierre = $date->format('Y-m-d');



$tipo_cliente=strtoupper($_POST["tipo_cliente"]); //OFICINA - PROPIO
$detalle_of_pro=$_POST["detalle"];
$tipoPago=$_POST["tipoPago"];
$monto=$_POST["monto"];
$numeroRecibo=$_POST["numeroRecibo"];
$numeroTransferencia=$_POST["numeroTransferencia"];
$resumen=$_POST["resumen"];
$siguiente=$_POST["siguiente"];
$id_agenda=$_POST["id_agenda"];

$lote=$_POST["lote"];
$manzano=$_POST["manzano"];

$sql = $pdo->prepare('INSERT INTO tb_informe (
id_agenda_fk, fecha_registro, fecha_cierre, tipo_pago, num_recibo, num_transferencia,lote,manzano, monto, tipo_cliente, detalle_tipo_cliente, resumen_visita, seguiente_paso )VALUES ( :id_agenda_fk, :fecha_registro, :fecha_cierre, :tipo_pago, :num_recibo, :num_transferencia, :lote, :manzano, :monto, :tipo_cliente, :detalle_tipo_cliente, :resumen_visita, :seguiente_paso )');
    


$sql->bindParam(':id_agenda_fk',$id_agenda);
$sql->bindParam(':fecha_registro',$fecha_registro);
$sql->bindParam(':fecha_cierre',$fecha_cierre);
$sql->bindParam(':tipo_pago',$tipoPago);
$sql->bindParam(':num_recibo',$numeroRecibo);
$sql->bindParam(':num_transferencia',$numeroTransferencia);
$sql->bindParam(':lote',$lote);
$sql->bindParam(':manzano',$manzano);
$sql->bindParam(':tipo_cliente',$tipo_cliente);
$sql->bindParam(':monto',$monto);
$sql->bindParam(':detalle_tipo_cliente',$detalle_of_pro);
$sql->bindParam(':resumen_visita',$resumen);
$sql->bindParam(':seguiente_paso',$siguiente);

if ($sql->execute()) {
    
    header('location:'.$URL.'/admin/agendar/listar.php');
}  

?>