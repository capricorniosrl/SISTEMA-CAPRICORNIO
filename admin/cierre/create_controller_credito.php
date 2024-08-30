<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');

include('../../layout/admin/datos_session_user.php');

$error = "";
$id_informe = $_POST['id_informe'];

// DATOS COMPRADOR
$nombre_1 = $_POST['nombre_1'];
$ap_paterno_1 = $_POST['ap_paterno_1'];
$ap_materno_1 = $_POST['ap_materno_1'];
$ci_1 = $_POST['ci_1'];
$exp_1 = $_POST['exp_1'];
$celular_1 = $_POST['celular_1'];


$nombre_2 = $_POST['nombre_2'];
$ap_paterno_2 = $_POST['ap_paterno_2'];
$ap_materno_2 = $_POST['ap_materno_2'];
$ci_2 = $_POST['ci_2'];
$exp_2 = $_POST['exp_2'];
$celular_2 = $_POST['celular_2'];

// // DATOS SEMICONTADO
$precio_dolares = $_POST['precio_dolares'];
$tipo_cambio = $_POST['tipo_cambio'];
$precio_Bolivianos = $_POST['numero'];
$moneda = $_POST['moneda'];
$literal_general = $_POST['monto_general'];
$literal = $_POST['literal'];
$concepto = $_POST['concepto'];

// // DATOS DE KLA URBANIZACION
$urbanizacion = $_POST['urbanizacion'];
$lote = $_POST['lote'];
$manzano = $_POST['manzano'];
$superficie = $_POST['superficie'];

$fecha_registro = $_POST['fecha_registro'];
$cuota_inicial = $_POST['cuota_inicial'];


$numero_recibo_inicial = $_POST['numero_recibo'];

$num_cuotas = $_POST['cantidadCuotas'];

$interes = $_POST['interes'];

$cuota_inicial_literal = $_POST['cuota_inicial_literal'];

if (empty($_POST['ap_paterno_1'])) {

    $error .= "• FALTA INGRESAR ALMENOS UN APELLIDO 1" . "<br>";
}

if (empty($_POST['ap_materno_1'])) {

    $error .= "• FALTA INGRESAR ALMENOS UN APELLIDO 2" . "<br>";
}

if (empty($_POST['ci_1'])) {

    $error .= "• FALTA INGRESAR SU CI" . "<br>";
}

if (empty($_POST['exp_1'])) {

    $error .= "• FALTA INGRESAR SU EXP" . "<br>";
}
if (empty($_POST['precio_dolares'])) {

    $error .= "• FALTA INGRESAR EL PRECIO GENERAL" . "<br>";
}
if (empty($_POST['tipo_cambio'])) {

    $error .= "• FALTA INGRESAR EL TIPO DE CAMBIO" . "<br>";
}
if (empty($_POST['cuota_inicial'])) {

    $error .= "• FALTA INGRESAR SU CUOTA INICIAL" . "<br>";
}
if (empty($_POST['numero_recibo'])) {

    $error .= "• FALTA INGRESAR EL NUMERO RE RECIBO" . "<br>";
}

if (empty($_POST['cantidadCuotas'])) {
    $error .= "• FALTA INGRESAR EL NUMERO DE CUOTAS" . "<br>";
}

if (empty($_POST['interes'])) {
    $error .= "• FALTA INGRESAR EL MONTO DE INTERES" . "<br>";
}




if ($error == "") {

    $sql = $pdo->prepare("INSERT INTO tb_comprador ( nombre_1, ap_paterno_1, ap_materno_1, ci_1, exp_1, celular_1, nombre_2, ap_paterno_2, ap_materno_2, ci_2, exp_2, celular_2, id_usuario_fk ) VALUES ( :nombre_1, :ap_paterno_1, :ap_materno_1, :ci_1, :exp_1, :celular_1, :nombre_2, :ap_paterno_2, :ap_materno_2, :ci_2, :exp_2, :celular_2, :id_usuario_fk )");

    $sql->bindParam(':nombre_1', $nombre_1);
    $sql->bindParam(':ap_paterno_1', $ap_paterno_1);
    $sql->bindParam(':ap_materno_1', $ap_materno_1);
    $sql->bindParam(':ci_1', $ci_1);
    $sql->bindParam(':exp_1', $exp_1);
    $sql->bindParam(':celular_1', $celular_1);

    $sql->bindParam(':nombre_2', $nombre_2);
    $sql->bindParam(':ap_paterno_2', $ap_paterno_2);
    $sql->bindParam(':ap_materno_2', $ap_materno_2);
    $sql->bindParam(':ci_2', $ci_2);
    $sql->bindParam(':exp_2', $exp_2);
    $sql->bindParam(':celular_2', $celular_2);

    $sql->bindParam(':id_usuario_fk', $id_usuario);

    if ($sql->execute()) {


        $sql_1 = $pdo->prepare("SELECT * FROM tb_comprador WHERE ci_1='$ci_1' ORDER by id_comprador DESC LIMIT 1");
        $sql_1->execute();
        $dato_id = $sql_1->fetch(PDO::FETCH_ASSOC);
        $ID = $dato_id['id_comprador'];



        $sql_2 = $pdo->prepare("INSERT INTO tb_credito (monto_dolar,tipo_cambio,monto_bolivianos,tipo_moneda,literal_general,literal,concepto,urbanizacion,lote,manzano,superficie,fecha_registro,cuota_inicial,cuota_inicial_literal,cuota_interes, num_recibo_inicial,created_at,updated_at,id_comprador_fk) VALUES (:monto_dolar,:tipo_cambio,:monto_bolivianos,:tipo_moneda,:literal_general,:literal,:concepto,:urbanizacion,:lote,:manzano,:superficie,:fecha_registro,:cuota_inicial,:cuota_inicial_literal,:cuota_interes,:num_recibo_inicial,:created_at,:updated_at,:id_comprador_fk
    )");

        $sql_2->bindParam(':monto_dolar', $precio_dolares);
        $sql_2->bindParam(':tipo_cambio', $tipo_cambio);
        $sql_2->bindParam(':monto_bolivianos', $precio_Bolivianos);
        $sql_2->bindParam(':tipo_moneda', $moneda);
        $sql_2->bindParam(':literal_general', $literal_general);
        $sql_2->bindParam(':literal', $literal);
        $sql_2->bindParam(':concepto', $concepto);
        $sql_2->bindParam(':urbanizacion', $urbanizacion);
        $sql_2->bindParam(':lote', $lote);
        $sql_2->bindParam(':manzano', $manzano);
        $sql_2->bindParam(':superficie', $superficie);
        $sql_2->bindParam(':fecha_registro', $fecha_registro);
        $sql_2->bindParam(':cuota_inicial', $cuota_inicial);
        $sql_2->bindParam(':cuota_inicial_literal', $cuota_inicial_literal);
        $sql_2->bindParam(':cuota_interes', $interes);
        $sql_2->bindParam(':num_recibo_inicial', $numero_recibo_inicial);
        $sql_2->bindParam(':created_at', $fechayhora);
        $sql_2->bindParam(':updated_at', $fechayhora);
        $sql_2->bindParam(':id_comprador_fk', $ID);

        if ($sql_2->execute()) {


            $sql_3 = $pdo->prepare("SELECT id_credito FROM tb_credito WHERE num_recibo_inicial='$numero_recibo_inicial' LIMIT 1");
            $sql_3->execute();
            $datos_semicontado = $sql_3->fetch(PDO::FETCH_ASSOC);

            $datos_semic = $datos_semicontado['id_credito'];

            $cuotas = $_POST['cuotas'];




            $fecha_act = $_POST['fecha_registro'];

            $mes = 1;



            foreach ($cuotas as $dato) {



                $timestamp = strtotime($fecha_act);
                $timestamp_nueva = strtotime("+$mes months", $timestamp);
                $fecha_nueva = date('Y-m-d', $timestamp_nueva);


                // Preparar e insertar en la base de datos
                $sq4 = $pdo->prepare("INSERT INTO tb_cuotas_credito (id_credito_fk, nombre_cuota, fecha_pago) VALUES (:id_credito_fk, :nombre_cuota, :fecha_pago)");
                $sq4->bindParam(':id_credito_fk', $datos_semic);
                $sq4->bindParam(':nombre_cuota', $dato);
                $sq4->bindParam(':fecha_pago', $fecha_nueva);
                $sq4->execute();
                $mes++;
            }



            $sql_4 = $pdo->prepare("UPDATE tb_informe SET estado_cierre='3' WHERE id_informe='$id_informe'");
            $sql_4->execute();

            echo "exito";

            // header('Location:'. $URL.'/admin/reserva/index.php');
            // exit();
        }
    }
} else {
    echo $error;
}
