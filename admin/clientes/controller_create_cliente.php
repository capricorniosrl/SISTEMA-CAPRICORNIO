<!-- comment
<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$nombre = $_POST['nombre'];
$apellidos = $_POST['apellido'];
$celular = $_POST['celular']."<br>";
$urbanizacion = $_POST['urbanizacion'];
$fecha_registro = $_POST['fecha_registro'];
$llamada = $_POST['llamada'];
$detalle = $_POST['detalle'];
$detalle2 = $_POST['detalle2'];
$id_contacto = $_POST['id_contacto'];
$id_usuario = $_POST['id_usuario'];
$id_cliente = $_POST['id_cliente'];



$query_login = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_cliente='$id_cliente' AND id_usuario_fk='$id_usuario'");

$query_login->execute();

$usuarios = $query_login->fetchAll(PDO::FETCH_ASSOC);
$contador=0;
foreach ($usuarios as $usuario) {
    $contador=$contador+1;
          
}



if ($contador==0) {
    
    // VERIFICAMOS SI ESTA MARCADO EL CHECKBOX REPROGRAMAR
    if (isset($_POST['mi_checkbox'])) { //ESTA MARCADO REPROGRAMAR

        // insercion de datos para reprogramar llamada
    
        $sql = $pdo->prepare('INSERT INTO tb_clientes (nombres,apellidos,tipo_urbanizacion,reprogramar,detalle_llamada,detalle,fecha_registro,fecha_llamada,hora_llamada,created_at,updated_at,estado,id_usuario_fk,id_contacto_fk)VALUES (:nombres,:apellidos,:tipo_urbanizacion,:reprogramar,:detalle_llamada,:detalle,:fecha_registro,:fecha_llamada,:hora_llamada,:created_at,:updated_at,:estado,:id_usuario_fk,:id_contacto_fk)');
    
        $reprogramar="SI";
    
        $fecha_llamada = $_POST['fecha_llamada'];
        $hora_llamada = $_POST['hora_llamada'];
    
        $sql->bindParam(':nombres',$nombre);
        $sql->bindParam(':apellidos',$apellidos);
        $sql->bindParam(':tipo_urbanizacion',$urbanizacion);
        $sql->bindParam(':reprogramar',$reprogramar);
        $sql->bindParam(':detalle_llamada',$llamada);
        $sql->bindParam(':detalle',$detalle);
        $sql->bindParam(':fecha_registro',$fecha_registro);
    
        $sql->bindParam(':fecha_llamada',$fecha_llamada);
        $sql->bindParam(':hora_llamada',$hora_llamada);
    
        $sql->bindParam(':created_at',$fechayhora);
        $sql->bindParam(':updated_at',$fechayhora);
        $sql->bindParam(':estado',$estado);
        $sql->bindParam(':fecha_llamada',$fecha_llamada);
        $sql->bindParam(':hora_llamada',$hora_llamada);
    
        $sql->bindParam(':id_usuario_fk',$id_usuario);
        $sql->bindParam(':id_contacto_fk',$id_contacto);
    
    
    } else {
        $sql = $pdo->prepare('INSERT INTO tb_clientes (nombres,apellidos,tipo_urbanizacion,reprogramar,detalle_llamada,detalle,fecha_registro,created_at,updated_at,estado,id_usuario_fk,id_contacto_fk)VALUES (:nombres,:apellidos,:tipo_urbanizacion,:reprogramar,:detalle_llamada,:detalle,:fecha_registro,:created_at,:updated_at,:estado,:id_usuario_fk,:id_contacto_fk)');
    
        $reprogramar="NO";
    
        $sql->bindParam(':nombres',$nombre);
        $sql->bindParam(':apellidos',$apellidos);
        $sql->bindParam(':tipo_urbanizacion',$urbanizacion);
        $sql->bindParam(':reprogramar',$reprogramar);
        $sql->bindParam(':detalle_llamada',$llamada);
        $sql->bindParam(':detalle',$detalle);
        $sql->bindParam(':fecha_registro',$fecha_registro);
        $sql->bindParam(':created_at',$fechayhora);
        $sql->bindParam(':updated_at',$fechayhora);
        $sql->bindParam(':estado',$estado);
    
        $sql->bindParam(':id_usuario_fk',$id_usuario);
        $sql->bindParam(':id_contacto_fk',$id_contacto);   
        
    }
    
    if ($sql->execute()) {
    
        $sentencia = $pdo->prepare('UPDATE tb_contactos SET estado=:estado WHERE id_contacto=:id_contacto');
        $estado="0";
        $sentencia->bindParam(':estado',$estado);
        $sentencia->bindParam(':id_contacto',$id_contacto);
    
        if ($sentencia->execute()) {
    
            header('location:'.$URL.'/admin/clientes/');
        }  
    
    
    } else {
    
    }        
}else
{

    if ($llamada="SIN_INTERES") {

        $detalle = $_POST['detalle'];
        $detalle2 = $_POST['detalle2'];

        $detalle_unido = "1. " . htmlspecialchars($detalle) . "\n2. " . htmlspecialchars($detalle2);


        $reprogramar="NO";
        
        $fecha_llamada = NULL;
        $hora_llamada = NULL;

        $sentencia = $pdo->prepare('UPDATE tb_clientes SET nombres=:nombres, apellidos=:apellidos, reprogramar=:reprogramar, detalle_llamada=:detalle_llamada, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada, detalle=:detalle WHERE id_cliente=:id_cliente');

  
        $sentencia->bindParam(':nombres',$nombre);
        $sentencia->bindParam(':apellidos',$apellidos);
        $sentencia->bindParam(':reprogramar',$reprogramar);
        $sentencia->bindParam(':detalle_llamada',$llamada);
        $sentencia->bindParam(':id_cliente',$id_cliente);

        $sentencia->bindParam(':fecha_llamada',$fecha_llamada);
        $sentencia->bindParam(':hora_llamada',$hora_llamada);
        $sentencia->bindParam(':detalle',$detalle_unido);
    }
    else {
        
        $detalle = $_POST['detalle'];
        $detalle2 = $_POST['detalle2'];

        $detalle_unido = "*" . htmlspecialchars($detalle) . "\n2. *" . htmlspecialchars($detalle2);


        $reprogramar="NO";
        $llamada="NO CONTESTO";
        
        $fecha_llamada = NULL;
        $hora_llamada = NULL;

        $sentencia = $pdo->prepare('UPDATE tb_clientes SET reprogramar=:reprogramar, detalle_llamada=:detalle_llamada, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada, detalle=:detalle WHERE id_cliente=:id_cliente');

 
        $sentencia->bindParam(':reprogramar',$reprogramar);
        $sentencia->bindParam(':detalle_llamada',$llamada);
        $sentencia->bindParam(':id_cliente',$id_cliente);

        $sentencia->bindParam(':fecha_llamada',$fecha_llamada);
        $sentencia->bindParam(':hora_llamada',$hora_llamada);
        $sentencia->bindParam(':detalle',$detalle_unido);
    }


    if ($sentencia->execute()) {

        header('location:'.$URL.'/admin/clientes/reprogramar_verificar1.php');
    }  

}



    




?>