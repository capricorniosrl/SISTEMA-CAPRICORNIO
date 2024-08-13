<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

$id_usuario = $_POST['cliente_id'];
// echo "<br>funciones= ".$_POST['funciones'];
$funciones = $_POST['funciones'];


foreach ($funciones as $dato) {
    $sql = $pdo->prepare("INSERT INTO tb_funciones (id_usuario_fk,nombre_funcion) VALUES (:id_usuario_fk,:nombre_funcion)");
    $sql->bindParam(':id_usuario_fk',$id_usuario);
    $sql->bindParam(':nombre_funcion',$dato);
    $sql->execute();
}
header('location:'.$URL.'/admin/funciones/');
?>