<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

// ID DEL USUARIO
$id_usuario_importacion = $id_usuario;

// DATOS
$nombre =$_POST['nombre'];
$celular =$_POST['celular'];
$email =$_POST['email'];
$producto =$_POST['producto'];
$direccion =$_POST['direccion'];
$obs_contacto =$_POST['obs_contacto'];
$fecha_registro=$_POST['fecha_registro'];


// PREGUNTAS
$respuesta_si_no =$_POST['respuesta_si_no'];
$tipo =$_POST['tipo'];
$monto =$_POST['monto'];

$tipo_dinero =$_POST['tipo_dinero'];

$tiempo =$_POST['tiempo'];
$fecha =$_POST['fecha'];
$mercaderia =$_POST['mercaderia'];
$requerimientos =$_POST['requerimientos'];
$volumen =$_POST['volumen'];
$tipo_volumen =$_POST['tipo_volumen'];
$objetivo =$_POST['objetivo'];
$presupuesto =$_POST['presupuesto'];
$aspectos =$_POST['aspectos'];
$proveedor =$_POST['proveedor'];
$adpecto_asesor =$_POST['adpecto_asesor'];
$obs_formulario =$_POST['obs_formulario'];


$sql = $pdo->prepare('INSERT INTO tb_clientes_importacion (
nombre_completo,
celular,
email,
producto,
obs_contacto,
fecha_registro_imp,
direccion,
id_usuario_fk,
pregunta_1,
pregunta_2,
pregunta_3,
pregunta_3_1,
pregunta_3_2,
pregunta_4,
pregunta_5,
pregunta_6,
pregunta_7,
pregunta_7_1,
pregunta_8,
pregunta_9,
pregunta_10,
pregunta_11,
pregunta_12,
pregunta_13
) VALUES (
:nombre_completo,
:celular,
:email,
:producto,
:obs_contacto,
:fecha_registro_imp,
:direccion,
:id_usuario_fk,
:pregunta_1,
:pregunta_2,
:pregunta_3,
:pregunta_3_1,
:pregunta_3_2,
:pregunta_4,
:pregunta_5,
:pregunta_6,
:pregunta_7,
:pregunta_7_1,
:pregunta_8,
:pregunta_9,
:pregunta_10,
:pregunta_11,
:pregunta_12,
:pregunta_13
)');


    $sql->bindParam(':nombre_completo',$nombre);
    $sql->bindParam(':celular',$celular);
    $sql->bindParam(':email',$email);
    $sql->bindParam(':producto',$producto);
    $sql->bindParam(':obs_contacto',$obs_contacto);
    $sql->bindParam(':fecha_registro_imp',$fecha_registro);
    $sql->bindParam(':direccion',$direccion);
    $sql->bindParam(':id_usuario_fk',$id_usuario_importacion);
    $sql->bindParam(':pregunta_1',$respuesta_si_no);
    $sql->bindParam(':pregunta_2',$tipo);
    $sql->bindParam(':pregunta_3',$monto);
    $sql->bindParam(':pregunta_3_1',$tipo_dinero);
    $sql->bindParam(':pregunta_3_2',$tiempo);
    $sql->bindParam(':pregunta_4',$fecha);
    $sql->bindParam(':pregunta_5',$mercaderia);
    $sql->bindParam(':pregunta_6',$requerimientos);
    $sql->bindParam(':pregunta_7',$volumen);
    $sql->bindParam(':pregunta_7_1',$tipo_volumen);
    $sql->bindParam(':pregunta_8',$objetivo);
    $sql->bindParam(':pregunta_9',$presupuesto);
    $sql->bindParam(':pregunta_10',$aspectos);
    $sql->bindParam(':pregunta_11',$proveedor);
    $sql->bindParam(':pregunta_12',$adpecto_asesor);
    $sql->bindParam(':pregunta_13',$obs_formulario);

if ($sql->execute()) {
       

} else {
   
}


?>