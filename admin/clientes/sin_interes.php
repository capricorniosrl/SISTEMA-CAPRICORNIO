<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['session_reg_clientes'])) {
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
            <h1 class="m-0">LISTADO DE CLIENTES YA NO INTERESADOS EN LOS TERRENOS</h1>
          </div><!-- /.col -->         
        </div><!-- /.row -->
        <!-- /.card -->
        <div class="card card-danger">
            <div class="card-header ">
            <h3 class="card-title">LISTA DE CLIENTES NO INTERESADOS</h3>
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
                    <th>NOMBRE</th>
                    <th>CONTACTO</th>
                    <th>SEGUIMIENTO</th>
                    <th>FECHA DE REGISTRO</th>
                    </tr>
                </thead>

                <tbody>
                    <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                    <?php
                    $query=$pdo->prepare("SELECT con.id_contacto, con.id_usuario_fk, con.celular, con.detalle, cli.nombres, cli.apellidos, cli.id_cliente, cli.nombres, cli.apellidos, cli.detalle, cli.fecha_registro FROM tb_contactos con INNER JOIN tb_clientes cli WHERE
                    ((con.id_contacto=cli.id_contacto_fk) AND cli.detalle_llamada='SIN_INTERES') AND cli.id_usuario_fk='$id_usuario'");

                    $query->execute();
                    

                    $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

                    $contador = 0;
                    foreach ($usuarios as $usuario) {
                    $contador++;
                    ?>
                        
                        <tr>
                        
                            <td><?php echo $contador;?></td>
                            <td><?php echo $usuario['nombres']." ".$usuario['apellidos'];?></td>
                            <td><?php echo $usuario['celular'];?></td>                                                   
                            <td class="text-danger"><?php
                                // Obtener el contenido del mensaje
                                $detalle = $usuario['detalle'];

                                // Usar preg_match para obtener el último mensaje después de un asterisco
                                if (preg_match('/[^*]+\*([^*]+)$/', $detalle, $matches)) {
                                    $mensaje_a_mostrar = trim($matches[1]);
                                } else {
                                    $mensaje_a_mostrar = trim($detalle);
                                }

                                // Mostrar el mensaje
                                echo htmlspecialchars($mensaje_a_mostrar);
                            ?></td>
                            <td><?php echo $usuario['fecha_registro'];?></td> 
                        </tr>
                    <?php
                    }
                    ?>        
                
                </tbody>

                <tfoot>
                <tr>
                    <th>Nro.</th>
                    <th>NOMBRE</th>
                    <th>CONTACTO</th>
                    <th>SEGUIMIENTO</th>
                    <th>FECHA DE REGISTRO</th>
                </tr>
                </tfoot>
                </table>
            </div>
            
         



            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <script src="script.js"></script>
<?php   include ('../../layout/admin/parte2.php');
?>


 