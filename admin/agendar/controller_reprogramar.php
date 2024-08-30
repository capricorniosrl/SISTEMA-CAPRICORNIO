<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

$id_cliente = $_POST["id_cliente"];
$celular = $_POST["celular"];




$sql_contacto = $pdo->prepare('INSERT INTO tb_contactos (celular, created_at, updated_at,detalle ,estado,detalle_agenda, id_usuario_fk) VALUES (:celular, :created_at, :updated_at, :detalle, :estado, :detalle_agenda, :id_usuario_fk)');

$detalle = "SIN DETALLES";
$detalle_agenda = "NO";

$sql_contacto->bindParam(':celular', $celular);
$sql_contacto->bindParam(':created_at', $fechayhora);
$sql_contacto->bindParam(':updated_at', $fechayhora);
$sql_contacto->bindParam(':detalle', $detalle);
$sql_contacto->bindParam(':estado', $estado);
$sql_contacto->bindParam(':detalle_agenda', $detalle_agenda);
$sql_contacto->bindParam(':id_usuario_fk', $id_usuario);

if ($sql_contacto->execute()) {
    // buscar datos del cotacto
    $sql_buscar_contacto = $pdo->prepare("SELECT * FROM tb_contactos WHERE celular='$celular' AND id_usuario_fk='$id_usuario' ORDER BY id_contacto DESC
      LIMIT 1");
    $sql_buscar_contacto->execute();
    $datos_contacto = $sql_buscar_contacto->fetch(PDO::FETCH_ASSOC);

    $id_contacto_busqueda = $datos_contacto['id_contacto'];


    // buscar datos del cliente
    $sql_buscar_cliente = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_cliente='$id_cliente' ORDER BY id_cliente DESC LIMIT 1");
    $sql_buscar_cliente->execute();
    $datos_cliente = $sql_buscar_cliente->fetch(PDO::FETCH_ASSOC);


    $nombre = $datos_cliente['nombres'];
    $apellidos = $datos_cliente['apellidos'];
    $ci_cliente = $datos_cliente['ci_cliente'];
    $exp_cliente = $datos_cliente['exp_cliente'];
    $tipo_urbanizacion = $datos_cliente['tipo_urbanizacion'];
    $reprogramar = "SI";
    $detalle_llamada = "CONTESTO";
    $detalle = "REPROGRAMAR LLAMADA";
    $fecha_registro = $_POST['fecha_registro'];
    $fecha_llamada = $_POST["fecha"];
    $hora_llamada = $_POST["hora"];
    $estado = 1;


    $sql_clientes = $pdo->prepare('INSERT INTO tb_clientes (
    nombres,
    apellidos,
    ci_cliente,
    exp_cliente,
    tipo_urbanizacion,
    reprogramar,
    detalle_llamada,
    detalle,
    fecha_registro,
    fecha_llamada,
    hora_llamada,
    created_at,
    updated_at,
    estado,
    id_usuario_fk,
    id_contacto_fk
    )VALUES (
    :nombres,
    :apellidos,
    :ci_cliente,
    :exp_cliente,
    :tipo_urbanizacion,
    :reprogramar,
    :detalle_llamada,
    :detalle,
    :fecha_registro,
    :fecha_llamada,
    :hora_llamada,
    :created_at,
    :updated_at,
    :estado,
    :id_usuario_fk,
    :id_contacto_fk
    )');

    $sql_clientes->bindParam(':nombres', $nombre);
    $sql_clientes->bindParam(':apellidos', $apellidos);
    $sql_clientes->bindParam(':ci_cliente', $ci_cliente);
    $sql_clientes->bindParam(':exp_cliente', $exp_cliente);
    $sql_clientes->bindParam(':tipo_urbanizacion', $tipo_urbanizacion);
    $sql_clientes->bindParam(':reprogramar', $reprogramar);
    $sql_clientes->bindParam(':detalle_llamada', $detalle_llamada);
    $sql_clientes->bindParam(':detalle', $detalle);
    $sql_clientes->bindParam(':fecha_registro', $fecha_registro);
    $sql_clientes->bindParam(':fecha_llamada', $fecha_llamada);
    $sql_clientes->bindParam(':hora_llamada', $hora_llamada);
    $sql_clientes->bindParam(':created_at', $fechayhora);
    $sql_clientes->bindParam(':updated_at', $fechayhora);
    $sql_clientes->bindParam(':estado', $estado);
    $sql_clientes->bindParam(':id_usuario_fk', $id_usuario);
    $sql_clientes->bindParam(':id_contacto_fk', $id_contacto_busqueda);

    if ($sql_clientes->execute()) {

        header('location:' . $URL . '/admin/clientes/reprogramar.php');
    }
}
