
<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');
    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>

<?php  include ('../../layout/admin/parte1.php'); ?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Detalles del Contacto</h1>
          </div><!-- /.col -->         
        </div><!-- /.row -->

     
        <!-- Main content -->
        <section class="content">
          

            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body pb-0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <?php
                                    $celular = $_POST['celular_recuperado'];

                                    $query=$pdo->prepare("SELECT us.foto_perfil, us.nombre as nombre, cli.detalle as detalle_cliente, co.created_at, co.detalle as detalle_contacto FROM tb_contactos co INNER JOIN tb_usuarios us INNER JOIN tb_clientes cli WHERE (co.celular='$celular' AND cli.id_usuario_fk = us.id_usuario) AND cli.id_contacto_fk = co.id_contacto");

                                    
                                    $query->execute();

                                    $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    foreach ($usuarios as $usuario)
                                    {
                                        
                                ?>

                                    <!-- Post -->
                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="<?php echo $URL."/admin/usuarios/".$usuario['foto_perfil'];?>" alt="User Image">
                                            <span class="username">
                                                <a href="#"><?php echo $usuario['nombre']?></a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Fecha de Creacion del Contacto - <?php echo $usuario['created_at']?></span>
                                        </div>
                                        <!-- /.user-block -->
                                        
                                        <?php
                                            if ($usuario['detalle_contacto']!="SIN DETALLES") {
                                            ?>
                                            <p>Primer Registro hecho por: 
                                                <?php echo $usuario['detalle_contacto']?>
                                            </p>
                                            <?php                                            
                                            } 
                                        ?>

                                        <p><?php echo nl2br(str_replace('*', '<br>', htmlspecialchars($usuario['detalle_cliente']))) ?></p>

                                        
                                    </div>                    
                                    <!-- /.post -->

                                
                                <?php
                                    }
                                ?>

                               
                            </div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo $URL?>/admin/clientes" class="btn btn-primary">REGRESAR</a>
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
        

      </div><!-- /.container-fluid -->
    </div>
  </div>
<?php   include ('../../layout/admin/parte2.php'); ?>
 