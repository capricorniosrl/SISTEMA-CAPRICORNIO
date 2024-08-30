<?php
include('../app/config/config.php');
include('../app/config/conexion.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $URL; ?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo $URL; ?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $URL; ?>/public/dist/css/adminlte.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="shortcut icon" href="../public/img/ICONO.ico" type="image/x-icon">

</head>
<style>
  body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    /* Evita el desplazamiento horizontal */
  }

  .login-box {
    position: absolute;
    /* Asegura que el contenedor esté en una posición fija */
    top: 50%;
    /* Centra verticalmente */
    left: 50%;
    /* Centra horizontalmente */
    transform: translate(-50%, -50%);
    /* Ajusta el centrado */
    width: 360px;
  }
</style>

<body class="hold-transition login-page">


  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary ">
      <div class="card-header text-center">
        <center>
          <img src="../public/img/logo.png" style="width: 185px;" class="img-fluid" alt="">
        </center>
        <a href="#" class="h2"><b>Capricornio</b>s.r.l.</a>
      </div>
      <div class="card-body">
        <!-- ALERTA -->
        <div class="alert alert-danger alert-dismissible d-none" id="mensajeerror">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-ban"></i>Siguientes errores<h5><span id="msjerror"></span> </h5>
        </div>
        <!-- FIN DE ALERTA -->

        <form method="post" id="login" novalidate>

          <label for="">Correo Electronico</label>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="correo" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <label for="">Contraseña</label>
          <table></table>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <a href="" class="btn btn-danger btn-block">CANCELAR</a>
              <button type="submit" class="btn btn-primary btn-block">INGRESAR</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->



  <!-- jQuery -->
  <script src="<?php echo $URL; ?>/public/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo $URL; ?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo $URL; ?>/public/dist/js/adminlte.min.js"></script>

  <script>
    var URL = "<?php echo $URL; ?>";
  </script>
  <script src="script.js"></script>


</body>

</html>