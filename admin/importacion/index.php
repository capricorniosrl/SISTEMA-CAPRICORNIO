<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['importaciones'])) {
    // echo "existe session y paso por el login";
} else {
    // echo "no existe session por que no ha pasado por el login";
    header('Location:' . $URL . '/admin');
}
?>

<?php include('../../layout/admin/parte1.php'); ?>


<!-- Theme style -->
<link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Control de Clientes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Importaciones</a></li>
                        <li class="breadcrumb-item active">Registro</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Registro de Clientes - Importaciones</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <style>
                    img {
                        max-height: 180px;
                    }
                </style>


                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-8">
                            <div class="card card-primary card-tabs">
                                <div class="card-header p-0 pt-1">
                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Datos Generales</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Formulario</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">

                                    <div class="tab-content" id="custom-tabs-one-tabContent">

                                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                            <img src="img/IMPORTAR.png" class="rounded mx-auto d-block" alt="...">
                                            <form action="controller_create.php" method="post">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6" hidden>
                                                        <div class="form-group">
                                                            <label>FECHA REGISTRO <span class="text-danger"></span> </label>
                                                            <input type="date" id="fechaRegistro" name="fecha_registro" class="form-control" readonly>

                                                        </div>
                                                    </div>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', (event) => {
                                                            const today = new Date();
                                                            const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                                                            document.getElementById('fechaRegistro').value = formattedDate;
                                                        });
                                                    </script>

                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Nombre Completo del Cliente del Cliente</label>
                                                            <input type="text" name="nombre" id="" class="form-control" placeholder="Nombres y Apellidos">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Celular</label>
                                                            <input type="number" name="celular" id="" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Correo</label>
                                                            <input type="text" name="email" id="" class="form-control" placeholder="cliente@gmail.com">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Producto</label>
                                                            <input type="text" name="producto" id="" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="">Direccion</label>
                                                            <input type="text" name="direccion" id="" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="">Observaciones</label>
                                                            <textarea class="form-control" name="obs_contacto" id="" cols="30" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                        </div>
                                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">1. ¿TIENE EXPERIENCIA PREVIA EN IMPORTACIONES DE PRODUCTOS?</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="respuesta_si_no" id="si" value="SI" checked>
                                                            <label class="form-check-label" for="si">
                                                                Si tiene Experiencia
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="respuesta_si_no" id="no" value="NO">
                                                            <label class="form-check-label" for="no">
                                                                No tiene Experiencia
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">2. ¿CUÁL ES EL TIPO DE PRODUCTO QUE DESEA A IMPORTAR?</label>
                                                        <input type="text" name="tipo" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">3. ¿CUÁNTO ES EL MONTO QUE USTED ESTIMA IMPORTAR? (MENSUAL-ANUAL)</label>
                                                        <div class="row">
                                                            <div class="col-12 col-sm-6">
                                                                <input type="number" name="monto" id="" class="form-control">
                                                            </div>
                                                            <div class="col-12 col-sm-3">
                                                                <select name="tipo_dinero" id="" class="form-control">
                                                                    <option value="SIN_CONOCIMIENTO">SIN CONOCIMIENTO</option>
                                                                    <option value="$us">DOLARES</option>
                                                                    <option value="Bs">BOLIVIANOS</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-sm-3">
                                                                <select name="tiempo" id="" class="form-control">
                                                                    <option value="SIN_CONOCIMIENTO">SIN CONOCIMIENTO</option>
                                                                    <option value="MENSUAL">MENSUAL</option>
                                                                    <option value="ANUAL">ANUAL</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">4. ¿CUÁNDO PIENSA REALIZAR SU IMPORTACIÓN?</label>

                                                        <div class="col-12 col-sm-6">
                                                            <input type="date" name="fecha" id="" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">5. ¿QUÉ MERCADO LE INTERESA?</label>
                                                        <input type="text" name="mercaderia" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">6. ¿IDENTIFICO LOS REQUISITOS LEGALES Y REGULACIONES ADUANERAS PARA IMPORTAR ESE PRODUCTO?</label>
                                                        <input type="text" name="requerimientos" id="" class="form-control">
                                                    </div>
                                                </div>





                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">7. ¿CUÁNTO VOLUMEN DE MERCADERÍA TIENE PLANIFICADO IMPORTAR? (Contenedor) (Carga Suelta)</label>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="number" name="volumen" id="" class="form-control">
                                                            </div>
                                                            <div class="col-6">
                                                                <select name="tipo_volumen" id="" class="form-control">
                                                                    <option value="SIN_CONOCIMIENTO">SIN CONOCIMIENTO</option>
                                                                    <option value="CONTENEDOR">CONTENEDOR</option>
                                                                    <option value="CARGA_SUELTA">CARGA SUELTA</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">8. ¿QUÉ OBJETIVO COMERCIAL BUSCA ALCANZAR CON ESTA IMPORTACIÓN?</label>
                                                        <input type="text" name="objetivo" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">9. ¿TIENE UN PRESUPUESTO ESTIMADO PARA LA IMPORTACIÓN Y LOGÍSTICA DE LOS PRODUCTOS?</label>
                                                        <input type="text" name="presupuesto" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">10. ¿HA CONSIDERADO ASPECTOS COMO PLAZOS DE ENTREGA, COSTOS DE TRANSPORTE Y POSIBLES ARANCELES AL IMPORTAR?</label>
                                                        <input type="text" name="aspectos" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">11. ¿CUENTA CON UN PROVEEDOR CONFIABLE EN EL EXTRANJERO PARA LA IMPORTACIÓN DE PRODUCTOS?</label>
                                                        <input type="text" name="proveedor" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">12. ¿QUÉ ASPECTOS BUSCAS EN CAPRICORNIO SRL. ASESOR DE COMERCIO INTERNACIONAL PARA APOYARTE EN ESTE PROCESO DE IMPORTACIÓN?</label>
                                                        <input type="text" name="adpecto_asesor" id="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">13. OBSERVACIONES</label>
                                                        <textarea class="form-control" name="obs_formulario" id="" cols="30" rows="2"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-block" type="submit">REGISTRAR</button>
                                            </form>
                                        </div>

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

<?php include('../../layout/admin/parte2.php'); ?>