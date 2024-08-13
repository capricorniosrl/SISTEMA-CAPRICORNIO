<?php

include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

$id_user = $_GET['id'];


$sql=$pdo->prepare("SELECT * FROM tb_usuarios WHERE id_usuario='$id_user'");
$sql->execute();

$datos=$sql->fetch(PDO::FETCH_ASSOC);

$ci_user=$datos['ci'];



// ENCRIPTAR Y GENERAR SU PASSWORD
$password_encriptado=password_hash($ci_user,PASSWORD_DEFAULT);

$sentencia = $pdo->prepare('UPDATE tb_usuarios SET password=:password WHERE id_usuario=:id_usuario');


$sentencia->bindParam(':password',$password_encriptado);
$sentencia->bindParam(':id_usuario',$id_user);


if ($sentencia->execute()) {
header('location:'.$URL.'/admin/contraseña/buscar.php');


} else {

}







?>