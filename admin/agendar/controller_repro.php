
<?php
include ("../../app/config/config.php");
include ("../../app/config/conexion.php");
include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

// tabla contacto
$celular= $_POST['celular'];
$detalle_Agenda="NO";
$detalle="SIN DETALLES";

// tabla clientes
$nombre = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$tipo_urbanizacion = $_POST['tipo_urbanizacion'];
$detalle_cliente= $_POST['detalle'];
$detalle_cliente2= $_POST['detalle2'];
$reprogramar="SI";
$detalle_llamada="CONTESTO";
$fecha_registro = date('Y-m-d');
$fecha_llamada = $_POST['fecha_llamada'];
$hora_llamada = $_POST['hora_llamada'];
$estado=1;
$id_usuario_fk=$id_usuario;
$id_contacto_fk=$_POST['id_contacto'];


$detalle_unido = ($detalle_cliente2) . "\n* " . ($detalle_cliente);


$sql_contacto = $pdo->prepare("INSERT INTO tb_contactos (celular,created_at,updated_at,detalle,detalle_agenda,estado,id_usuario_fk) VALUES (:celular,:created_at,:updated_at,:detalle,:detalle_agenda,:estado,:id_usuario_fk)");

$sql_contacto->bindParam(':celular',$celular);
$sql_contacto->bindParam(':created_at',$fechayhora);
$sql_contacto->bindParam(':updated_at',$fechayhora);
$sql_contacto->bindParam(':detalle',$detalle);
$sql_contacto->bindParam(':detalle_agenda',$detalle_Agenda);
$sql_contacto->bindParam(':estado',$estado);
$sql_contacto->bindParam(':id_usuario_fk',$id_usuario);

if ($sql_contacto->execute()){

    // buscamos el id del contacto que registramos
    $sql_buscar = $pdo->prepare("SELECT * FROM tb_contactos WHERE celular=$celular AND id_usuario_fk=$id_usuario_fk ORDER BY id_contacto DESC
    LIMIT 1");

    $sql_buscar->execute();

    $arreglo = $sql_buscar->fetch(PDO::FETCH_ASSOC);

    // echo "<pre>";
    // print_r($arreglo);
    // echo "</pre>";

    $id_ultimo_contacto=$arreglo['id_contacto'];



    $sql = $pdo->prepare('INSERT INTO tb_clientes (
    nombres, apellidos, tipo_urbanizacion, reprogramar, detalle_llamada, detalle, fecha_registro, fecha_llamada, hora_llamada, created_at, updated_at, estado, id_usuario_fk, id_contacto_fk )VALUES (
    :nombres, :apellidos, :tipo_urbanizacion, :reprogramar, :detalle_llamada, :detalle, :fecha_registro, :fecha_llamada, :hora_llamada, :created_at, :updated_at, :estado, :id_usuario_fk, :id_contacto_fk )');
    
    
    $sql->bindParam(':nombres',$nombre);
    $sql->bindParam(':apellidos',$apellidos);
    $sql->bindParam(':tipo_urbanizacion',$tipo_urbanizacion);
    $sql->bindParam(':reprogramar',$reprogramar);
    $sql->bindParam(':detalle_llamada',$detalle_llamada);
    $sql->bindParam(':detalle',$detalle_unido);
    $sql->bindParam(':fecha_registro',$fecha_registro);
    $sql->bindParam(':fecha_llamada',$fecha_llamada);
    $sql->bindParam(':hora_llamada',$hora_llamada);
    $sql->bindParam(':created_at',$fechayhora);
    $sql->bindParam(':updated_at',$fechayhora);
    $sql->bindParam(':estado',$estado);
    $sql->bindParam(':fecha_llamada',$fecha_llamada);
    $sql->bindParam(':hora_llamada',$hora_llamada);
    $sql->bindParam(':id_usuario_fk',$id_usuario_fk);
    $sql->bindParam(':id_contacto_fk',$id_ultimo_contacto);
    
    if ($sql->execute()) {   
    
        header('location:'.$URL.'/admin/clientes/reprogramar.php');
    }
}


 


   




    




?>