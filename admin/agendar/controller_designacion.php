<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");

$error = "";

$id_usuario_fk = $_POST['usuario_designado']; //id del usuario a asignar

$id_agenda_fk = $_POST['id_agenda'];  //id de la agendacion actual

$id_cliente_fk = $_POST['id_cliente_fk']; //id del cliente al cual queremos designar

$id_usuario_fk_creador = $_POST['id_usuario_fk_creador']; // id del usuario quien primero registro 

if ($error == "") {



    $query_agenda = $pdo->prepare("SELECT * FROM tb_agendas ag INNER JOIN tb_usuarios us WHERE ag.id_agenda=$id_agenda_fk AND ag.id_usuario_fk=us.id_usuario");
    $query_agenda->execute();
    $usuarios = $query_agenda->fetchAll(PDO::FETCH_ASSOC);
    foreach ($usuarios as $usuario) {
        $fecha_visita = $usuario['fecha_visita'];
        $visitantes = $usuario['visitantes'];
        $estado = $usuario['estado'];
        $asistio = $usuario['asistio'];
        $designado_por = "DESIGNADO POR EL ASESOR: " . $usuario['nombre'] . " " . $usuario['ap_paterno'] . " " . $usuario['ap_materno'];
    }


    $sql = $pdo->prepare('INSERT INTO tb_agendas (fecha_visita, visitantes, estado, asistio, detalle_agenda, created_at, updated_at, id_usuario_fk, id_cliente_fk) VALUES (:fecha_visita, :visitantes, :estado, :asistio, :detalle_agenda, :created_at, :updated_at, :id_usuario_fk, :id_cliente_fk)');

    $sql->bindParam(':fecha_visita', $fecha_visita);
    $sql->bindParam(':visitantes', $visitantes);
    $sql->bindParam(':estado', $estado);
    $sql->bindParam(':asistio', $asistio);
    $sql->bindParam(':detalle_agenda', $designado_por);
    $sql->bindParam(':created_at', $fechayhora);
    $sql->bindParam(':updated_at', $fechayhora);
    $sql->bindParam(':id_usuario_fk', $id_usuario_fk);
    $sql->bindParam(':id_cliente_fk', $id_cliente_fk);

    if ($sql->execute()) {

        $sentencia = $pdo->prepare("SELECT id_agenda FROM tb_agendas ag INNER JOIN tb_usuarios us INNER JOIN tb_clientes cli WHERE ag.id_usuario_fk = $id_usuario_fk AND ag.id_cliente_fk = cli.id_cliente GROUP BY ag.id_agenda");

        $sentencia->execute();

        $id_agenda = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        foreach ($id_agenda as $usuario) {
            $id_agenda = $usuario['id_agenda'];
        }


        $sql_1 = $pdo->prepare('INSERT INTO tb_designacion (id_agenda_fk, id_usuario_fk) VALUES (:id_agenda_fk, :id_usuario_fk)');

        $sql_1->bindParam(':id_agenda_fk', $id_agenda);
        $sql_1->bindParam(':id_usuario_fk', $id_usuario_fk);

        if ($sql_1->execute()) {

            $query_usuario = $pdo->prepare("SELECT * FROM tb_usuarios WHERE id_usuario=$id_usuario_fk");
            $query_usuario->execute();
            $usu = $query_usuario->fetchAll(PDO::FETCH_ASSOC);
            foreach ($usu as $usuario_user) {
                $designado_por = "SE DESIGNO AL ASESOR: " . $usuario_user['nombre'] . " " . $usuario_user['ap_paterno'] . " " . $usuario_user['ap_materno'];
            }



            $sql_actualizar = $pdo->prepare("UPDATE tb_agendas SET detalle_agenda=:detalle_agenda WHERE id_agenda=:id_agenda");

            $sql_actualizar->bindParam(':detalle_agenda', $designado_por);
            $sql_actualizar->bindParam(':id_agenda', $id_agenda_fk);

            $sql_actualizar->execute();


            echo "exito";
        } else {
            echo $error;
        }
    } else {
        echo $error;
    }
} else {
    echo $error;
}
