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
<?php  include ('../../layout/admin/parte1.php'); ?>

<?php
$id_agenda = $_GET['id'];

$sql = $pdo->prepare("SELECT  cli.nombres, cli.apellidos, con.celular, cli.tipo_urbanizacion, info.monto, info.lote, UPPER(info.manzano) manzano
FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con INNER JOIN tb_informe info
WHERE (ag.id_agenda=info.id_agenda_fk AND ag.id_cliente_fk = cli.id_cliente)
AND cli.id_contacto_fk = con.id_contacto and info.id_informe=$id_agenda");
$sql->execute();

$consulta = $sql->fetch(PDO::FETCH_ASSOC);
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">        
            <div class="col-sm-6">
            <h1 class="m-0">LIBERACION</h1>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informacion</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Nombre Cliente</strong>

                            <p class="text-muted">
                            <?php echo $consulta['nombres']." ".$consulta['apellidos']?>
                            </p>

                            <hr>

                            <strong><i class="fa fa-phone mr-1"></i> Celular</strong>
                            <p class="text-muted">(+591) <?php echo $consulta['celular'] ?></p>
                            

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Urbanizacion</strong>

                            <p class="text-muted"><?php echo $consulta['tipo_urbanizacion'] ?></p>
                     
                                                        
                        

                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Detalles</strong>

                            <p class="text-muted">
                            <B class="tag tag-danger">MANZANO: </B> <?php echo $consulta['manzano'] ?>
                            <br>
                            <B class="tag tag-success">LOTE: </B> <?php echo $consulta['lote'] ?>
                            </p>

                            <hr>
                            <strong><i class="fas fa-money-bill-wave"></i> Monto Reservado</strong>
                            <p class="text-muted"><?php echo $consulta['monto'] ?> Bolivianos</p>


                        </div>
                        <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <div class="post">                                
                                            <form class="container" action="controller_create_liberacion.php" method="post">
                                                <div class="row">
                                                    <div class="col-12" hidden>
                                                        <div class="form-group">
                                                            <label for="">ID_INFORME</label>
                                                            <input type="text" class="form-control" value="<?php echo $_GET['id']?>" name="id_informe" id="id_informe" readonly>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">RESUMEN DE LA LIBERACION DE RESERVA U OTRO SEGUN CASO</label>
                                                            <textarea class="form-control" name="resumen_liberacion" id="" cols="30" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">SIGUIENTE PASO POR EL ASESOR COMERCIAL</label>
                                                            <textarea class="form-control" name="resumen_asesor" id="" cols="30" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <input class="btn btn-outline-danger btn-block" type="submit" value="REGISTRAR">                                  
                                            </form>
                                        </div>                        
                                    </div>                   
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


