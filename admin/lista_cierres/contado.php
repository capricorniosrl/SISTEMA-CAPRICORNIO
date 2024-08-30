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
                          <th>MONTO BS</th>
                          <th>MONTO $</th>
                          <th>TIPO CAMBIO</th>
                          <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $pdo->prepare("SELECT con.created_at, info.lote,info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, con.*
                            FROM tb_contado con
                            INNER JOIN tb_comprador com
                            INNER JOIN tb_usuarios us
                            INNER JOIN tb_agendas ag
                            INNER JOIN tb_clientes cli
                            INNER JOIN tb_contactos cont
                            INNER JOIN tb_informe info
                            WHERE ((((con.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular) ORDER BY con.id_ccontado DESC");

                        $query->execute();
                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                        $contador = 0;
                        foreach ($usuarios as $usuario) {
                          $timestamp = $usuario['created_at'];
                          $contador++;
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
                            <td><?php echo $usuario['monto_bolivianos'] . " Bs" ?></td>
                            <td><?php echo $usuario['monto_dolar'] . " $" ?></td>
                            <td><?php echo $usuario['tipo_cambio'] . " Bs" ?></td>

                            <td>
                              <a target="_blank" href="../reporte_cierre/legal.php?id=<?php echo $usuario['id_informe']; ?>&usuario=<?php echo $usuario['id_usuario']; ?>
                                    " class="btn btn-default"><svg width="35" height="35" id="_36_Printer_Office_Paper" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" data-name="36 Printer, Office, Paper">
                                  <path d="m51 13v8a1 1 0 0 1 -1 1h-36a1 1 0 0 1 -1-1v-8a3 3 0 0 1 3-3h32a3 3 0 0 1 3 3z" fill="#445861" />
                                  <path d="m45 5v16a1 1 0 0 1 -1 1h-24a1 1 0 0 1 -1-1v-16a1 1 0 0 1 1-1h24a1 1 0 0 1 1 1z" fill="#26a6fe" />
                                  <path d="m44 4h-2a1 1 0 0 1 1 1v16a1 1 0 0 1 -1 1h2a1 1 0 0 0 1-1v-16a1 1 0 0 0 -1-1z" fill="#1976d2" />
                                  <path d="m31 8v4a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1-1v-4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" fill="#ef5350" />
                                  <path d="m30 7h-1v3a1 1 0 0 1 -1 1h-5v1a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1z" fill="#d43030" />
                                  <path d="m41 9h-8v-2h8zm0 2h-8v2h8zm0 4h-18v2h18z" fill="#fff" />
                                  <path d="m60 25v18a5 5 0 0 1 -5 5h-46a5 5 0 0 1 -5-5v-18a5 5 0 0 1 5-5h46a5 5 0 0 1 5 5z" fill="#546e7a" />
                                  <path d="m52.79 55.62a1 1 0 0 1 -.79.38h-40a1 1 0 0 1 -.79-.38 1 1 0 0 1 -.18-.86l2-7.88v-13.88a3 3 0 0 1 3-3h31.97a3 3 0 0 1 3 3v13.88l2 7.88a1 1 0 0 1 -.21.86z" fill="#445861" />
                                  <path d="m47 54.84-.15-.84-1.85-11.08v-12.92h-26v12.92l-1.85 11.08-.15 1a1 1 0 0 0 1 1h28a1 1 0 0 0 1-1 .86.86 0 0 0 0-.16z" fill="#26a6fe" />
                                  <path d="m47 54.84-.15-.84-1.85-11.08v-12.92h-2v12.92l1.85 11.08.14.84a.86.86 0 0 1 .01.16 1 1 0 0 1 -1 1h2a1 1 0 0 0 1-1 .86.86 0 0 0 0-.16z" fill="#1976d2" />
                                  <path d="m29 35v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1-1v-4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1z" fill="#ef5350" />
                                  <path d="m28 34h-1v3a1 1 0 0 1 -1 1h-3v1a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4a1 1 0 0 0 -1-1z" fill="#d43030" />
                                  <path d="m41 36h-10v-2h10zm0 2h-10v2h10zm0 4h-18v2h18zm1 4h-20v2h20zm1 4h-22v2h22z" fill="#fff" />
                                  <path d="m13 26h-4v-2h4zm6-2h-4v2h4zm6 0h-4v2h4z" fill="#fff" />
                                  <path d="m53 55v4a1 1 0 0 1 -1 1h-40a1 1 0 0 1 -1-1v-4a1 1 0 0 1 1-1h40a1 1 0 0 1 1 1z" fill="#445861" />
                                  <path d="m47 54.84-.15-.84h-29.7l-.15 1v5h30v-5a.86.86 0 0 0 0-.16z" fill="#1976d2" />
                                </svg> IMPRIMIR</a>
                            </td>

                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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
<?php include('../../layout/admin/parte2.php'); ?>