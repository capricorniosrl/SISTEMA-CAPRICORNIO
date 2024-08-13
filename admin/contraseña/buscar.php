<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>
   <?php
if (isset($_SESSION['session_designar'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/admin');
}
?>
<?php  include ('../../layout/admin/parte1.php'); ?>
 
<!-- Select2 -->
<link rel="stylesheet" href="../../public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Control de Clientes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Control de Asistencia de Clientes</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row d-flex justify-content-center">
              <div class="col-md-6">
                <form id="buscarUsuarioForm">
                    <div class="form-group">
                        <label>Lista de Usuarios</label>
                        <select id="selectUsuario" class="form-control select2 select2-primary" data-dropdown-css-class="select2-info" style="width: 100%;" required>
                            <option value="" selected>Seleccione un Usuario</option>
                                <?php
                                $query=$pdo->prepare("SELECT * FROM tb_usuarios");
                                $query->execute();
                                $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($usuarios as $usuario) {
                                ?>
                                    <option value="<?php echo $usuario['id_usuario'];?>"><?php echo $usuario['nombre']." ".$usuario['ap_paterno']." ".$usuario['ap_materno'];?></option>
                                <?php
                                }
                                ?>
                        </select>                    
                    </div>
                </form>                    
              </div>       
            </div>        
          </div>
        </div>

        <div class="card">
          <div class="card-header ">
            <h3 class="card-title">Listado de Clientes</h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="example" class="display" style="width:100%">
                <thead>
                  <tr>
                    <th>Nro.</th>
                    <th>NOMBRE CLIENTE</th>
                    <th>CELULAR</th>
                    <th>CONTRASEÑA</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody id="tablaUsuarios">
                  <!-- Aquí se llenarán los datos con AJAX -->
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nro.</th>
                    <th>NOMBRE CLIENTE</th>
                    <th>CELULAR</th>
                    <th>CONTRASEÑA</th>
                    <th>ACCIONES</th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <script>
              $(document).ready(function () {
                  $('#selectUsuario').on('change', function () {
                      var usuarioId = $(this).val();

                      $.ajax({
                          url: 'buscar_usuario.php',
                          type: 'POST',
                          data: { usuario_id: usuarioId },
                          success: function (response) {
                              $('#tablaUsuarios').html(response);
                          },
                          error: function () {
                              alert('Error al cargar los datos del usuario');
                          }
                      });
                  });

              });
              $(document).ready(function() {
                      $('#example').DataTable( {
                          "pageLength": 10,
                          "language": {
                              "emptyTable": "No hay información",
                              "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                              "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                              "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                              "infoPostFix": "",
                              "thousands": ",",
                              "lengthMenu": "Mostrar _MENU_ Usuarios",
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
                  } );

             
            </script>
          </div>
        </div>
      </div>
    </section>
</div>

<?php include ('../../layout/admin/parte2.php'); ?>

<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function () {
    $('.select2').select2();
  });
</script>
