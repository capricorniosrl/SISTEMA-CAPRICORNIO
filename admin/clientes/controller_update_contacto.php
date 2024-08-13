<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

$celular=$_POST['celular_actualizar'];
$id_contacto=$_POST['id_contacto_actualizar'];
        
$sql = $pdo->prepare('UPDATE tb_contactos SET celular=:celular, updated_at=:updated_at WHERE id_contacto=:id_contacto');


$sql->bindParam(':celular',$celular);
$sql->bindParam(':updated_at',$fechayhora);
$sql->bindParam(':id_contacto',$id_contacto);   
    


if ($sql->execute()) {
    // header('location:'.$URL.'/admin/clientes/');
    echo "exito";
}

?>