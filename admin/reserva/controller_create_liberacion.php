<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');
include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

$id_informe = $_POST['id_informe'];
$resumen_liberacion = $_POST['resumen_liberacion'];
$resumen_asesor = $_POST['resumen_asesor'];

$query = $pdo->prepare("INSERT INTO tb_liberacion (resumen,seguiente,id_informe_fk) VALUES (:resumen,:seguiente,:id_informe_fk)");
$query->bindParam(':resumen',$resumen_liberacion);
$query->bindParam(':seguiente',$resumen_asesor);
$query->bindParam(':id_informe_fk',$id_informe);




if ($query->execute()) {
        
    
    $estado=1;
    $sql = $pdo->prepare("UPDATE tb_informe SET estado_reporte=$estado WHERE id_informe=$id_informe");
    $sql->execute();
    header('Location:'. $URL.'/admin/reserva');
    exit();


}


?>