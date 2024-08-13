<?php
    include ("../../app/config/config.php");
    include ("../../app/config/conexion.php");


    $id_cliente = $_POST['id_cliente'];
    $id_usuario = $_POST['id_usuario'];
    $estado = 1;
    $visitantes=$_POST['visitantes'];
    $fecha_visita = $_POST['fecha_visita'];

  
    

    $sentencia = $pdo->prepare('INSERT INTO tb_agendas (fecha_visita, visitantes, estado,id_usuario_fk, id_cliente_fk) VALUE (:fecha_visita, :visitantes, :estado,:id_usuario_fk, :id_cliente_fk)');

   
    
    $sentencia->bindParam(':fecha_visita',$fecha_visita);
    $sentencia->bindParam(':visitantes',$visitantes);
    $sentencia->bindParam(':estado',$estado);
    $sentencia->bindParam(':id_usuario_fk',$id_usuario);
    $sentencia->bindParam(':id_cliente_fk',$id_cliente);


    if ($sentencia->execute()) {
        
        header('Location:'. $URL.'/admin/agendar/listar.php');
        exit();


    }