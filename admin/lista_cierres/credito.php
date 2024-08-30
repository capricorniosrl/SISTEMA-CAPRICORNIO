<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['lista_cierres'])) {
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
        <div class="col-sm-6">
          <h1 class="m-0">Lista de Clientes con Pago al Contado</h1>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-body">
                  <script>
                    $(document).ready(function() {
                      $('#example').DataTable({
                        "pageLength": 10,
                        "language": {
                          "emptyTable": "No hay información de los Clientes",
                          "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                          "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                          "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                          "infoPostFix": "",
                          "thousands": ",",
                          "lengthMenu": "Mostrar _MENU_ Clientes",
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
                          <th>MONTO $</th>
                          <th>SEGUIMIENTO</th>
                          <th>DETALLES</th>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $pdo->prepare("SELECT semi.created_at, info.monto, info.lote,info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, semi.*
                            FROM tb_credito semi
                            INNER JOIN tb_comprador com
                            INNER JOIN tb_usuarios us
                            INNER JOIN tb_agendas ag
                            INNER JOIN tb_clientes cli
                            INNER JOIN tb_contactos cont
                            INNER JOIN tb_informe info
                            WHERE ((((semi.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular) GROUP BY semi.id_comprador_fk ORDER BY semi.id_credito DESC");

                        $query->execute();
                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                        $contador = 0;
                        foreach ($usuarios as $usuario) {





                          $contador++;
                          $timestamp = $usuario['created_at'];
                        ?>

                          <tr>

                            <td><?php echo $contador; ?></td>




                            <td><?php echo $usuario['nombre_1'] . " " . $usuario['ap_paterno_1'] . " " . $usuario['ap_materno_1'];
                                if ($usuario['nombre_2']) {
                                  echo "<br>" . $usuario['nombre_2'] . " " . $usuario['ap_paterno_2'] . " " . $usuario['ap_materno_2'];
                                }
                                ?>
                              <br>
                              <small class="time-ago text-primary" data-timestamp="<?php echo $timestamp; ?>"></small>
                            </td>

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
                            <td><?php echo $usuario['monto_dolar'] . " $" ?></td>
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


                              ?>



                              <?php

                              // echo "total cancelado ". round($monto_cuota['cancelado'],0);
                              // echo "<br>";
                              // echo "cuota inicial ".$usuario['cuota_inicial'];
                              // echo "<br>";
                              // echo "tipo cambio ".$usuario['tipo_cambio'];
                              // echo "<br>";
                              // echo "reserva ".round($usuario['monto']/$usuario['tipo_cambio']);
                              // echo "<br>";

                              $monto_cancelado = round($monto_cuota['cancelado'], 2) + $usuario['cuota_inicial'] + round($usuario['monto'] / $usuario['tipo_cambio'], 2);

                              if (($dato_cuotas['pagos_totales'] == $dato_cuotas['pagos_hechos']) || $usuario['monto_dolar'] == $monto_cancelado) {


                                echo "<b>PAGOS TOTALES</b> " . $dato_cuotas['pagos_totales'] . "<br><b>PAGOS HECHOS</b> " . $dato_cuotas['pagos_hechos'];
                                echo "<h6><span class='badge badge-success'>PAGO COMPLETADO</span></h6>";
                              } else {

                                echo "<b>PAGOS TOTALES</b> " . $dato_cuotas['pagos_totales'] . "<br><b>PAGOS HECHOS</b> " . $dato_cuotas['pagos_hechos'];
                                echo "<h6><span class='badge badge-danger'>REALIZAR SEGUIMIENTO</span></h6>";
                              }


                              ?>

                            </td>

                            <td>
                              <a href="../credito/cliente_credito.php?variable=<?php echo $usuario['id_comprador']; ?>
                                    " class="btn btn-default"> <img style="height: 35px;" src="../../public/img/seguimiento.svg" alt=""> VER SEGUIMIENTO</a>
                            </td>

                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <script>
                      function timeAgo(timestamp) {
                        const now = new Date();
                        const then = new Date(timestamp);
                        const seconds = Math.floor((now - then) / 1000);
                        const intervals = [{
                            name: "segundo",
                            duration: 60
                          },
                          {
                            name: "minuto",
                            duration: 3600
                          },
                          {
                            name: "hora",
                            duration: 86400
                          },
                          {
                            name: "día",
                            duration: 604800
                          },
                          {
                            name: "semana",
                            duration: 2419200
                          },
                          {
                            name: "mes",
                            duration: 29030400
                          },
                          {
                            name: "año",
                            duration: 348364800
                          },
                        ];

                        for (let i = 0; i < intervals.length; i++) {
                          const interval = intervals[i];
                          if (seconds < interval.duration) {
                            const count = Math.floor(seconds / (interval.duration / 60));
                            return `se agregó hace ${count} ${interval.name}${count > 1 ? 's' : ''}`;
                          }
                        }

                        return "hace mucho tiempo";
                      }

                      function updateTimesAgo() {
                        const elements = document.querySelectorAll('.time-ago');
                        elements.forEach(element => {
                          const timestamp = element.getAttribute('data-timestamp');
                          element.textContent = timeAgo(timestamp);
                        });
                      }

                      // Actualizar el tiempo cada 10 segundos para que esté siempre fresco
                      setInterval(updateTimesAgo, 10000);

                      // Inicializar al cargar la página
                      document.addEventListener('DOMContentLoaded', updateTimesAgo);
                    </script>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>



<?php include('../../layout/admin/parte2.php'); ?>