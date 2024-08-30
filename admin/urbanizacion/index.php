<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
// Definir la página actual en base a la URL

?>
<?php
if (isset($_SESSION['session_urbanizaciones'])) {
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
          <h1 class="m-0">Registro de Urbanizacion</h1>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- ventana modal para actualizar Urbanizacion -->

      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title" id="exampleModalLongTitle">Actualizacion de la Urbanizacion</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="formulario2" novalidate>
                <!-- ALERTA -->

                <div class="alert alert-danger alert-dismissible d-none" id="mensajeerror2">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <i class="icon fas fa-ban"></i> Se Registraron los Siguientes errores<h5><span id="msjerror2"></span> </h5>
                </div>
                <!-- FIN DE ALERTA -->

                <div class="form-group has-icon-left">

                  <input type="text" id="input_id" name="id_urbanizacion" class="form-control" hidden>

                  <label for="first-name-icon">Nombre de la Urbanizacion</label>
                  <div class="position-relative">
                    <input type="text" class="form-control"
                      id="input_nombre" name="nombre_urbanizacion">
                  </div>

                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">REGISTRAR</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>



      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">
                    <small>Llene la informacion con mucho cuidado</small>
                  </h3>
                </div>
                <!-- form start -->
                <form id="formulario" novalidate>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 ">

                        <!-- ALERTA -->
                        <div class="alert alert-success alert-dismissible d-none" id="msjexito">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <h5><i class="icon fas fa-check"></i></h5>
                          Registro con exito
                        </div>

                        <div class="alert alert-danger alert-dismissible d-none" id="mensajeerror">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <i class="icon fas fa-ban"></i> Se Registraron los Siguientes errores<h5><span id="msjerror"></span> </h5>
                        </div>
                        <!-- FIN DE ALERTA -->


                        <div class="form-group">
                          <label for="nombre">Nombres de la Urbanizacion<span class="text-danger">(*)</span> </label>
                          <input type="text" name="nombre" id="nombre" class="form-control" id="nombre" placeholder="Ingrese Nombre de la Urbanizacion" required />
                        </div>


                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <a href="<?php echo $URL; ?>/admin/" class="btn btn-default">CANCELAR</a>
                    <button type="submit" class="btn btn-primary">REGISTRAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->




      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <!-- /.card-header -->
                <div class="card-body">

                  <script>
                    $(document).ready(function() {
                      $('#example').DataTable({
                        "pageLength": 10,
                        "language": {
                          "emptyTable": "No hay información de los Urbanizacion",
                          "info": "Mostrando _START_ a _END_ de _TOTAL_ Urbanizacion",
                          "infoEmpty": "Mostrando 0 a 0 de 0 Urbanizacion",
                          "infoFiltered": "(Filtrado de _MAX_ total Urbanizacion)",
                          "infoPostFix": "",
                          "thousands": ",",
                          "lengthMenu": "Mostrar _MENU_ Urbanizacion",
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
                    <table id="example" class="display " style="width:100%">
                      <thead>
                        <tr>
                          <th>Nro.</th>
                          <th>NOMBRES DE LA URBANIZACION</th>
                          <th>ACCIONES</th>
                        </tr>
                      </thead>

                      <tbody>
                        <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                        <?php

                        $query = $pdo->prepare("SELECT * FROM tb_urbanizacion ORDER BY id_urbanizacion ASC");

                        $query->execute();

                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                        $contador = 0;

                        foreach ($usuarios as $usuario) {

                          $datos_cargo = $usuario['id_urbanizacion'] . "||" . $usuario['nombre_urbanizacion'];


                          $contador++;
                          $id = $usuario['id_urbanizacion'];


                        ?>

                          <tr>

                            <td><?php echo $contador; ?></td>
                            <td><?php echo $usuario['nombre_urbanizacion']; ?></td>
                            <td>

                              <?php

                              if ($usuario['estado'] == 1) {
                              ?>
                                <a href="" type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter" onclick="modal_tarjeta('<?php echo $datos_cargo ?>')"><i class="fa fa-edit"></i></a>

                                <a href="" type="button" class="btn btn-outline-danger" data-toggle="modal" onclick="eliminar_consulta('<?php echo $datos_cargo ?>')"><i class="fa fa-trash"></i></a>
                              <?php
                              } elseif ($usuario['estado'] == 0) {
                              ?>
                                <a href="" type="button" class="btn btn-outline-success" data-toggle="modal" onclick="reciclar('<?php echo $datos_cargo ?>')"><i class="fa fa-recycle"></i></a>
                              <?php
                              }
                              //echo "estado: ".$usuario['estado']
                              ?>

                            </td>
                          </tr>
                          <script>
                            function eliminar_consulta(a) {
                              let partes = a.split("||");
                              let num = partes[0];
                              let text = partes[1];
                              //console.log("num: ",num,"text: ",text);
                              Swal.fire({
                                title: "Estas Seguro de Eliminar el cargo?",
                                showDenyButton: true,
                                confirmButtonText: "Cancelar",
                                denyButtonText: `Eliminar`
                              }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                  Swal.fire("No se elimino nada!", "", "info");
                                } else if (result.isDenied) {

                                  console.log("numerrito:: " + num);
                                  location.reload();
                                  $.ajax({
                                    type: "POST",
                                    url: "controller_delete.php",
                                    data: {
                                      datos_cargo: num
                                    },
                                    success: function(data) {
                                      console.log(data);
                                    }
                                  });
                                  Swal.fire("Exterminado", "", "success");

                                }
                              });
                            }

                            function reciclar(a) {
                              let partes = a.split("||");
                              let num = partes[0];
                              let text = partes[1];
                              //console.log("num: ",num,"text: ",text);
                              Swal.fire({
                                title: "Estas Seguro de Recuperar el cargo?" + text,
                                showDenyButton: true,
                                confirmButtonText: "Cancelar",
                                denyButtonText: `Recuperar`
                              }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                  Swal.fire("No se elimino nada!", "", "info");
                                } else if (result.isDenied) {

                                  console.log("numerrito:: " + num);
                                  location.reload();
                                  $.ajax({
                                    type: "POST",
                                    url: "controller_recuperar.php",
                                    data: {
                                      datos_cargo: num
                                    },
                                    success: function(data) {
                                      console.log(data);
                                    }
                                  });



                                  Swal.fire("Recuperado con exito", "", "success");

                                }
                              });
                            }
                          </script>
                        <?php
                        }
                        ?>


                      </tbody>

                      <tfoot>
                        <tr>
                          <th>Nro.</th>
                          <th>NOMBRES DE LA URBANIZACION</th>
                          <th>ACCIONES</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>

                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
        </div>
      </section>





    </div>
    <!-- /.container-fluid -->
  </div>
</div>


<script>
  var URL = "<?php echo $URL; ?>";
</script>
<script src="script.js"></script>


<?php include('../../layout/admin/parte2.php'); ?>