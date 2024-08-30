<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

if (isset($_SESSION['session_age_clientes'])) {
    // echo "existe session y paso por el login";
} else {
    // echo "no existe session por que no ha pasado por el login";
    header('Location:' . $URL . '/admin');
}
?>
<?php include('../../layout/admin/parte1.php'); ?>

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
                    <h1>Designacion y Apoyo</h1>
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
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">DESIGNACION DE USUARIO</h3>
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





                                        <?php
                                        $id_agenda = $_GET['id'];
                                        $query_agenda = $pdo->prepare("SELECT * FROM tb_agendas WHERE id_agenda=$id_agenda");
                                        $query_agenda->execute();
                                        $usuarios = $query_agenda->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($usuarios as $usuario) {
                                        ?>
                                            <label hidden for="">id_cliente_fk
                                                <input type="text" name="id_cliente_fk" value="<?php echo $usuario['id_cliente_fk'] ?>">
                                            </label>
                                            <label hidden for="">id_agenda
                                                <input type="text" name="id_agenda" value="<?php echo $usuario['id_agenda'] ?>">
                                            </label>
                                            <label hidden for="">id_usuario
                                                <input type="text" name="id_usuario_fk_creador" value="<?php echo $usuario['id_usuario_fk'] ?>">
                                            </label>
                                        <?php
                                        }
                                        ?>



                                        <div class="form-group">
                                            <label>DESIGNAR AL ASESOR</label>
                                            <select id="selectUsuario1" name="usuario_designado" class="form-control select2 select2-primary" data-dropdown-css-class="select2-info" style="width: 100%;" required>
                                                <option value="" selected>Seleccione un Usuario</option>
                                                <?php
                                                $query = $pdo->prepare("SELECT * FROM tb_usuarios");
                                                $query->execute();
                                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($usuarios as $usuario) {
                                                ?>
                                                    <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre'] . " " . $usuario['ap_paterno'] . " " . $usuario['ap_materno']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-block">DESIGNAR</button>
                                    </form>
                                    <script>
                                        $('#buscarUsuarioForm').submit(function(evento) {
                                            evento.preventDefault();
                                            enviar1();
                                        });

                                        function enviar1() {
                                            var datos = $('#buscarUsuarioForm').serialize();
                                            $.ajax({
                                                type: "post",
                                                url: "controller_designacion.php",
                                                data: datos,
                                                success: function(text) {
                                                    if (text == "exito") {
                                                        correcto_contacto()
                                                    } else {
                                                        phperror_contacto(text)
                                                    }
                                                }

                                            })
                                        }

                                        function correcto_contacto() {


                                            Swal.fire(
                                                'CORRECTO',
                                                'SE ASIGNO CORRECTAMENTE',
                                                'success'
                                            ).then((result) => {
                                                if (result.value) {
                                                    window.location.reload();
                                                }
                                            });

                                        }

                                        function phperror_contacto(text) {
                                            Swal.fire(
                                                'ERROR',
                                                text,
                                                'error'
                                            ).then((result) => {
                                                if (result.value) {
                                                    window.location.reload();
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-12 col-md-6 col-lg-6">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">APOYO DE USUARIO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                                <form id="formulario_apoyo">

                                    <label for="" hidden>id_agenda
                                        <input type="text" name="id_agenda_apoyo" value="<?php echo $id_agenda = $_GET['id'] ?>">
                                    </label>

                                    <div class="form-group">
                                        <label>DESIGNAR AL ASESOR</label>
                                        <select id="selectUsuario2" name="usuario_apoyo" class="form-control select2 select2-primary" data-dropdown-css-class="select2-info" style="width: 100%;" required>
                                        <option value="" selected>Seleccione un Usuario</option>
                                            <?php
                                            $query = $pdo->prepare("SELECT * FROM tb_usuarios");
                                            $query->execute();
                                            $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($usuarios as $usuario) {
                                            ?>
                                                <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo $usuario['nombre'] . " " . $usuario['ap_paterno'] . " " . $usuario['ap_materno']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>                                                          
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-block">DESIGNAR</button>  
                                </form> 
                                <script>
                                    $('#formulario_apoyo').submit(function(event){
                                        event.preventDefault();
                                        enviar();
                                    });
                                    function enviar(){
                                        var datos=$('#formulario_apoyo').serialize();
                                        $.ajax({
                                            type:"post",
                                            url:"controller_apoyo.php",
                                            data:datos,
                                            success:function(text){
                                                if (text=="exito") {
                                                    correcto_contacto_apoyo()
                                                } else {
                                                    phperror_contacto_apoyo(text)
                                                }
                                            }

                                        })
                                    }

                                    function correcto_contacto_apoyo(){
                                    

                                        Swal.fire(
                                            'CORRECTO',
                                            'SE ASIGNO CORRECTAMENTE',
                                            'success'
                                        ).then((result) => {
                                            if (result.value) {
                                                window.location.reload();
                                            }
                                        });

                                    }
                                    function phperror_contacto_apoyo(text){
                                        Swal.fire(
                                            'ERROR',
                                            text,
                                            'error'
                                        ).then((result) => {
                                            if (result.value) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                </script>                    
                            </div>       
                        </div>        
                    </div>
                </div>
            </div> -->
            </div>


    </section>
</div>

<?php include('../../layout/admin/parte2.php'); ?>

<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function() {
        $('.select2').select2();
    });
</script>