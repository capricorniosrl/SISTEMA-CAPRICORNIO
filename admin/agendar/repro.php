<?php

include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

 
include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');

include ('../../layout/admin/parte1.php');


$id_agendas = $_GET['id'];
$estado=0;    

$sql = $pdo->prepare('UPDATE tb_agendas SET estado=:estado WHERE id_agenda=:id_agenda');
$sql->bindParam(':estado',$estado);
$sql->bindParam(':id_agenda',$id_agendas);
    
if ($sql->execute()) {

    $buscar = $pdo->prepare("SELECT * FROM tb_agendas WHERE id_agenda=$id_agendas");
    $buscar->execute();
    $array = $buscar->fetch(PDO::FETCH_ASSOC);

    $id_cliente = $array['id_cliente_fk'];  
    $id_usuario = $array['id_usuario_fk'];       
}?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>REAGENDAR CLIENTE</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="tab-content">
                                    <form class="container" action="controller_reprogramar.php" method="post">
                                        <label for=""> id_cliente
                                        <input type="text" value="<?php echo $id_cliente?>" name="id_cliente"  id="">
                                        </label>

                                        <label for=""> id_usuario
                                        <input type="text" value="<?php echo $id_usuario?>" name="id_usuario"  id="">
                                        </label>

                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">FECHA DE LA LLAMADA</label>
                                                <input class="form-control" type="date" value="" name="fecha">
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">HORA DE LA LLAMADA</label>
                                                <input class="form-control" type="time" value="" name="hora">
                                            </div> 
                                        </div>
                                        
                                        <button class="btn btn-primary btn-block" type="submit">REGISTRAR</button>
                                    </form>
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
<?php

include ('../../layout/admin/parte2.php'); 
?>

