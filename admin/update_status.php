<?php
include ("../app/config/config.php");
include ("../app/config/conexion.php");

include ('../layout/admin/session.php');
include ('../layout/admin/datos_session_user.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $stmt = $pdo->prepare("UPDATE tb_usuarios SET estado_guia = 1 WHERE id_usuario = :id_usuario");
    $stmt->bindParam(':id_usuario',$id_usuario);     
    $stmt->execute();

}
?>