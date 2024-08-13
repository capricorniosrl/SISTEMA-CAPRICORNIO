<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');

    include ('../../layout/admin/datos_session_user.php');


$id_informe=$_POST['id_informe'];

// DATOS COMPRADOR
$nombre_1=$_POST['nombre_1'];
$ap_paterno_1=$_POST['ap_paterno_1'];
$ap_materno_1=$_POST['ap_materno_1'];
$ci_1=$_POST['ci_1'];
$exp_1=$_POST['exp_1'];
$celular_1=$_POST['celular_1'];


$nombre_2=$_POST['nombre_2'];
$ap_paterno_2=$_POST['ap_paterno_2'];
$ap_materno_2=$_POST['ap_materno_2'];
$ci_2=$_POST['ci_2'];
$exp_2=$_POST['exp_2'];
$celular_2=$_POST['celular_2'];

// // DATOS DECONTADO
$precio_dolares=$_POST['precio_dolares'];
$tipo_cambio=$_POST['tipo_cambio'];
$precio_Bolivianos=$_POST['numero'];
$moneda=$_POST['moneda'];
$literal=$_POST['literal'];
$concepto=$_POST['concepto'];

// // DATOS DE KLA URBANIZACION
$urbanizacion=$_POST['urbanizacion'];
$lote=$_POST['lote'];
$manzano=$_POST['manzano'];
$superficie=$_POST['superficie'];

$fecha_registro=$_POST['fecha_registro'];
$numero_recibo=$_POST['numero_recibo'];


$sql = $pdo->prepare("INSERT INTO tb_comprador ( nombre_1, ap_paterno_1, ap_materno_1, ci_1, exp_1, celular_1, nombre_2, ap_paterno_2, ap_materno_2, ci_2, exp_2, celular_2, id_usuario_fk ) VALUES ( :nombre_1, :ap_paterno_1, :ap_materno_1, :ci_1, :exp_1, :celular_1, :nombre_2, :ap_paterno_2, :ap_materno_2, :ci_2, :exp_2, :celular_2, :id_usuario_fk )");

$sql->bindParam(':nombre_1',$nombre_1);
$sql->bindParam(':ap_paterno_1',$ap_paterno_1);
$sql->bindParam(':ap_materno_1',$ap_materno_1);
$sql->bindParam(':ci_1',$ci_1);
$sql->bindParam(':exp_1',$exp_1);
$sql->bindParam(':celular_1',$celular_1);

$sql->bindParam(':nombre_2',$nombre_2);
$sql->bindParam(':ap_paterno_2',$ap_paterno_2);
$sql->bindParam(':ap_materno_2',$ap_materno_2);
$sql->bindParam(':ci_2',$ci_2);
$sql->bindParam(':exp_2',$exp_2);
$sql->bindParam(':celular_2',$celular_2);

$sql->bindParam(':id_usuario_fk',$id_usuario);

if ($sql->execute()) {
    $sql_1 = $pdo->prepare("SELECT * FROM tb_comprador WHERE ci_1='$ci_1' ORDER by id_comprador DESC LIMIT 1");
    $sql_1->execute();
    $dato_id=$sql_1->fetch(PDO::FETCH_ASSOC);
    $ID=$dato_id['id_comprador'];    



    $sql_2 = $pdo->prepare("INSERT INTO tb_contado (monto_dolar,tipo_cambio,monto_bolivianos,tipo_moneda,literal,concepto,urbanizacion,lote,manzano,superficie,fecha_registro,num_recibo,created_at,updated_at,id_comprador_fk) VALUES (:monto_dolar,:tipo_cambio,:monto_bolivianos,:tipo_moneda,:literal,:concepto,:urbanizacion,:lote,:manzano,:superficie,:fecha_registro,:num_recibo,:created_at,:updated_at,:id_comprador_fk)");
    $sql_2->bindParam(':monto_dolar',$precio_dolares);
    $sql_2->bindParam(':tipo_cambio',$tipo_cambio);
    $sql_2->bindParam(':monto_bolivianos',$precio_Bolivianos);
    $sql_2->bindParam(':tipo_moneda',$moneda);
    $sql_2->bindParam(':literal',$literal);
    $sql_2->bindParam(':concepto',$concepto);
    $sql_2->bindParam(':urbanizacion',$urbanizacion);
    $sql_2->bindParam(':lote',$lote);
    $sql_2->bindParam(':manzano',$manzano);
    $sql_2->bindParam(':superficie',$superficie);
    $sql_2->bindParam(':fecha_registro',$fecha_registro);
    $sql_2->bindParam(':num_recibo',$numero_recibo);
    $sql_2->bindParam(':created_at',$fechayhora);
    $sql_2->bindParam(':updated_at',$fechayhora);
    $sql_2->bindParam(':id_comprador_fk',$ID);
    if ($sql_2->execute()) {

        $sql_4=$pdo->prepare("UPDATE tb_informe SET estado_cierre='1' WHERE id_informe='$id_informe'");
        $sql_4->execute();

        header('Location:'. $URL.'/admin/reserva/index.php');
        exit();
    }
    
}




?>