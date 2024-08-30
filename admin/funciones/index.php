<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
// Definir la página actual en base a la URL

?>

<?php
if (isset($_SESSION['session_funciones'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>

<?php include('../../layout/admin/parte1.php'); ?>
<!-- Select2 -->
<link rel="stylesheet" href="../../public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Asignar Funciones</h1>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


      <!-- ventana modal para actualizar cargo -->
      <!-- Modal -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title" id="exampleModalLongTitle">Actualizacion de Cargo</h5>
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

                  <input type="text" id="input_id" name="id_cargo" class="form-control" hidden>

                  <label for="first-name-icon">Nombre del Cargo</label>
                  <div class="position-relative">
                    <input type="text" class="form-control"
                      id="input_nombre" name="nombre_cargo">
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
                <form method="POST" action="controller_create_funciones.php">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-6 ">
                        <div class="form-group">
                          <label>Lista de Usuarios</label>
                          <select id="cliente_id" name="cliente_id" class="form-control select2 select2-primary" data-dropdown-css-class="select2-primary" style="width: 100%;" required>
                            <option value="" selected>Seleccione un Usuario</option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM tb_usuarios");
                            $query->execute();
                            $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($usuarios as $usuario) {
                            ?>
                              <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre'] . " " . $usuario['ap_paterno'] . " " . $usuario['ap_materno']; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Seleccionar Las Funciones</label>
                          <select class="select2" multiple="multiple" name="funciones[]" data-placeholder="Seleccionar Funciones" style="width: 100%;">
                            <option value="CARGO">REGISTRAR CARGO</option>
                            <option value="FUNCIONES">REGISTRAR FUNCIONES</option>
                            <option value="URBANIZACIONES">REGISTRAR URBANIZACIONES</option>
                            <option value="USUARIOS">REGISTRAR USUARIOS</option>
                            <option value="CONTRASEÑAS">RESTABLECER CONTRASEÑAS</option>
                            <option value="REG_CLIENTES" selected>REGISTRAR CLIENTES</option>
                            <option value="AGE_CLIENTES" selected>AGENDAR CLIENTES</option>
                            <option value="RESERVAS" selected>CONTROL DE RESERVAS</option>
                            <option value="DESIGNAR">BUSCAR Y DESIGNAR</option>
                            <option value="REPORTES">GENERAR REPORTES</option>
                            <option value="CIERRE_DIRECTO" selected>CIERRES DIRECTOR</option>
                            <option value="BUSQUEDA_CIERRES">BUSQUEDA DE CIERRES</option>
                            <option value="LISTA_CIERRES">LISTA DE CIERRES</option>
                            <option value="LEGAL">LEGAL</option>
                            <option value="IMPORTACIONES">IMPORTACIONES</option>
                          </select>
                        </div>
                        <script>
                          $(document).ready(function() {
                            // Inicializa Select2
                            $('.select2').select2({
                              // templateResult: formatState,
                              templateSelection: formatState
                            });

                            // Función para formatear las opciones
                            function formatState(state) {
                              if (!state.id) {
                                return state.text;
                              }

                              // Mapear cada opción a un icono
                              var icons = {
                                'CARGO': 'fa-id-card',
                                'FUNCIONES': 'fa-tasks',
                                'URBANIZACIONES': 'fa-layer-group',
                                'USUARIOS': 'fa-user',
                                'CONTRASEÑAS': 'fa-key',
                                'REG_CLIENTES': 'fa-users',
                                'AGE_CLIENTES': 'fa-address-book',
                                'RESERVAS': 'fa-map-marked-alt',
                                'DESIGNAR': 'fa-search',
                                'REPORTES': 'fa-clipboard-list',
                                'CIERRE_DIRECTO': 'fa-donate',
                                'BUSQUEDA_CIERRES': 'fa-file-alt',
                                'LISTA_CIERRES': 'fa-list-alt',
                                'LEGAL': 'fa-file-contract',
                                'IMPORTACIONES': 'fa-ship'
                              };

                              var $state = $('<span><i class="fas ' + (icons[state.id] || 'fa-question') + '"></i> ' + state.text + '</span>');
                              return $state;
                            }
                          });
                        </script>


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
                          "emptyTable": "No hay información de los Clientes con Funciones",
                          "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes con Funciones",
                          "infoEmpty": "Mostrando 0 a 0 de 0 Clientes con Funciones",
                          "infoFiltered": "(Filtrado de _MAX_ total Clientes con Funciones)",
                          "infoPostFix": "",
                          "thousands": ",",
                          "lengthMenu": "Mostrar _MENU_ Clientes con Funciones",
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
                          <th>NOMBRES DEL CARGO</th>
                          <th>FUNCIONES DESIGNADAS</th>
                        </tr>
                      </thead>

                      <tbody>
                        <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                        <?php


                        $query = $pdo->prepare("SELECT us.id_usuario, us.nombre, us.ap_paterno, us.ap_materno FROM tb_usuarios us INNER JOIN tb_funciones fun WHERE fun.id_usuario_fk=us.id_usuario GROUP BY us.nombre");

                        $query->execute();

                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                        $contador = 0;

                        foreach ($usuarios as $usuario) {

                          $contador++;
                          $id_user = $usuario['id_usuario'];
                        ?>

                          <tr>

                            <td><?php echo $contador; ?></td>
                            <td><?php echo $usuario['nombre'] . " " . $usuario['ap_paterno'] . " " . $usuario['ap_materno']; ?></td>

                            <td>




                              <div style="min-height: 120px;">
                                <div class="card card-body" style="width: 320px;">
                                  <ul>
                                    <?php
                                    $queryfunciones = $pdo->prepare("SELECT fun.id_funciones, us.nombre, us.ap_paterno, us.ap_materno, fun.nombre_funcion FROM tb_usuarios us INNER JOIN tb_funciones fun WHERE fun.id_usuario_fk=us.id_usuario AND us.id_usuario=$id_user");

                                    $queryfunciones->execute();
                                    $funciones = $queryfunciones->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($funciones as $dato_funcion) {

                                    ?>

                                      <li><?php echo $dato_funcion['nombre_funcion'] ?>

                                        <a class="text-danger" href="javascript:void(0);" onclick="eliminarFuncion('<?php echo $dato_funcion['id_funciones']; ?>', this)">
                                          <i class="far fa-times-circle"></i>
                                        </a>
                                      </li>
                                    <?php
                                    }
                                    ?>
                                  </ul>
                                </div>
                              </div>

                            </td>

                          </tr>


                        <?php
                        }
                        ?>


                      </tbody>

                      <tfoot>
                        <tr>
                          <th>Nro.</th>
                          <th>NOMBRES DEL CARGO</th>
                          <th>FUNCIONES DESIGNADAS</th>
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


<?php include('../../layout/admin/parte2.php'); ?>
<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>
<script>
  // $(function() {
  //   $('.select2').select2();
  // });
</script>

<script>
  function eliminarFuncion(idFuncion, elemento) {
    Swal.fire({
      title: "¿Está seguro?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "¡Sí, eliminarlo!",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: 'delete_funcion.php',
          type: 'POST',
          data: {
            id: idFuncion
          },
          success: function(response) {
            if (response == 'success') {
              $(elemento).closest('li').remove();
              const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.onmouseenter = Swal.stopTimer;
                  toast.onmouseleave = Swal.resumeTimer;
                }
              });
              Toast.fire({
                icon: "success",
                title: "La función ha sido eliminada."
              });
            } else {
              Swal.fire({
                title: "Error",
                text: "Hubo un error al eliminar la función.",
                icon: "error"
              });
            }
          }
        });
      }
    });
  }
</script>