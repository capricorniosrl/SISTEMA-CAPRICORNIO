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
}
?>

<script>
  (async () => {
  const { value: accept } = await Swal.fire({
    title: "EL CLIENTE SE TE FUE DESIGNADO POR OTRO ASESOR",
    input: "checkbox",
    inputValue: 1,
    inputPlaceholder: `
      Quiere registrar al Cliente en su Base de Datos
    `,
    confirmButtonText: `
      Continue&nbsp;<i class="fa fa-arrow-right"></i>
    `,
    inputValidator: (result) => {
      return !result && "Debe estar deacuerdo para poder registrarlo al Cliente";
    }
  });
})()
</script>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registrar Nuevo CLiente</h1>
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
                                    <form  action="controller_repro.php" method="post">
                                        <?php                                        
                                        $id = $_GET['id'];
                                        $sql = $pdo->prepare("SELECT con.id_contacto, con.celular, cli.nombres, cli.apellidos, cli.tipo_urbanizacion, ag.detalle_agenda FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con WHERE (ag.id_agenda=$id and ag.id_cliente_fk=cli.id_cliente) AND cli.id_contacto_fk=con.id_contacto");
                                        $sql->execute();
                                        $contenido = $sql->fetch(PDO::FETCH_ASSOC);   
                                            // echo "<pre>";
                                            // print_r($contenido);
                                            // echo "</pre>";

                                        ?>

                                        <label for=""> id_contacto                                        
                                            <input hidden  type="text" value="<?php echo $contenido['id_contacto'] ?>" name="id_contacto"  id="" >
                                        </label>

                                        <label for=""> id_agenda 
                                        <input  hidden type="text" value="<?php echo $id?>" name="id_agenda"  id=""  >
                                        </label>


                                        <div class="row">
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="">CELULAR</label>
                                                    <input class="form-control" type="text" name="celular" id="" value="<?php echo $contenido['celular'] ?>">
                                                
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <label for="">NOMBRES</label>
                                                    <input class="form-control" type="text" name="nombres" id="" value="<?php echo $contenido['nombres'] ?>">
                                                
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="">APELLIDOS</label>
                                                    <input class="form-control" type="text" name="apellidos" id="" value="<?php echo $contenido['apellidos'] ?>">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="">FECHA DE LLAMADA</label>
                                                    <input class="form-control" type="date" name="fecha_llamada" id="" value="">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="">HORA DE LLAMADA</label>
                                                    <input class="form-control" type="time" name="hora_llamada" id="" value="">
                                            </div>

                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="">URBANIZACION</label>
                                                <input class="form-control" type="text" name="tipo_urbanizacion" id="" value="<?php echo $contenido['tipo_urbanizacion'] ?>">
                                            </div>
                                            <div hidden class="col-12 col-sm-12 form-group">
                                                <label for="">DETALLE2</label>
                                                    <textarea class="form-control" name="detalle2" id="" cols="30" rows="2" readonly ><?php echo $contenido['detalle_agenda'] ?></textarea>
                                            </div>
                                            <div class="col-12 col-sm-12 form-group">
                                                <label for="">DETALLE</label>
                                                    <textarea class="form-control" name="detalle" id="" cols="30" rows="2" required></textarea>
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

