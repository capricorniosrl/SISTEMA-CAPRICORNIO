<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");

   $error="";

   $id_usuario_fk=$_POST['usuario_apoyo'];

   $id_agenda_fk=$_POST['id_agenda_apoyo'];

   echo $error;

 
    if ($error=="") {

        $sql = $pdo->prepare('INSERT INTO tb_apoyo (id_agenda_fk, id_usuario_fk) VALUES (:id_agenda_fk, :id_usuario_fk)');

        $sql->bindParam(':id_agenda_fk',$id_agenda_fk);
        $sql->bindParam(':id_usuario_fk',$id_usuario_fk);

        if ($sql->execute()) {
            echo "exito";
        }else {
            echo $error; 
        }   

    } else {
        echo $error;        
    }