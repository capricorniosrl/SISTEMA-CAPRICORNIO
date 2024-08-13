<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");

    $id_cliente = $_POST["id_cliente"];
    $id_usuario = $_POST["id_usuario"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $reprogramar = "SI";

    $sql = $pdo->prepare('UPDATE tb_clientes SET reprogramar=:reprogramar, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada WHERE id_cliente=:id_cliente AND id_usuario_fk=:id_usuario_fk');

    $sql->bindParam(':reprogramar',$reprogramar);
    $sql->bindParam(':fecha_llamada',$fecha);
    $sql->bindParam(':hora_llamada',$hora);
    $sql->bindParam(':id_cliente',$id_cliente);
    $sql->bindParam(':id_usuario_fk',$id_usuario);
        
    if ($sql->execute()) {
    
        header('location:'.$URL.'/admin/clientes/reprogramar.php');
    } 

?>