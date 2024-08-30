<?php

include('../../app/config/config.php');
include('../../app/config/conexion.php');


include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

include('../../layout/admin/parte1.php');


if (isset($_SESSION['session_age_clientes'])) {
    // echo "existe session y paso por el login";
} else {
    // echo "no existe session por que no ha pasado por el login";
    header('Location:' . $URL . '/admin');
}


$id_agendas = $_GET['id'];

$sql = $pdo->prepare("SELECT * FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con WHERE ((ag.id_cliente_fk=cli.id_cliente) AND cli.id_contacto_fk=con.id_contacto) AND id_agenda='$id_agendas'");

$sql->execute();

$array = $sql->fetch(PDO::FETCH_ASSOC);


?>

<style>
    .input-custom {
        border: none;
        /* Quita todos los bordes del input */
        border-bottom: 2px solid blue;
        /* Línea azul en la parte inferior */
        padding: 5px;
        /* Ajusta el espacio interno del input */
        outline: none;
        /* Elimina el contorno que aparece al hacer clic en el input */
        font-size: 16px;
        /* Tamaño de la fuente del texto del input */
        /* Opcional: agrega un margen para espacio adicional */
        margin: 10px;
    }

    .input-custom:focus {
        border-bottom: 2px solid darkblue;
        /* Cambia el color de la línea al enfocar el input */
    }
</style>

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
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <p>
                                                <h4>DATOS DEL CLIENTE</h4>
                                                </p>

                                                <blockquote style="box-shadow: rgba(0, 0, 0, 0.09) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;">
                                                    <small>Nombre</small>
                                                    <input class="input-custom" type="text" value="<?php echo strtoupper($array['nombres']) ?>" class="form-control" readonly>
                                                    <br>
                                                    <small>Apellidos</small>
                                                    <input class="input-custom" type="text" value="<?php echo strtoupper($array['apellidos']) ?>" class="form-control" readonly>
                                                    <br>
                                                    <small>Celular</small>
                                                    <input class="input-custom" name="celular" type="text" value="<?php echo $array['celular'] ?>" class="form-control" readonly>
                                                    <br hidden>
                                                    <small hidden>Id_Cliente</small>
                                                    <input hidden class="input-custom" name="id_cliente" type="text" value="<?php echo $array['id_cliente'] ?>" class="form-control" readonly>
                                                    <br>
                                                    <small>Fecha Registro</small>
                                                    <input class="input-custom" type="date" name="fecha_registro" id="fecha_registro" readonly>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', (event) => {
                                                            const today = new Date();
                                                            const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                                                            document.getElementById('fecha_registro').value = formattedDate;
                                                        });
                                                    </script>
                                                </blockquote>


                                            </div>
                                            <div class="col">


                                                <label for="" hidden> id_usuario
                                                    <input type="text" value="<?php echo $id_usuario ?>" name="id_usuario" id="">
                                                </label>

                                                <div class="row">
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                        <label for="">FECHA DE LA LLAMADA</label>
                                                        <input class="form-control" type="date" value="" name="fecha" required>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                        <label for="">HORA DE LA LLAMADA</label>
                                                        <input class="form-control" type="time" value="" name="hora" required>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary btn-block" type="submit">REGISTRAR</button>
                                            </div>
                                        </div>
                                    </div>

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

include('../../layout/admin/parte2.php');
?>