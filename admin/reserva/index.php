<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['session_reservas'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>
<?php include('../../layout/admin/parte1.php'); ?>

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
                      $('#example').DataTable({
                        "pageLength": 10,
                        "language": {
                          "emptyTable": "No hay información de las Reservas",
                          "info": "Mostrando _START_ a _END_ de _TOTAL_ Reserva",
                          "infoEmpty": "Mostrando 0 a 0 de 0 Reserva",
                          "infoFiltered": "(Filtrado de _MAX_ total Reserva)",
                          "infoPostFix": "",
                          "thousands": ",",
                          "lengthMenu": "Mostrar _MENU_ Reservas",
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
                          <th>TIPO PAGO / PLAN</th>
                          <th>FECHA DEPOSITO</th>
                          <th>FECHA LIMITE</th>
                          <th>DIAS RESTANTES</th>
                          <th>ACCIONES</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = $pdo->prepare("SELECT info.compra_directo, info.plan, info.id_informe, cli.apellidos, info.estado_reporte, info.estado_cierre, UPPER(info.lote) AS lote, UPPER(info.manzano) AS manzano, info.superficie, info.id_informe, con.celular, cli.tipo_urbanizacion, cli.nombres, info.monto, info.fecha_registro, info.fecha_cierre, UPPER(info.tipo_pago) as tipo_pago, DATEDIFF(info.fecha_cierre,NOW()) as dias
                        FROM tb_clientes cli
                        INNER JOIN tb_agendas ag
                        INNER JOIN tb_informe info
                        INNER JOIN tb_usuarios us
                        INNER JOIN tb_contactos con
                        WHERE (info.monto>0 OR info.compra_directo='SI') AND ((ag.id_agenda = info.id_agenda_fk) AND ag.id_cliente_fk = cli.id_cliente) AND (cli.id_contacto_fk=con.id_contacto AND con.id_usuario_fk = us.id_usuario) AND ag.id_usuario_fk = $id_usuario ORDER BY info.id_informe DESC ");
                        $query->execute();
                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                        $contador = 0;
                        foreach ($usuarios as $usuario) {

                          $datos_informe = $usuario['id_informe'];


                          $contador++;
                        ?>
                          <tr data-id="<?php echo $usuario['id_informe']; ?>">
                            <td><?php echo $contador; ?></td>
                            <td><?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?></td>
                            <td><?php echo $usuario['celular']; ?></td>
                            <td><?php echo $usuario['tipo_urbanizacion'] . "<br><b>LOTE:</b> " . $usuario['lote'] . "<br> <b>MZN:</b> " . $usuario['manzano'] . "<br> <b>SUP.:</b> " . $usuario['superficie']; ?></td>

                            <td>
                              <?php
                              $sql_aumento = $pdo->prepare("SELECT * FROM tb_aumento_reserva WHERE id_informe_fk='$datos_informe' ORDER BY id_aumento_reserva DESC");
                              $sql_aumento->execute();
                              $dato_aumento = $sql_aumento->fetchAll(PDO::FETCH_ASSOC);

                              if ($usuario['tipo_pago'] == "") {
                                echo "SE HIZO COMPRA DIRECTA";
                              } else {

                                $sql_aumento1 = $pdo->prepare("SELECT SUM(monto_aumento) as monto_aumento FROM tb_aumento_reserva WHERE id_informe_fk='$datos_informe'");
                                $sql_aumento1->execute();

                                $dato_suma = $sql_aumento1->fetch(PDO::FETCH_ASSOC);

                                // Acceder al valor de 'monto_aumento'
                                $suma = isset($dato_suma['monto_aumento']) ? intval($dato_suma['monto_aumento']) : 0;




                                echo $usuario['monto'] + $suma . " Bs";
                              ?>


                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#aumentar_reserva" onclick="modal_aumentar_recerva('<?php echo $datos_informe ?>')">+</button>

                                <br>


                                <button class="btn btn-outline-primary btn-block mt-1" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $contador ?>" aria-expanded="false">
                                  ver
                                </button>


                                <div class="collapse" id="collapseExample<?php echo $contador ?>">
                                  <div class="card card-body">

                                    <a target="_blank" href="../reportes/reservas.php?id=<?php echo $usuario['id_informe']; ?> ?>&id_aumento=<?php echo $key['id_aumento_reserva']; ?>">
                                      PRIMERA CUOTA
                                    </a>
                                    <?php
                                    foreach ($dato_aumento as $key) {
                                    ?>
                                      <!-- <hr class="bg-danger"> -->
                                      <a target="_blank" href="../reportes/reservas_aumento.php?id=<?php echo $usuario['id_informe']; ?>&id_aumento=<?php echo $key['id_aumento_reserva']; ?>">
                                        <?php echo htmlspecialchars($key['fecha_registro_aumento']); ?>
                                      </a>

                                      <!-- <?php
                                            if ($key['tipo_pago_aumento'] == "QR" || $key['tipo_pago_aumento'] == "TRANSFERENCIA") {
                                              echo "<a href='' class=''><i class='fas fa-upload'></i></a>";
                                            }
                                            ?> -->

                                  </div>
                                </div>

                              <?php
                                    }
                              ?>




                            <?php
                              }

                            ?>


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


                                        <input type="text" name="id_informe" value="" id="input_id" class="form-control" hidden>

                                        <div class="input-group mb-3">
                                          <input type="number" class="form-control" id="monto_aumento" name="monto" required>
                                          <div class="input-group-append">
                                            <span class="input-group-text">Bs</span>
                                          </div>
                                        </div>

                                        <script>
                                          // Función para convertir un número a palabras
                                          function numberToWords(num) {
                                            const unidades = ["", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];
                                            const decenas = ["", "DIEZ", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"];
                                            const centenas = ["", "CIENTO", "DOSCIENTOS", "TRESCIENTOS", "CUATROCIENTOS", "QUINIENTOS", "SEISCIENTOS", "SETECIENTOS", "OCHOCIENTOS", "NOVECIENTOS"];
                                            const especiales = ["DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISETE", "DIECIOCHO", "DIECINUEVE"];

                                            if (num === 0) return "CERO";
                                            if (num === 100) return "CIEN";

                                            let words = "";

                                            if (num >= 1000000) {
                                              let millones = Math.floor(num / 1000000);
                                              words += `${numberToWords(millones)} MILLÓN${millones > 1 ? "ES" : ""} `;
                                              num %= 1000000;
                                            }

                                            if (num >= 1000) {
                                              let miles = Math.floor(num / 1000);
                                              if (miles === 1) {
                                                words += "MIL ";
                                              } else {
                                                words += `${numberToWords(miles)} MIL `;
                                              }
                                              num %= 1000;
                                            }

                                            if (num >= 100) {
                                              let centenasIndex = Math.floor(num / 100);
                                              if (centenasIndex === 1 && num % 100 === 0) {
                                                words += "CIEN ";
                                              } else {
                                                words += `${centenas[centenasIndex]} `;
                                              }
                                              num %= 100;
                                            }

                                            if (num >= 20) {
                                              let decenasIndex = Math.floor(num / 10);
                                              words += `${decenas[decenasIndex]}`;
                                              num %= 10;
                                              if (num > 0) {
                                                words += ` Y ${unidades[num]}`;
                                              }
                                            } else if (num >= 10) {
                                              words += `${especiales[num - 10]}`;
                                            } else if (num > 0) {
                                              words += `${unidades[num]}`;
                                            }

                                            return words.trim();
                                          }

                                          // Función para actualizar el campo de texto con el número en palabras
                                          function actualizarLiteral() {
                                            const inputNumero = document.getElementById('monto_aumento');
                                            const inputLiteral = document.getElementById('monto_literal');
                                            const valor = parseFloat(inputNumero.value);

                                            if (!isNaN(valor)) {
                                              const enteros = Math.floor(valor);
                                              const decimales = Math.round((valor - enteros) * 100);
                                              let palabras = numberToWords(enteros);

                                              if (decimales > 0) {
                                                palabras += ` CON ${decimales.toString().padStart(2, '0')}/100 BOLIVIANOS`;
                                              } else {
                                                palabras += ` 00/100 BOLIVIANOS`;
                                              }

                                              inputLiteral.value = palabras;
                                            } else {
                                              inputLiteral.value = "";
                                            }
                                          }

                                          // Añadir event listener para el campo de entrada
                                          document.getElementById('monto_aumento').addEventListener('input', actualizarLiteral);
                                        </script>
                                      </div>

                                      <div class="form-group">
                                        <label for="">LITERAL</label>
                                        <input type="text" name="monto_literal" id="monto_literal" class="form-control" placeholder="MONTO LITERAL">
                                      </div>


                                      <div class="form-group">
                                        <label for="">Metodo de Pago</label>
                                        <select name="pago" id="" class="form-control" required>
                                          <option value="EFECTIVO">EFECTIVO</option>
                                          <option value="QR">QR</option>
                                          <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <label for="">Numero de Recibo</label>
                                        <input type="number" name="recibo" id="" class="form-control" required>
                                      </div>
                                      <div class="form-group">
                                        <label for="">Por Concepto de</label>
                                        <textarea class="form-control" name="concepto" id="" cols="30" rows="2"></textarea>
                                      </div>

                                      <input type="date" id="agenda" name="fecha_registro" class="form-control" readonly hidden>


                                      <script>
                                        document.addEventListener('DOMContentLoaded', (event) => {
                                          const today = new Date();
                                          const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                                          document.getElementById('agenda').value = formattedDate;
                                        });
                                      </script>




                                      <button type="submit" class="btn btn-primary btn-block">REGISTRAR</button>
                                    </form>

                                  </div>
                                </div>
                              </div>
                            </div>


                            <td>
                              <?php echo $usuario['tipo_pago'] . "<br>"; ?>
                              <?php echo "<b class='text-primary'>" . $usuario['plan'] . "<b>"; ?>
                            </td>



                            <td>
                              <?php
                              if (!$usuario['tipo_pago'] == "") {
                                echo date('d-m-Y', strtotime($usuario['fecha_registro']));
                              }
                              ?>

                            </td>




                            <td>
                              <?php
                              if (!$usuario['tipo_pago'] == "") {
                              ?>
                                <div class="date-input-container">
                                  <input type="date" name="fecha_fin" class="fecha_fin" value="<?php echo $usuario['fecha_cierre']; ?>" data-id="<?php echo $usuario['id_informe']; ?>">
                                </div>
                              <?php
                              }
                              ?>


                            </td>


                            <td class="dias-restantes" id="dias-<?php echo $usuario['id_informe']; ?>">
                              <?php
                              if (!$usuario['tipo_pago'] == "") {
                                if ($usuario['dias'] > 0) {
                                  echo 'Faltan <button type="button" class="btn btn-primary"><span class="badge badge-light"> ' . $usuario['dias'] . ' </span> días</button> para el Cierre';
                                } elseif ($usuario['dias'] == 0) {
                                  echo '<span class="text-success">El Cierre es hoy</span>';
                                } else {
                                  echo '<span class="text-danger">Expiro el dia del Cierre LIBERAR</span>';
                                }
                              }
                              ?>
                            </td>




                            <td>

                              <?php if ($usuario['estado_reporte'] == 0 and $usuario['estado_cierre'] == 0) { ?>
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

                              } else {
                                if ($usuario['estado_reporte'] == 0 and $usuario['estado_cierre'] == 1) {
                                ?>
                                  <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                      OPCIONES
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item disabled"><i class="fas fa-ban"></i> Cierre</a>
                                    </div>
                                  </div>
                                  <a class="btn btn-outline-primary" target="_blank" href="../reporte_cierre/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> CONTADO</a>

                                  <?php
                                } else {
                                  if ($usuario['estado_reporte'] == 0 and $usuario['estado_cierre'] == 2) {
                                  ?>
                                    <div class="btn-group" role="group">
                                      <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        OPCIONES
                                      </button>
                                      <div class="dropdown-menu">
                                        <a class="dropdown-item disabled"><i class="fas fa-ban"></i> Cierre</a>
                                      </div>
                                    </div>
                                    <a class="btn btn-outline-primary" target="_blank" href="../reporte_cierre_semicontado/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> SEMICONTADO</a>
                                    <?php
                                  } else {
                                    if ($usuario['estado_reporte'] == 0 and $usuario['estado_cierre'] == 3) {
                                    ?>
                                      <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                          OPCIONES
                                        </button>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item disabled"><i class="fas fa-ban"></i> Cierre</a>
                                        </div>
                                      </div>
                                      <a class="btn btn-outline-primary" target="_blank" href="../reporte_cierre_credito/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> CREDITO</a>
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
                                      <br>
                                      <a class="btn btn-outline-primary" target="_blank" href="../reporte_liberacion/index.php?id=<?php echo $usuario['id_informe']; ?>"><i class="fas fa-print fa-1x"></i> LIBERACION</a>
                                  <?php
                                    }
                                  }

                                  ?>

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



<?php include('../../layout/admin/parte2.php'); ?>



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

    switch (option) {
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