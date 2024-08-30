<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

$id_documento = $_POST['id_documento'];
$texto = $_POST['texto'];



$sql_update = $pdo->prepare("UPDATE tb_documento SET texto='$texto' WHERE id_documento='$id_documento'");
$sql_update->execute();
header('location:' . $URL . '/admin/legal/listar.php');
