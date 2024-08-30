<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
// Definir la página actual en base a la URL

?>
<?php
if (isset($_SESSION['importaciones'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
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
                    <table id="example" class="display " style="width:100%">
                      <thead>
                        <tr>
                          <th>Nro.</th>
                          <th>NOMBRES DEL CLIENTE</th>
                          <th>CELULAR</th>
                          <th>CORREO</th>
                          <th>PRODUCTO</th>
                          <th>OBSERVACIONES</th>
                          <th>FECHA REGISTRO</th>
                          <th>ACCIONES</th>
                        </tr>
                      </thead>

                      <tbody>
                        <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                        <?php


                        $query = $pdo->prepare("SELECT * FROM tb_clientes_importacion ORDER BY fecha_registro_imp ASC");

                        $query->execute();
                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                        $contador = 0;



                        foreach ($usuarios as $usuario) {

                          $id_cli_impor = $usuario['id_cliente_imp'];

                          $contador++;


                        ?>

                          <tr>

                            <td><?php echo $contador; ?></td>
                            <td><?php echo $usuario['nombre_completo']; ?></td>
                            <td><?php echo $usuario['celular']; ?></td>
                            <td><?php echo $usuario['email']; ?></td>
                            <td><?php echo $usuario['producto']; ?></td>
                            <td><?php echo $usuario['obs_contacto']; ?></td>
                            <td><?php echo $usuario['fecha_registro_imp']; ?></td>

                            <td>

                              <a href="" type="button" class="btn btn-outline-success"><i class="fa fa-edit"></i></a>
                              <a href="reporte_importacion.php?id=<?php echo $id_cli_impor ?>" type="button" class="btn btn-outline-primary"><i class="fas fa-print"></i></a>

                            </td>
                          </tr>


                        <?php
                        }
                        ?>


                      </tbody>

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