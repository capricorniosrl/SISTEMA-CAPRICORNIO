<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
$texto = $_POST['contato'];

$id_comprador_fk = $_POST['id_comprador'];


$sql = $pdo->prepare("INSERT INTO tb_documento (texto,id_comprador_fk) VALUES (:texto,:id_comprador_fk)");

$sql->bindParam(':texto', $texto);
$sql->bindParam(':id_comprador_fk', $id_comprador_fk);

if ($sql->execute()) {
    $estado = 1;
    $sql_update = $pdo->prepare("UPDATE tb_comprador SET estado_doc_priv='$estado' WHERE id_comprador='$id_comprador_fk'");
    $sql_update->execute();
    header('location:' . $URL . '/admin/legal/index.php');
}
