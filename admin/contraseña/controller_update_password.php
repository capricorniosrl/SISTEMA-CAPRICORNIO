<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');

$pass=$_POST['pass'];
$pass_verify=$_POST['pass_confir'];

// ENCRIPTAR Y GENERAR SU PASSWORD
$password_encriptado=password_hash($pass_verify,PASSWORD_DEFAULT);

$sentencia = $pdo->prepare('UPDATE tb_usuarios SET password=:password WHERE id_usuario=:id_usuario');


$sentencia->bindParam(':password',$password_encriptado);
$sentencia->bindParam(':id_usuario',$id_usuario);


if ($sentencia->execute()) {
    header('location:'.$URL.'/admin');


} else {

}
   
?>