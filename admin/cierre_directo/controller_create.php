<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');


$error = "";

if (empty($_POST['nombre'])) {
    $error .= "• FALTA INGRESAR EL NOMBRE" . "<br>";
} else {
    // Eliminar espacios en blanco al principio y al final
    $nombre = trim($_POST['nombre']);

    // Verificar que no esté vacío después de eliminar espacios
    if (empty($nombre)) {
        $error .= "• FALTA INGRESAR EL NOMBRE" . "<br>";
    } else {
        // Verificar que no empiece con un espacio ni con un número
        if (preg_match("/^[0-9\s]/", $nombre)) {
            $error .= "• EL NOMBRE NO PUEDE EMPEZAR NI TERNER NÚMEROS" . "<br>";
        }
    }
}



if (empty($_POST['paterno'])) {

    $error .= "• FALTA INGRESAR EL APELLIDO PATERNO" . "<br>";
} else {
    // Eliminar espacios en blanco al principio y al final
    $paterno = trim($_POST['paterno']);

    // Verificar que no esté vacío después de eliminar espacios
    if (empty($paterno)) {
        $error .= "• FALTA INGRESAR EL APELLIDO PATERNO" . "<br>";
    } else {
        // Verificar que no empiece con un espacio ni con un número
        if (preg_match("/^[0-9\s]/", $paterno)) {
            $error .= "• EL APELLIDO PATERNO NO PUEDE EMPEZAR NI TERNER NÚMEROS" . "<br>";
        } elseif (!preg_match("/^[a-zA-Z]+$/", $paterno)) {
            $error .= "• SÓLO SE PERMITEN LETRAS COMO APELLIDO PATERNO DEL CLIENTE" . "<br>";
        }
    }
}


if (empty($_POST['materno'])) {

    $error .= "• FALTA INGRESAR EL APELLIDO MATERNO" . "<br>";
} else {
    // Eliminar espacios en blanco al principio y al final
    $materno = trim($_POST['materno']);

    // Verificar que no esté vacío después de eliminar espacios
    if (empty($materno)) {
        $error .= "• FALTA INGRESAR EL APELLIDO MATERNO" . "<br>";
    } else {
        // Verificar que no empiece con un espacio ni con un número
        if (preg_match("/^[0-9\s]/", $materno)) {
            $error .= "• EL APELLIDO MATERNO NO PUEDE EMPEZAR NI TERNER NÚMEROS" . "<br>";
        } elseif (!preg_match("/^[a-zA-Z]+$/", $materno)) {
            $error .= "• SÓLO SE PERMITEN LETRAS COMO APELLIDO MATERNO DEL CLIENTE" . "<br>";
        }
    }
}

if (empty($_POST['celular'])) {

    $error .= "• FALTA INGRESAR EL NUMERO DE CELULAR" . "<br>";
} else {
    $celular = $_POST['celular'];
    $celular = filter_var($celular, FILTER_SANITIZE_STRING);
    $celular = trim($celular);
    if ($celular == "") {
        $error .= "• EL NÚMERO DE CELULAR ESTÁ VACÍO, INGRESE UN NÚMERO VÁLIDO <br>";
    } else {
        if (!preg_match("/^[0-9]{8}$/", $celular)) {
            $error .= "• INGRESE UN NÚMERO DE CELULAR VÁLIDO de (8 dígitos) <br>";
        }
    }
}

if (empty($_POST['lote'])) {

    $error .= "• FALTA INGRESAR EL NUMERO DEL LOTE" . "<br>";
}

if (empty($_POST['manzano'])) {

    $error .= "• FALTA INGRESAR EL NUMERO DEL MANZANO" . "<br>";
}

if (empty($_POST['superficie'])) {

    $error .= "• FALTA INGRESAR LA SUPERFICIE" . "<br>";
}

if (empty($_POST['plan'])) {

    $error .= "• DEBE SELECCIONAR UN PLAN DE PAGO <b>CONTADO - SEMI CONTADO - CREDITO</b> " . "<br>";
}


if ($error == "") {
    // registrar contacto

    $celular = $_POST['celular'];
    $estado = 0;
    $detalle_agenda = "NO";
    $detalle = "SIN DETALLES";

    $sql_contacto = $pdo->prepare('INSERT INTO tb_contactos (celular, created_at, updated_at,detalle ,estado,detalle_agenda, id_usuario_fk) VALUES (:celular, :created_at, :updated_at, :detalle, :estado, :detalle_agenda, :id_usuario_fk)');

    $sql_contacto->bindParam(':celular', $celular);
    $sql_contacto->bindParam(':created_at', $fechayhora);
    $sql_contacto->bindParam(':updated_at', $fechayhora);
    $sql_contacto->bindParam(':detalle', $detalle);
    $sql_contacto->bindParam(':estado', $estado);
    $sql_contacto->bindParam(':detalle_agenda', $detalle_agenda);
    $sql_contacto->bindParam(':id_usuario_fk', $id_usuario);
    $sql_contacto->execute();



    // buscar datos del cotacto
    $sql_buscar_contacto = $pdo->prepare("SELECT * FROM tb_contactos WHERE celular='$celular' AND id_usuario_fk='$id_usuario' ORDER BY id_contacto DESC
    LIMIT 1");
    $sql_buscar_contacto->execute();
    $datos_contacto = $sql_buscar_contacto->fetch(PDO::FETCH_ASSOC);

    $id_contacto_busqueda = $datos_contacto['id_contacto'];
    $id_usuario_fk_busqueda = $datos_contacto['id_usuario_fk'];


    // registrara cliente

    $sql_clientes = $pdo->prepare('INSERT INTO tb_clientes (nombres,apellidos, ci_cliente,exp_cliente,tipo_urbanizacion,reprogramar,detalle,fecha_registro,created_at,updated_at,estado,id_usuario_fk,id_contacto_fk)VALUES (:nombres,:apellidos,:ci_cliente,:exp_cliente,:tipo_urbanizacion,:reprogramar,:detalle,:fecha_registro,:created_at,:updated_at,:estado,:id_usuario_fk,:id_contacto_fk)');

    $nombre = $_POST['nombre'];
    $paterno = $_POST['paterno'];
    $materno = $_POST['materno'];

    $ci = $_POST['ci'];
    $exp = $_POST['exp'];

    $apellidos = $paterno . " " . $materno;
    $urbanizacion = $_POST['urbanizacion'];
    $fecha_registro = $_POST['fecha_registro'];
    $reprogramar = "NO";
    $estado_cliente = 1;

    $sql_clientes->bindParam(':nombres', $nombre);
    $sql_clientes->bindParam(':apellidos', $apellidos);

    $sql_clientes->bindParam(':ci_cliente', $ci);
    $sql_clientes->bindParam(':exp_cliente', $exp);

    $sql_clientes->bindParam(':tipo_urbanizacion', $urbanizacion);
    $sql_clientes->bindParam(':reprogramar', $reprogramar);
    $sql_clientes->bindParam(':detalle', $detalle);
    $sql_clientes->bindParam(':fecha_registro', $fecha_registro);
    $sql_clientes->bindParam(':created_at', $fechayhora);
    $sql_clientes->bindParam(':updated_at', $fechayhora);
    $sql_clientes->bindParam(':estado', $estado_cliente);
    $sql_clientes->bindParam(':id_usuario_fk', $id_usuario_fk_busqueda);
    $sql_clientes->bindParam(':id_contacto_fk', $id_contacto_busqueda);

    $sql_clientes->execute();
    // buscar el id del cliente
    $sql_buscar_id_cliente = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_contacto_fk='$id_contacto_busqueda' ORDER BY id_cliente DESC LIMIT 1");
    $sql_buscar_id_cliente->execute();

    $datos_id_cliente = $sql_buscar_id_cliente->fetch(PDO::FETCH_ASSOC);
    $id_cliente_buscar = $datos_id_cliente['id_cliente'];



    // AGENDAR CLIENTE

    $estado = 1;
    $sentencia = $pdo->prepare('INSERT INTO tb_agendas (estado,id_usuario_fk, id_cliente_fk) VALUE (:estado,:id_usuario_fk, :id_cliente_fk)');
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':id_usuario_fk', $id_usuario_fk_busqueda);
    $sentencia->bindParam(':id_cliente_fk', $id_cliente_buscar);
    $sentencia->execute();


    // busqueda id de agenda
    $sql_buscar_id_agenda = $pdo->prepare("SELECT * FROM tb_agendas WHERE id_cliente_fk='$id_cliente_buscar' AND id_usuario_fk='$id_usuario_fk_busqueda' ORDER BY id_agenda DESC LIMIT 1");
    $sql_buscar_id_agenda->execute();
    $id_agenda = $sql_buscar_id_agenda->fetch(PDO::FETCH_ASSOC);

    $id_agenda_fk = $id_agenda['id_agenda'];


    // Insertar tabla informe

    $precio_acordado = $_POST['precio_acordado'];
    $precio_acordado_literal = $_POST['precio_acordado_literal'];


    $lote = $_POST['lote'];
    $manzano = $_POST['manzano'];
    $superficie = $_POST['superficie'];
    $monto = 0;
    $tipo_cliente = 'OFICINA';
    $compra_directo = "SI";

    $sql_informe = $pdo->prepare('INSERT INTO tb_informe (id_agenda_fk,fecha_registro,precio_acordado,precio_acordado_literal,lote,manzano,superficie,monto,tipo_cliente,compra_directo)VALUES (:id_agenda_fk,:fecha_registro,:precio_acordado,:precio_acordado_literal,:lote,:manzano,:superficie,:monto,:tipo_cliente,:compra_directo)');

    $sql_informe->bindParam(':id_agenda_fk', $id_agenda_fk);
    $sql_informe->bindParam(':fecha_registro', $fecha_registro);

    $sql_informe->bindParam(':precio_acordado', $precio_acordado);
    $sql_informe->bindParam(':precio_acordado_literal', $precio_acordado_literal);


    $sql_informe->bindParam(':lote', $lote);
    $sql_informe->bindParam(':manzano', $manzano);
    $sql_informe->bindParam(':superficie', $superficie);
    $sql_informe->bindParam(':monto', $monto);
    $sql_informe->bindParam(':tipo_cliente', $tipo_cliente);
    $sql_informe->bindParam(':compra_directo', $compra_directo);


    if ($sql_informe->execute()) {
        // busqueda id de informe
        $sql_buscar_id_informe = $pdo->prepare("SELECT * FROM tb_informe WHERE id_agenda_fk='$id_agenda_fk' ORDER BY id_informe DESC LIMIT 1");

        $sql_buscar_id_informe->execute();

        $id_informe = $sql_buscar_id_informe->fetch(PDO::FETCH_ASSOC);

        $id_informe_buscar = $id_informe['id_informe'];

        $plan = $_POST['plan'];

        echo json_encode([
            'plan' => $plan,
            'id_informe' => $id_informe_buscar
        ]);
    }
} else {
    echo json_encode([
        'error' => $error
    ]);
}
