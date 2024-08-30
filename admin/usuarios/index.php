<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>


<?php
if (isset($_SESSION['session_usuarios'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/admin');
}
?>


<?php  include ('../../layout/admin/parte1.php'); ?>



  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
            <h1 class="m-0">Listado de Usuarios</h1>

          

          </div><!-- /.col -->         
        </div><!-- /.row -->
        <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header ">
                <h3 class="card-title">USUARIOS</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <script>
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
                <div class="table-responsive">
                  <table id="example" class="display " style="width:100%">
                    <thead>
                      <tr>
                        <th>Nro.</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>CI</th>
                        <th>CARGO</th>
                        <th>EMAIL</th>
                        <th>ACCIONES</th>
                      </tr>
                    </thead>

                    <tbody>
                      <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                      <?php
                        $query=$pdo->prepare("SELECT * FROM tb_usuarios WHERE estado=1");
                        $query->execute();

                        $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

                        $contador = 0;
                        foreach ($usuarios as $usuario) {
                        $contador++;

                        $id = $usuario['id_usuario'];


                        ?>
                          
                          <tr>
                            
                            <td><?php echo $contador;?></td>
                            <td><?php echo $usuario['nombre'];?></td>
                            <td><?php echo $usuario['ap_paterno']." ".$nombres=$usuario['ap_materno'];?></td>
                            <td><?php echo $usuario['ci'];?></td>
                            <td><?php echo $usuario['cargo'];?></td>
                            <td><?php echo $usuario['email'];?></td>
                            <td>
                              
                              <a href="edit.php?id=<?php echo $id;?>" type="button" class="btn btn-outline-success"><i class="fa fa-edit"></i></a>
                              <a href="delete.php?id=<?php echo $id;?>" type="button" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>


                        <?php
                        }
                        ?>
                    
                    
                    </tbody>

                    <!-- <tfoot>
                    <tr>
                      <th>Nro.</th>
                      <th>NOMBRES</th>
                      <th>APELLIDOS</th>
                      <th>CI</th>
                      <th>CARGO</th>
                      <th>EMAIL</th>
                      <th>ACCIONES</th>
                    </tr>
                    </tfoot> -->
                  </table>
                </div>
              
                
                




              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php   include ('../../layout/admin/parte2.php');
?>


 