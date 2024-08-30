<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

if (isset($_SESSION['session_reportes'])) {
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
          <h1>PAGINA PRINCIPAL DE REPORTES</h1>
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
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">En esta página puede acceder a los reportes generales, por urbanización y asesores de venta</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="container">
            <div class="row">
              <div class="col-6">
                REPORTES DE CLIENTES AGENDADOS
                <table class="table">
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_asesor.php" class="btn btn-primary">POR ASESOR</a></td>
                  </tr>
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_urbanizacion.php" class="btn btn-primary">POR URBANIZACION</a></td>
                  </tr>
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_general.php" class="btn btn-primary">POR GENERAL</a></td>
                  </tr>
                </table>
              </div>
              <div class="col-6">
                REPORTES DE CLIENTES CON RESERVA
                <table class="table">
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_cliente_reserva.php" class="btn btn-success">POR ASESOR</a></td>
                  </tr>
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_urbanizacion_reserva.php" class="btn btn-success">POR URBANIZACION</a></td>
                  </tr>
                  <tr>
                    <td><a href="<?php echo $URL; ?>/admin/reporte/reporte_general_reserva.php" class="btn btn-success">POR GENERAL</a></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('../../layout/admin/parte2.php'); ?>