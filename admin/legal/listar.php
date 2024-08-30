<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['legal'])) {
    // echo "existe session y paso por el login";
} else {
    // echo "no existe session por que no ha pasado por el login";
    header('Location:' . $URL . '/admin');
}
?>

<?php include('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">PENDIENTES PARA SUBIR DOCUMENTO PRIVADO DE INTERMEDIACION </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        LISTA DE PREPARACION DE DOCUMENTO PRIVADO DE INTERMEDIACIÓN DE LA VENTA DE UN LOTE DE TERRENO
                    </h3>
                </div>
                <div class="card-body">

                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable({
                                "pageLength": 10,
                                "language": {
                                    "emptyTable": "No hay información de los Cargos",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Cargos",
                                    "infoEmpty": "Mostrando 0 a 0 de 0 Cargos",
                                    "infoFiltered": "(Filtrado de _MAX_ total Cargos)",
                                    "infoPostFix": "",
                                    "thousands": ",",
                                    "lengthMenu": "Mostrar _MENU_ Cargos",
                                    "loadingRecords": "Cargando...",
                                    "processing": "Procesando...",
                                    "search": "Buscador:",
                                    "zeroRecords": "Sin resultados encontrados",
                                    "paginate": {
                                        "first": "Primero",
                                        "last": "Ultimo",
                                        "next": "Siguiente",
                                        "previous": "Anterior"
                                    }
                                }
                            });
                        });
                    </script>

                    <div class="table-responsive">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nro.</th>
                                    <th>NOMBRE CLIENTE</th>
                                    <th>CI</th>
                                    <th>CELULAR</th>
                                    <th>URBANIZACION</th>
                                    <th>DETALLES VENTA</th>
                                    <th>CUOTAS</th>
                                    <th>DETALLES COBRANZA</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $pdo->prepare("SELECT info.monto, semi.tipo_cambio, semi.cuota_inicial, info.monto, info.lote,info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, semi.*
                            FROM tb_semicontado semi
                            INNER JOIN tb_comprador com
                            INNER JOIN tb_usuarios us
                            INNER JOIN tb_agendas ag
                            INNER JOIN tb_clientes cli
                            INNER JOIN tb_contactos cont
                            INNER JOIN tb_informe info
                            WHERE (((((semi.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular)) AND estado_doc_priv=1 GROUP BY semi.id_comprador_fk");

                                $query->execute();
                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                $contador = 0;
                                foreach ($usuarios as $usuario) {
                                    $contador++;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $usuario['nombre_1'] . " " . $usuario['ap_paterno_1'] . " " . $usuario['ap_materno_1'] . "<br>" . $usuario['nombre_2'] . " " . $usuario['ap_paterno_2'] . " " . $usuario['ap_materno_2']; ?></td>

                                        <?php
                                        if ($usuario['ci_2']) {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] . "<br>" . $usuario['ci_2'] . " " . $usuario['exp_2'] ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] ?></td>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if ($usuario['celular_2']) {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] . "<br>" . $usuario['celular_2']; ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] ?></td>
                                        <?php
                                        }
                                        ?>



                                        <td><?php echo $usuario['urbanizacion'] . "<br> <b>Lote:</b> " . $usuario['lote'] . "<br> <b>Manzano:</b> " . $usuario['manzano'] . "<br> <b>Superficie:</b> " . $usuario['superficie'] ?></td>

                                        <td>
                                            <?php
                                            $id_semicontado = $usuario['id_semicontado'];

                                            $id_comprado = $usuario['id_comprador'];

                                            $sql2 = $pdo->prepare("SELECT  COUNT(*) as cuotas FROM tb_semicontado semi INNER JOIN tb_comprador comp INNER JOIN tb_cuotas cu WHERE ((semi.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id_comprado') AND cu.id_semicontado_fk='$id_semicontado'");

                                            $sql2->execute();
                                            $dato2 = $sql2->fetch(PDO::FETCH_ASSOC);

                                            $sumar = $dato2['cuotas'];
                                            $tipo_cambio = $usuario['tipo_cambio'];

                                            $fecha_act = $usuario['fecha_registro'];
                                            $timestamp = strtotime($fecha_act);
                                            $timestamp_nueva = strtotime("+$sumar months", $timestamp);
                                            $fecha_nueva = date('Y-m-d', $timestamp_nueva);

                                            ?>

                                            <span class="text-success"><b>SEMI CONTADO</b></span>
                                            <?php echo "<br><b>Precio Total </b>" . $usuario['monto_dolar'] . " $<br>" ?>
                                            <?php echo "<b>Cuota Inicial </b>" . $usuario['cuota_inicial'] . " $<br>" ?>
                                            <?php echo "<b>Reserva </b>" . round($usuario['monto'] / $tipo_cambio, 2) . " $" ?>
                                        </td>

                                        <td>



                                            <?php echo "<b> <span class='text-primary'>" . $dato2['cuotas'] . " Cuotas</span><br>Fecha Inicio</b> " . date("d-m-Y", strtotime($usuario['fecha_registro'])) . "<br><b>Fecha Fin</b> " . date("d-m-Y", strtotime($fecha_nueva)) ?>
                                        </td>
                                        <td>

                                            <?php

                                            $sql_cuotas = $pdo->prepare("SELECT 
                                        (SELECT COUNT(*)
                                        FROM tb_semicontado semi
                                        INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                        INNER JOIN tb_cuotas cu ON cu.id_semicontado_fk = semi.id_semicontado
                                        WHERE comp.id_comprador = '$id_comprado'
                                        AND cu.id_semicontado_fk = '$id_semicontado'
                                        AND cu.monto > 0) AS pagos_hechos,

                                        (SELECT COUNT(*)
                                        FROM tb_semicontado semi
                                        INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                        INNER JOIN tb_cuotas cu ON cu.id_semicontado_fk = semi.id_semicontado
                                        WHERE comp.id_comprador = '$id_comprado'
                                        AND cu.id_semicontado_fk = '$id_semicontado') AS pagos_totales");

                                            $sql_cuotas->execute();
                                            $dato_cuotas = $sql_cuotas->fetch(PDO::FETCH_ASSOC);

                                            $sql_cuota = $pdo->prepare("SELECT SUM(monto) as cancelado, id_cuota
                                        FROM tb_semicontado semi
                                        INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                        INNER JOIN tb_cuotas cu ON cu.id_semicontado_fk = semi.id_semicontado
                                        WHERE comp.id_comprador = '$id_comprado'
                                        AND cu.id_semicontado_fk = '$id_semicontado'
                                        AND cu.monto > 0");

                                            $sql_cuota->execute();
                                            $monto_cuota = $sql_cuota->fetch(PDO::FETCH_ASSOC);


                                            $monto_cancelar = ($usuario['monto_dolar'] - $usuario['cuota_inicial'] - round($usuario['monto'] / $tipo_cambio, 2)) / $dato_cuotas['pagos_totales'];

                                            echo "<span class='text-primary'><b>SEMICONTADO</b></span><br><b>Total </b> " . $dato_cuotas['pagos_totales'] . "<b> Cuotas </b> <br><b>de</b> " . round($monto_cancelar, 2) . " $";

                                            ?>

                                        </td>

                                        <td>
                                            <?php
                                            $id_comprador = $usuario['id_comprador'];
                                            $sql_buscar = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                            $sql_buscar->execute();
                                            $datos_documento = $sql_buscar->fetchAll(PDO::FETCH_ASSOC);

                                            $contador_doc = 0;


                                            foreach ($datos_documento as $valor) {
                                                $contador_doc++;
                                            }

                                            if ($contador_doc == 1) {
                                                $sql_buscar1 = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                                $sql_buscar1->execute();
                                                $datos_documento1 = $sql_buscar1->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <a target="_blank" href="<?php echo $datos_documento1['ruta_archivo'] ?>" class="btn btn-default"> <i class="fas fa-download text-primary"></i> DESCARGAR </a>

                                            <?php
                                            } else {
                                            ?>
                                                <a target="_blank" href="reporte_intermediacion.php?id=<?php echo $usuario['id_comprador'] ?>" class="btn btn-default"> <i class="fas fa-download text-primary"></i> DESCARGAR</a>



                                                <a href="controller_edit_contrato.php?id_comp=<?php echo $usuario['id_comprador'] ?>" class="btn btn-default"> <i class="fas fa-edit text-success"></i> EDITAR</a>
                                            <?php

                                            }

                                            ?>


                                        </td>

                                    </tr>
                                <?php
                                } ?>


                                <!--                   credito                   -->


                                <?php
                                $query = $pdo->prepare("SELECT semi.cuota_interes, info.monto, semi.tipo_cambio, semi.cuota_inicial, info.monto, info.lote,info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, semi.*
                              FROM tb_credito semi
                              INNER JOIN tb_comprador com
                              INNER JOIN tb_usuarios us
                              INNER JOIN tb_agendas ag
                              INNER JOIN tb_clientes cli
                              INNER JOIN tb_contactos cont
                              INNER JOIN tb_informe info
                              WHERE (((((semi.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular)) AND estado_doc_priv=1 GROUP BY semi.id_comprador_fk");

                                $query->execute();
                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($usuarios as $usuario) {





                                    $contador++;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $usuario['nombre_1'] . " " . $usuario['ap_paterno_1'] . " " . $usuario['ap_materno_1'] . "<br>" . $usuario['nombre_2'] . " " . $usuario['ap_paterno_2'] . " " . $usuario['ap_materno_2']; ?></td>

                                        <?php
                                        if ($usuario['ci_2']) {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] . "<br>" . $usuario['ci_2'] . " " . $usuario['exp_2'] ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] ?></td>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if ($usuario['celular_2']) {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] . "<br>" . $usuario['celular_2']; ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] ?></td>
                                        <?php
                                        }
                                        ?>



                                        <td><?php echo $usuario['urbanizacion'] . "<br> <b>Lote:</b> " . $usuario['lote'] . "<br> <b>Manzano:</b> " . $usuario['manzano'] . "<br> <b>Superficie:</b> " . $usuario['superficie'] ?></td>


                                        <td>
                                            <span class="text-danger"><b>CREDITO</b></span>
                                            <?php echo "<br><b>Precio Total </b>" . $usuario['monto_dolar'] . " $<br>" ?>
                                            <?php echo "<b>Cuota Inicial </b>" . $usuario['cuota_inicial'] . " $<br>" ?>
                                            <?php echo "<b>Reserva </b>" . round($usuario['monto'] / $usuario['tipo_cambio'], 2) . " $<br>" ?>
                                            <?php echo "<b>Interes </b>" . $usuario['cuota_interes'] . " $" ?>
                                        </td>


                                        <td>

                                            <?php
                                            $id_semicontado = $usuario['id_credito'];

                                            $id_comprado = $usuario['id_comprador'];

                                            $sql2 = $pdo->prepare("SELECT  COUNT(*) as cuotas FROM tb_credito semi INNER JOIN tb_comprador comp INNER JOIN tb_cuotas_credito cu WHERE ((semi.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id_comprado') AND cu.id_credito_fk='$id_semicontado'");

                                            $sql2->execute();
                                            $dato2 = $sql2->fetch(PDO::FETCH_ASSOC);
                                            ?>

                                            <?php
                                            $sumar = $dato2['cuotas'];
                                            $fecha_act = $usuario['fecha_registro'];
                                            $timestamp = strtotime($fecha_act);
                                            $timestamp_nueva = strtotime("+$sumar months", $timestamp);
                                            $fecha_nueva = date('Y-m-d', $timestamp_nueva);

                                            ?>


                                            <?php echo "<b> <span class='text-primary'>" . $dato2['cuotas'] . " Cuotas</span> <br>Fecha Inicio</b> " . date("d-m-Y", strtotime($usuario['fecha_registro'])) . "<br><b>Fecha Fin</b> " . date("d-m-Y", strtotime($fecha_nueva)) ?>
                                        </td>

                                        <td>

                                            <?php

                                            $sql_cuotas = $pdo->prepare("SELECT 
                                      (SELECT COUNT(*)
                                      FROM tb_credito semi
                                      INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                      INNER JOIN tb_cuotas_credito cu ON cu.id_credito_fk = semi.id_credito
                                      WHERE comp.id_comprador = '$id_comprado'
                                      AND cu.id_credito_fk = '$id_semicontado'
                                      AND cu.monto > 0) AS pagos_hechos,

                                      (SELECT COUNT(*)
                                      FROM tb_credito semi
                                      INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                      INNER JOIN tb_cuotas_credito cu ON cu.id_credito_fk = semi.id_credito
                                      WHERE comp.id_comprador = '$id_comprado'
                                      AND cu.id_credito_fk = '$id_semicontado') AS pagos_totales");

                                            $sql_cuotas->execute();
                                            $dato_cuotas = $sql_cuotas->fetch(PDO::FETCH_ASSOC);


                                            $sql_cuota = $pdo->prepare("SELECT SUM(monto) as cancelado, id_cuota
                                      FROM tb_credito semi
                                      INNER JOIN tb_comprador comp ON semi.id_comprador_fk = comp.id_comprador
                                      INNER JOIN tb_cuotas_credito cu ON cu.id_credito_fk = semi.id_credito
                                      WHERE comp.id_comprador = '$id_comprado'
                                      AND cu.id_credito_fk = '$id_semicontado'
                                      AND cu.monto > 0");

                                            $sql_cuota->execute();
                                            $monto_cuota = $sql_cuota->fetch(PDO::FETCH_ASSOC);




                                            $monto_cancelar = (($usuario['monto_dolar'] - $usuario['cuota_inicial'] - round($usuario['monto'] / $usuario['tipo_cambio'], 2)) + $usuario['cuota_interes']) / $dato_cuotas['pagos_totales'];

                                            echo "<span class='text-primary'><b>CREDITO</b></span><br><b>Total </b> " . $dato_cuotas['pagos_totales'] . "<b> Cuotas </b> <br><b>de</b> " . round($monto_cancelar, 2) . " $";


                                            ?>

                                        </td>

                                        <td>
                                            <?php
                                            $id_comprador = $usuario['id_comprador'];
                                            $sql_buscar = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                            $sql_buscar->execute();
                                            $datos_documento = $sql_buscar->fetchAll(PDO::FETCH_ASSOC);

                                            $contador_doc = 0;


                                            foreach ($datos_documento as $valor) {
                                                $contador_doc++;
                                            }

                                            if ($contador_doc == 1) {
                                                $sql_buscar1 = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                                $sql_buscar1->execute();
                                                $datos_documento1 = $sql_buscar1->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <a target="_blank" href="<?php echo $datos_documento1['ruta_archivo'] ?>" class="btn btn-default"> <i class="fas fa-download text-primary"></i> DESCARGAR </a>

                                            <?php
                                            } else {
                                            ?>
                                                <a target="_blank" href="reporte_intermediacion.php?id=<?php echo $usuario['id_comprador'] ?>" class="btn btn-default"> <i class="fas fa-download text-primary"></i> DESCARGAR</a>
                                                <a href="controller_edit_contrato.php?id_comp=<?php echo $usuario['id_comprador'] ?>" class="btn btn-default"> <i class="fas fa-edit text-success"></i> EDITAR</a>
                                            <?php

                                            }

                                            ?>

                                        </td>

                                    </tr>
                                <?php
                                } ?>

                                <!--                   Contado                   -->
                                <?php
                                $query = $pdo->prepare("SELECT info.monto,  con.tipo_cambio, info.monto, info.lote, info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, con.*
                            FROM tb_contado con
                            INNER JOIN tb_comprador com
                            INNER JOIN tb_usuarios us
                            INNER JOIN tb_agendas ag
                            INNER JOIN tb_clientes cli
                            INNER JOIN tb_contactos cont
                            INNER JOIN tb_informe info
                            WHERE (((((con.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular)) AND estado_doc_priv=1");

                                $query->execute();
                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                $contador = 0;
                                foreach ($usuarios as $usuario) {
                                    $contador++;
                                ?>
                                    <tr>
                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $usuario['nombre_1'] . " " . $usuario['ap_paterno_1'] . " " . $usuario['ap_materno_1'] . "<br>" . $usuario['nombre_2'] . " " . $usuario['ap_paterno_2'] . " " . $usuario['ap_materno_2']; ?></td>

                                        <?php
                                        if ($usuario['ci_2']) {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] . "<br>" . $usuario['ci_2'] . " " . $usuario['exp_2'] ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['ci_1'] . " " . $usuario['exp_1'] ?></td>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if ($usuario['celular_2']) {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] . "<br>" . $usuario['celular_2']; ?></td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><?php echo $usuario['celular_1'] ?></td>
                                        <?php
                                        }
                                        ?>



                                        <td><?php echo $usuario['urbanizacion'] . "<br> <b>Lote:</b> " . $usuario['lote'] . "<br> <b>Manzano:</b> " . $usuario['manzano'] . "<br> <b>Superficie:</b> " . $usuario['superficie'] ?></td>

                                        <td>
                                            <span class="text-info"><b>CONTADO</b></span>
                                            <?php echo "<br><b>Precio Total </b>" . $usuario['monto_dolar'] . " $" ?>
                                            <?php echo "<br><b>Reserva </b>" . round($usuario['monto'] / $usuario['tipo_cambio'], 2) . " $" ?>
                                        </td>

                                        <td><?php echo "<b>Fecha de Cancelacion</b><br>" . $usuario['fecha_registro'] ?></td>
                                        <td>
                                            <span class="text-info"><b>CONTADO</b></span>
                                            <?php echo "<br><b>Total Cancelado</b> " . ($usuario['monto_dolar'] - round($usuario['monto'] / $usuario['tipo_cambio'], 2)) . " $" ?>
                                        </td>

                                        <td>
                                            <?php
                                            $id_comprador = $usuario['id_comprador'];
                                            $sql_buscar = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                            $sql_buscar->execute();
                                            $datos_documento = $sql_buscar->fetchAll(PDO::FETCH_ASSOC);

                                            $contador_doc = 0;


                                            foreach ($datos_documento as $valor) {
                                                $contador_doc++;
                                            }

                                            if ($contador_doc == 1) {
                                                $sql_buscar1 = $pdo->prepare("SELECT * FROM tb_comprador com INNER JOIN tb_archivo ar WHERE (com.id_comprador=ar.id_comprador_fk) AND com.id_comprador='$id_comprador'");
                                                $sql_buscar1->execute();
                                                $datos_documento1 = $sql_buscar1->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <a target="_blank" href="<?php echo $datos_documento1['ruta_archivo'] ?>" class="btn btn-default"> <i class="fas fa-download text-primary"></i> DESCARGAR </a>

                                            <?php
                                            } else {
                                            ?>
                                                <a href="formulario_subir.php?id=<?php echo $usuario['id_comprador'] ?>" class="btn btn-default"> <i class="fas fa-upload text-danger"></i> SUBIR </a>
                                            <?php

                                            }

                                            ?>
                                        </td>

                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>


        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../layout/admin/parte2.php'); ?>