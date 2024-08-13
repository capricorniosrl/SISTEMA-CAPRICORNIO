<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

echo "ID_CONTACTO: ".$id_contacto = $_POST['id_contacto']."<br>";
echo "ID_USUARIO: ".$id_usuario = $_POST['id_usuario'];


var_dump($query_login = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_usuario_fk='$id_usuario' AND id_contacto_fk='$id_contacto'"))."<br>";

$query_login->execute();

$usuarios = $query_login->fetchAll(PDO::FETCH_ASSOC);
$contador=0;
foreach ($usuarios as $usuario) {
    $contador=$contador+1;
          
}

if ($contador==0) {

    // echo "NO EXISTE EL REGISTRO";
} else {
    $reprogramar="SI";
    $detalle_llamada= "CONTESTO";
    $nombre=$_POST["nombre"];
    $apellido=$_POST["apellido"];
    $fecha_llamada=$_POST["fecha_llamada"];
    $hora_llamada=$_POST["hora_llamada"];
    $detalle=$_POST["detalle"];

    var_dump($sentencia = $pdo->prepare("UPDATE tb_clientes SET nombres='$nombre', apellidos='$apellido', reprogramar='$reprogramar', detalle_llamada='$detalle_llamada', fecha_llamada='$fecha_llamada', hora_llamada='$hora_llamada', detalle='$detalle' WHERE id_usuario_fk='$id_usuario' AND id_contacto_fk='$id_contacto'"));



    if ($sentencia->execute()) {

        header('location:'.$URL.'/admin/clientes/sin_responder.php');
    }  

}


?>