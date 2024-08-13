<?php
 include ('../../app/config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {


   
    include ('../../app/config/conexion.php');
    
    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
    
    include ('../../layout/admin/parte1.php');

    


    $id_contacto=$_POST['id_contacto'];
    $id_usuario=$_POST['id_usuario'];


    // agendar
    $fecha_visita=$_POST['fecha_visita'];
    $numero_visitantes=$_POST['numero_visitantes'];

    $query_cliente = $pdo->prepare("SELECT * FROM tb_clientes WHERE id_contacto_fk='$id_contacto' AND id_usuario_fk='$id_usuario'");

    $query_cliente->execute();

    $usuarios = $query_cliente->fetchAll(PDO::FETCH_ASSOC);

    $contador=0;

    foreach ($usuarios as $usuario) {
        $contador=$contador+1;          
    }


    if ($contador==0) {

            $nombre=$_POST['nombre'];
            $apellido=$_POST['apellido'];
            $celular=$_POST['celular'];
            $urbanizacion=$_POST['urbanizacion'];
            $llamada=$_POST['llamada'];
            $fecha_registro=$_POST['fecha_registro'];
            $detalle=$_POST['detalle'];

        
            $sql = $pdo->prepare('INSERT INTO tb_clientes (
            nombres, apellidos, tipo_urbanizacion, reprogramar, detalle_llamada, detalle, fecha_registro, created_at, updated_at, estado, id_usuario_fk, id_contacto_fk )VALUES( :nombres, :apellidos, :tipo_urbanizacion, :reprogramar, :detalle_llamada, :detalle, :fecha_registro, :created_at, :updated_at, :estado, :id_usuario_fk, :id_contacto_fk)');
        
            $reprogramar="NO";
            
            $sql->bindParam(':nombres',$nombre);
            $sql->bindParam(':apellidos',$apellido);
            $sql->bindParam(':tipo_urbanizacion',$urbanizacion);
            $sql->bindParam(':reprogramar',$reprogramar);
            $sql->bindParam(':detalle_llamada',$llamada);
            $sql->bindParam(':detalle',$detalle);
            $sql->bindParam(':fecha_registro',$fecha_registro);
            $sql->bindParam(':created_at',$fechayhora);
            $sql->bindParam(':updated_at',$fechayhora);
            $sql->bindParam(':estado',$estado);
            $sql->bindParam(':id_usuario_fk',$id_usuario);
            $sql->bindParam(':id_contacto_fk',$id_contacto);
        
            if ($sql->execute()) {
        
                $sentencia = $pdo->prepare('UPDATE tb_contactos SET estado=:estado WHERE id_contacto=:id_contacto');
                $estado="0";
                $sentencia->bindParam(':estado',$estado);
                $sentencia->bindParam(':id_contacto',$id_contacto);
            
                $sentencia->execute();
            
            }




    }
    else{

        $detalle = $_POST['detalle'];
        $detalle2 = $_POST['detalle2'];
        $detalle_unido = ($detalle) . "\n* " . ($detalle2);

        $urbanizacion=$_POST['urbanizacion'];
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $llamada=$_POST['llamada'];


        $sentencia = $pdo->prepare('UPDATE tb_clientes SET nombres=:nombres, apellidos=:apellidos, detalle_llamada=:detalle_llamada, tipo_urbanizacion=:tipo_urbanizacion, reprogramar=:reprogramar, fecha_llamada=:fecha_llamada, hora_llamada=:hora_llamada, detalle=:detalle WHERE id_usuario_fk=:id_usuario_fk AND id_contacto_fk=:id_contacto_fk');

        $reprogramar="NO";
        $fecha_llamada=NULL;
        $hora_llamada=NULL;

        $sentencia->bindParam(':nombres',$nombre);    
        $sentencia->bindParam(':apellidos',$apellido);
        $sentencia->bindParam(':detalle_llamada',$llamada);
        $sentencia->bindParam(':tipo_urbanizacion',$urbanizacion);
        $sentencia->bindParam(':reprogramar',$reprogramar);
        $sentencia->bindParam(':fecha_llamada',$fecha_llamada);
        $sentencia->bindParam(':hora_llamada',$hora_llamada);
        $sentencia->bindParam(':detalle',$detalle_unido);
        $sentencia->bindParam(':id_usuario_fk',$id_usuario);
        $sentencia->bindParam(':id_contacto_fk',$id_contacto);
    
        $sentencia->execute();
    }

    $query_cliente = $pdo->prepare("SELECT cli.id_cliente as id_cliente_cli, cli.id_usuario_fk as id_usuario_fk, cli.id_contacto_fk as id_contacto_fk , con.celular as celular_con, cli.nombres as nombres_cli, cli.apellidos as apellidos_cli, cli.tipo_urbanizacion as urbanizacion_cli FROM tb_clientes cli INNER JOIN tb_contactos con WHERE cli.id_contacto_fk='$id_contacto' AND cli.id_usuario_fk='$id_usuario'");


    $query_cliente->execute();

    $usuarios = $query_cliente->fetchAll(PDO::FETCH_ASSOC);


    foreach ($usuarios as $usuario) {  

        $id_cliente_cli= $usuario['id_cliente_cli'];
        $id_usuario_cli= $usuario['id_usuario_fk'];
        $id_contacto_cli= $usuario['id_contacto_fk'];
        $celular_con = $usuario['celular_con'];
        $nombre_cli = $usuario['nombres_cli'];  
        $apellido_cli = $usuario['apellidos_cli']; 
        $urbanizacion_cli=$usuario['urbanizacion_cli'];      
    }    

                                
    ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>AGENDAR CLIENTE</h1>
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
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="<?php echo $URL?>/public/dist/img/user.png"
                                        alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?php echo $nombre_cli." ".$apellido_cli?></h3>

                                    <p class="text-muted text-center"><?php echo "celular:".$celular_con?></p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Fecha Visita</b> <a class="float-right"><?php echo $fecha_visita?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Nro. de Compañantes</b> <a class="float-right"><?php echo $numero_visitantes?></a>
                                    </li>
                                    </ul>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                        
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                            <div class="card-header p-2">
                                FORMULARIO DE AGENDACION
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                <form class="container" action="controller_create_agendas.php" method="post">
                                    <div class="row">
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12" hidden>
                                                <label for="">id_cliente</label>
                                                <input class="form-control" type="text" value="<?php echo $id_cliente_cli?>" name="id_cliente" id="" readonly>
                                            </div>
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12" hidden>
                                                <label for="">id_usuario:</label>
                                                <input class="form-control" type="text" value="<?php echo $id_usuario_cli?>" name="id_usuario" id="" readonly>
                                            </div> 
                                            <div class="form-group col-lg-4 col-md-4 col-sm-12" hidden>
                                                <label for="">id_contacto</label>
                                                <input class="form-control" type="text" value="<?php echo $id_contacto_cli?>" name="id_contacto" id="" readonly>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Nombre:</label>
                                                <input class="form-control" type="text" value="<?php echo $nombre_cli?>" name="nombre" id="" readonly>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Apellidos:</label>
                                                <input class="form-control" type="text" value="<?php echo $apellido_cli?>" name="apellido" id="" readonly>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Celular:</label>
                                                <input class="form-control" type="text" value="<?php echo $celular_con?>" name="celular" id="" readonly>
                                            </div> 
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Urbanizacion:</label>
                                                <input class="form-control" type="text" value="<?php echo $urbanizacion_cli?>" name="urbanizacion" id="" readonly>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Visitantes:</label>
                                                <input class="form-control" type="text" value="<?php echo $numero_visitantes?>" name="visitantes" id="" readonly>
                                            </div> 
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <label for="">Fecha de la Visita:</label>
                                                <input class="form-control" type="text" value="<?php echo $fecha_visita?>" name="fecha_visita" id="" readonly>
                                            </div>
                                            
                                        </div>
                                        <button class="btn btn-primary btn-block" type="submit">REGISTRAR CLIENTE</button>
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
}

else {
    header('Location:'.$URL.'/admin/clientes/index.php');
    exit();

}
?>

 
