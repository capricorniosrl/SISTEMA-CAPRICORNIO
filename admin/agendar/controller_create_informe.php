<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");


$error = "";

$fecha_registro = $_POST["fecha_registro"];

// Convertir la fecha de registro en un objeto DateTime
$date = new DateTime($fecha_registro);

// Sumar 3 días a la fecha de registro
$date->modify('+3 days');

// Obtener la fecha de cierre en formato 'Y-m-d'
$fecha_cierre = $date->format('Y-m-d');



$tipo_cliente = strtoupper($_POST["tipo_cliente"]); //OFICINA - PROPIO
$detalle_of_pro = $_POST["detalle"];
$tipoPago = $_POST["tipoPago"];
$monto = $_POST["monto"];
$numeroRecibo = $_POST["numeroRecibo"];
$numeroTransferencia = $_POST["numeroTransferencia"];
$resumen = $_POST["resumen"];
$siguiente = $_POST["siguiente"];
$id_agenda = $_POST["id_agenda"];

$lote = $_POST["lote"];
$manzano = $_POST["manzano"];
$superficie = $_POST["superficie"];



$literal_monto = $_POST['monto_literal'];
$concepto = $_POST['concepto'];
$precio_acordado = $_POST['precio_acordado'];
$tipo_cambio = $_POST['tipo_cambio'];
$plan = $_POST['plan'];

$fecha_limite = $_POST['fecha_limite'];
$observacion = $_POST['observacion'];

$precio_acordado_literal = $_POST['precio_acordado_literal'];


if (isset($_POST['existe_pago'])) {
    // El checkbox está marcado
    // $checkbox_value = $_POST['my_checkbox'];
    // $error .= "El checkbox está marcado" . "<br>";
    if (empty($_POST['ci_cliente'])) {

        $error .= "• FALTA LLEGAR EL CARNET DE IDENTIDAD" . "<br>";
    }
    if (empty($_POST['exp_cliente'])) {

        $error .= "• FALTA LLENAR LA EXPEDICION DE SU CARNET" . "<br>";
    }
    if (empty($_POST['tipoPago'])) {

        $error .= "• DEBE SELECCIONAR UN MEDIO DE PAGO" . "<br>";
    }
    if (empty($_POST['monto'])) {

        $error .= "• FALTA INGRESAR EL MONTO DE RESERVA" . "<br>";
    }
    if (empty($_POST['numeroRecibo']) && empty($_POST['numeroTransferencia'])) {

        $error .= "• FALTA INGRESAR EL NUMERO DE RECIBO O TRANSFERENCIA" . "<br>";
    }
    if (empty($_POST['precio_acordado'])) {

        $error .= "• FALTA INGRESAR EL PRECIO ACORDADO DEL TERRENO EN DOLARES" . "<br>";
    }
    if (empty($_POST['tipo_cambio'])) {

        $error .= "• FALTA INGRESAR EL TIPO DE CAMBIO" . "<br>";
    }
    if (empty($_POST['fecha_limite'])) {

        $error .= "• FALTA INGRESAR LOS MESES PARA PAGAR" . "<br>";
    }




    if (empty($_POST['lote'])) {

        $error .= "• FALTA INGRESAR EL NUMERO DE LOTE" . "<br>";
    }
    if (empty($_POST['manzano'])) {

        $error .= "• FALTA INGRESAR EL NUMERO DE MANZANO" . "<br>";
    }
    if (empty($_POST['superficie'])) {

        $error .= "• FALTA INGRESAR LA SUPERFICIE" . "<br>";
    }
} else {
    // El checkbox no está marcado
    // $error .= "El checkbox no está marcado" . "<br>";
}

if (empty($_POST['resumen'])) {

    $error .= "• DEBE LLENAR EL RESUMEN DE LA VISITA" . "<br>";
}
if (empty($_POST['siguiente'])) {

    $error .= "• DEBE LLENAR EL SIGUIENTE PASO" . "<br>";
}




if ($error == "") {
    $sql = $pdo->prepare('INSERT INTO tb_informe (
        id_agenda_fk, fecha_registro, fecha_cierre, tipo_pago, num_recibo, num_transferencia,lote,manzano, superficie, monto, literal_monto, concepto, precio_acordado,precio_acordado_literal,tipo_cambio, plan, fecha_limite_pago, observacion, tipo_cliente, detalle_tipo_cliente, resumen_visita, seguiente_paso )VALUES ( :id_agenda_fk, :fecha_registro, :fecha_cierre, :tipo_pago, :num_recibo, :num_transferencia, :lote, :manzano, :superficie, :monto, :literal_monto, :concepto, :precio_acordado,:precio_acordado_literal,:tipo_cambio, :plan, :fecha_limite_pago, :observacion, :tipo_cliente, :detalle_tipo_cliente, :resumen_visita, :seguiente_paso )');



    $sql->bindParam(':id_agenda_fk', $id_agenda);
    $sql->bindParam(':fecha_registro', $fecha_registro);
    $sql->bindParam(':fecha_cierre', $fecha_cierre);
    $sql->bindParam(':tipo_pago', $tipoPago);
    $sql->bindParam(':num_recibo', $numeroRecibo);
    $sql->bindParam(':num_transferencia', $numeroTransferencia);
    $sql->bindParam(':lote', $lote);
    $sql->bindParam(':manzano', $manzano);
    $sql->bindParam(':superficie', $superficie);
    $sql->bindParam(':tipo_cliente', $tipo_cliente);
    $sql->bindParam(':monto', $monto);



    $sql->bindParam(':literal_monto', $literal_monto);
    $sql->bindParam(':concepto', $concepto);
    $sql->bindParam(':precio_acordado', $precio_acordado);
    $sql->bindParam(':precio_acordado_literal', $precio_acordado_literal);
    $sql->bindParam(':tipo_cambio', $tipo_cambio);
    $sql->bindParam(':plan', $plan);

    $sql->bindParam(':fecha_limite_pago', $fecha_limite);
    $sql->bindParam(':observacion', $observacion);




    $sql->bindParam(':detalle_tipo_cliente', $detalle_of_pro);
    $sql->bindParam(':resumen_visita', $resumen);
    $sql->bindParam(':seguiente_paso', $siguiente);




    if ($sql->execute()) {


        $sql = $pdo->prepare("SELECT id_cliente_fk FROM tb_agendas WHERE id_agenda='$id_agenda'");
        $sql->execute();

        $datos = $sql->fetch(PDO::FETCH_ASSOC);


        $id_cliente_fk = $datos['id_cliente_fk'];


        $sentencia = $pdo->prepare('UPDATE tb_clientes SET ci_cliente=:ci_cliente,exp_cliente=:exp_cliente WHERE id_cliente=:id_cliente');


        $ci_cliente = $_POST["ci_cliente"];
        $exp_cliente = $_POST["exp_cliente"];

        $sentencia->bindParam(':ci_cliente', $ci_cliente);
        $sentencia->bindParam(':exp_cliente', $exp_cliente);

        $sentencia->bindParam(':id_cliente', $id_cliente_fk);


        if ($sentencia->execute()) {
            echo "exito";
        } else {
        }
    }
} else {
    echo $error;
}
