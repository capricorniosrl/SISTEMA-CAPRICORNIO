<?php

include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

$celular = $_REQUEST['celular'];

// Preparamos un arreglo que es el que contendrá toda la información
$jsonData = array();

try {
    // Preparar la consulta
    $selectQuery = $pdo->prepare("SELECT celular, id_usuario_fk FROM tb_contactos WHERE celular = :celular");
    $selectQuery->bindParam(':celular', $celular, PDO::PARAM_STR);

    // Ejecutar la consulta
    $selectQuery->execute();

    // Obtener el número de filas
    $totalCliente = $selectQuery->rowCount();
        // Validamos que la consulta haya retornado información
        if ($totalCliente <= 0) {
            $jsonData['success'] = 0;
            $jsonData['message'] = '';
        } else {
            // Si hay datos entonces retornas algo
            $result = $selectQuery->fetch(PDO::FETCH_ASSOC);
            $id_usuario_fk = $result['id_usuario_fk'];

            // Obtener información del usuario
            $usuarioQuery = $pdo->prepare("SELECT nombre, ap_paterno, ap_materno FROM tb_usuarios WHERE id_usuario = :id_usuario");
            $usuarioQuery->bindParam(':id_usuario', $id_usuario_fk, PDO::PARAM_INT);
            $usuarioQuery->execute();
            $usuario = $usuarioQuery->fetch(PDO::FETCH_ASSOC);

            $nombreCompleto = $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

            $jsonData['success'] = 1;
            $jsonData['message'] = '<p style="color:#17a2b8;">Ya existe el celular <strong>(' . $celular . ')</strong> Fue registrado por <strong>' . $nombreCompleto .  '</strong> desea Registrar el contacto</p>';

            $jsonData['message_nombre']= $usuario['nombre'];
            $jsonData['message_apellidos']= $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'];

            $jsonData['message_celular']= $celular;
        }
} catch (PDOException $e) {
    $jsonData['success'] = 0;
    $jsonData['message'] = 'Error: ' . $e->getMessage();
}

// Mostrando mi respuesta en formato Json
header('Content-type: application/json; charset=utf-8');
echo json_encode($jsonData);

?>