<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");



$id_usuario = $_POST['id'];

$estado = 1;
$sentencia = $pdo->prepare("UPDATE tb_usuarios SET created_at='$fechayhora',estado='$estado' WHERE id_usuario='$id_usuario'");


if ($sentencia->execute()) {
    echo "exito";
} else {
}
