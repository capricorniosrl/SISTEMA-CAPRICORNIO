<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>
   <?php
if (isset($_SESSION['session_reservas'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/admin');
}
?>
<?php include ('../../layout/admin/parte1.php'); ?>

<style>
  .date-input-container {
      position: relative;
      display: inline-block;
      width: 100%;
  }

  .date-input-container input[type="date"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ced4da;
      border-radius: 6px;
      font-size: 1rem;
      color: #495057;
      background-color: #ffffff;
      transition: border-color 0.2s ease-in-out;
      border: none;
      border-bottom: #1b4f72 solid;
  }

  .date-input-container input[type="date"]:focus {
      border-color: #80bdff;
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
  }

  .date-input-container input[type="date"]::-webkit-calendar-picker-indicator {
      cursor: pointer;
      opacity: 0.8;
  }

  .date-input-container input[type="date"]::-webkit-calendar-picker-indicator:hover {
      opacity: 1;
  }
</style>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Lista de Clientes con Reserva</h1>
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
                        $('#example').DataTable( {
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
                        <th>CELULAR</th>
                        <th>URBANIZACION</th>
                        <th>MONTO DEPOSITADO</th>
                        <th>TIPO PAGO</th>
                        <th>FECHA DEPOSITO</th>
                        <th>FECHA LIMITE</th>
                        <th>DIAS RESTANTES</th>
                        <th>ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $query=$pdo->prepare("SELECT cli.apellidos, info.estado_reporte, info.estado_cierre, UPPER(info.lote) AS lote, UPPER(info.manzano) AS manzano, info.id_informe, con.celular, cli.tipo_urbanizacion, cli.nombres, info.monto, info.fecha_registro, info.fecha_cierre, UPPER(info.tipo_pago) as tipo_pago, DATEDIFF(info.fecha_cierre,NOW()) as dias FROM tb_clientes cli INNER JOIN tb_agendas ag INNER JOIN tb_informe info INNER JOIN tb_usuarios us INNER JOIN tb_contactos con WHERE info.monto>0 AND ((ag.id_agenda = info.id_agenda_fk) AND ag.id_cliente_fk = cli.id_cliente) AND (cli.id_contacto_fk=con.id_contacto AND con.id_usuario_fk = us.id_usuario) AND ag.id_usuario_fk = $id_usuario");
                        $query->execute();
                        $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);
                        $contador = 0;
                        foreach ($usuarios as $usuario) {
                       
                        $datos_informe = $usuario['id_informe'];


                        $contador++;
                      ?>
                      <tr data-id="<?php echo $usuario['id_informe']; ?>">
                        <td><?php echo $contador; ?></td>
                        <td><?php echo $usuario['nombres']." ".$usuario['apellidos']; ?></td>
                        <td><?php echo $usuario['celular']; ?></td>
                        <td><?php echo $usuario['tipo_urbanizacion']."<br><b>LOTE:</b> ".$usuario['lote']."<br> <b>MZN:</b> ".$usuario['manzano']; ?></td>
                        
                        <td>
                          <?php echo $usuario['monto']; ?> Bs.

                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#aumentar_reserva" onclick="modal_aumentar_recerva('<?php echo $datos_informe ?>')">+</button>

                          
                        </td>

                        <script>
                          //mostrar datos en la ventana modal
                          function modal_aumentar_recerva(datos_cargo) {
                              datoscargo = datos_cargo.split("||");
                              $("#input_id").val(datoscargo[0]);     
                          }
                        </script>

                          <!-- modal para aumentar la reserva -->
                          <div class="modal fade" id="aumentar_reserva" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered ">
                              <div class="modal-content">
                                <div class="modal-header bg-primary">
                                  <h5 class="modal-title">Aumentar Reserva</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form id="form_monto" method="POST" action="aumentar_reserva.php">
                                    <div class="form-group">
                                      <label for="">AGREGAR MONTO</label>
                                      
                                      <input type="number" name="monto" id="" class="form-control">
                                      
                                      <input type="text" name="id_informe" value="" id="input_id" class="form-control" hidden>
                                    </div>
                                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                                  </form>                                  
                                </div>                                
                              </div>
                            </div>
                          </div>


                        <td><?php echo $usuario['tipo_pago']; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($usuario['fecha_registro'])); ?></td>
                        <td>
                          <div class="date-input-container">
                            <input type="date" name="fecha_fin" class="fecha_fin" value="<?php echo $usuario['fecha_cierre']; ?>" data-id="<?php echo $usuario['id_informe']; ?>">
                          </div>
                        </td>
                        <td class="dias-restantes" id="dias-<?php echo $usuario['id_informe']; ?>">
                          <?php
                            if ($usuario['dias'] > 0) {
                                echo 'Faltan <button type="button" class="btn btn-primary"><span class="badge badge-light"> ' . $usuario['dias'] . ' </span> días</button> para el Cierre';
                            } elseif ($usuario['dias'] == 0) {
                                echo '<span class="text-success">El Cierre es hoy</span>';
                            } else {
                                echo '<span class="text-danger">Expiro el dia del Cierre LIBERAR</span>';
                            }
                          ?>
                        </td>
                        <td>
                          <?php if ($usuario['estado_reporte']==0 AND $usuario['estado_cierre']==0) { ?>
                            <div class="btn-group" role="group">
                              <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                OPCIONES
                              </button>
                              <div class="dropdown-menu">
                                <a style="cursor:pointer;" class="dropdown-item myButton" data-id="<?php echo $usuario['id_informe']; ?>">Cierre</a>
                                <a href="cierre.php?id=<?php echo $usuario['id_informe']; ?>" class="dropdown-item">Liberacion</a>
                              </div>
                            </div>
                          <?php       
                        
                        }else {
                          if ($usuario['estado_reporte']==0 AND $usuario['estado_cierre']==1) {
                          ?>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                  OPCIONES
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item disabled"><i class="fas fa-ban"></i> Cierre</a>
                                </div>
                              </div>
                                <a class="btn btn-outline-primary" target="_blank" href="../reporte_cierre/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> PDF CIERRE</a>
                          
                          <?php
                          } else {
                          ?>
                            
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                  OPCIONES
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item disabled"><i class="fas fa-ban"></i> Cierre</a>
                                </div>
                              </div>
                                <a class="btn btn-outline-primary" target="_blank" href="../reporte_liberacion/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> PDF LIBERACION</a>
                          
                          <?php
                          }
                          
                          ?>
                                  
                            
                          <?php } ?>
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



<?php include ('../../layout/admin/parte2.php'); ?>



<script>
$(document).ready(function() {
    // Evento de cambio en el campo de fecha
    $('input.fecha_fin').on('change', function() {
        var nuevaFecha = $(this).val();
        var idInforme = $(this).data('id'); // Obtener el id_informe del atributo data-id

        $.ajax({
            url: 'actualizar_fecha.php', // URL del script PHP que actualizará la fecha en la base de datos
            type: 'POST',
            data: {
                id_informe: idInforme,
                fecha_fin: nuevaFecha
            },
            dataType: 'json',
            success: function(response) {
                // Aquí puedes manejar la respuesta del servidor
                console.log(response.message);
                // Actualizar el contenido de la celda con los días restantes
                var diasRestantes = response.dias_restantes;
                var diasCell = $('#dias-' + idInforme);

                if (diasRestantes > 0) {
                    diasCell.html('Faltan <button type="button" class="btn btn-primary"><span class="badge badge-light"> ' + diasRestantes + ' </span> días</button> para el Cierre');
                } else if (diasRestantes == 0) {
                    diasCell.html('<span class="text-success">El Cierre es hoy</span>');
                } else {
                    diasCell.html('<span class="text-danger">Expiro el dia del Cierre LIBERAR</span>');
                }
            },
            error: function(xhr, status, error) {
                // Aquí puedes manejar los errores
                console.error(error);
            }
        });
    });
});

</script>

<script>
   document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".myButton").forEach(function(button) {
        button.addEventListener("click", function() {
            var id = this.getAttribute("data-id");

            Swal.fire({
                title: 'SELECCIONE UNA OPCION DE PAGO PARA EL CIERRE',
                icon: 'question',
                showCancelButton: true,
                showConfirmButton: false,
                buttonsStyling: false,
                customClass: {
                    cancelButton: 'btn btn-danger',
                    confirmButton: 'btn btn-success'
                },
                html: `
                    <button class="swal2-confirm swal2-styled" onclick="redirectToPage('opcion1', ${id})">Contado</button>
                    <button class="swal2-confirm swal2-styled" onclick="redirectToPage('opcion2', ${id})">Semicontado</button>
                    <button class="swal2-confirm swal2-styled" onclick="redirectToPage('opcion3', ${id})">Credito</button>
                `
            });
        });
    });
});

function redirectToPage(option, id) {
    var url;

    switch(option) {
        case 'opcion1':
            url = `../cierre/contado.php?id=${id}`;
            break;
        case 'opcion2':
            url = `../cierre/semi-contado.php?id=${id}`;
            break;
        case 'opcion3':
            url = `../cierre/credito.php?id=${id}`;
            break;
        default:
            return;
    }

    window.location.href = url;
}

</script>


