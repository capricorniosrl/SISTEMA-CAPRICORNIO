<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['session_usuarios'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>

<?php include('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Registro de un Nuevo Usuario</h1>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">
                    <small>Llene la informacion con mucho cuidado</small>
                  </h3>
                </div>

                <!-- form start -->
                <form action="controller_create.php" method="post">

                  <div class="card-body">
                    <div class="row">


                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="nombre">Nombres <span class="text-danger">(*)</span> </label>
                          <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingrese nombre completo" required />
                        </div>
                      </div>
                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="paterno">Apellido Paterno</label>
                          <input type="text" name="paterno" class="form-control" id="paterno" placeholder="Ingrese Apellido Paterno" />
                        </div>
                      </div>
                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="materno">Apellido Materno</label>
                          <input type="text" name="materno" class="form-control" id="materno" placeholder="Ingrese Apellido Materno" />
                        </div>
                      </div>


                      <div class="col-sm-3 col-12">
                        <div class="form-group">
                          <label for="ci">Carnet <span class="text-danger">(*)</span></label>
                          <input type="number" name="ci" class="form-control" id="ci" placeholder="Ingrese numero de Carnet de Identidad" required />
                        </div>
                      </div>


                      <div class="col-sm-2 col-12">
                        <div class="form-group">
                          <label for="cargo">Exp. <span class="text-danger">(*)</span></label>
                          <select id="cargo" name="exp" class="form-control" required>
                            <option value="" selected>--Seleccione--</option>
                            <option value="LP.">LA PAZ</option>
                            <option value="OR.">ORURO</option>
                            <option value="PT.">POTOSI</option>
                            <option value="CBBA.">COCHABAMBA</option>
                            <option value="CH.">CHUQUISACA </option>
                            <option value="TJ.">TARIJA</option>
                            <option value="PN.">PANDO</option>
                            <option value="BN.">BENIZ</option>
                            <option value="SC.">SANTA CRUZ</option>
                            <option value="QR.">QR</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-sm-3 col-12">
                        <div class="form-group">
                          <label for="celular">Celular <span class="text-danger">(*)</span></label>
                          <input type="number" name="celular" class="form-control" id="celular" placeholder="77777777" />
                        </div>
                      </div>
                      <div class="col-sm-4 col-12">




                        <div class="form-group">
                          <label for="cargo">cargo <span class="text-danger">(*)</span></label>
                          <select id="cargo" name="cargo" class="form-control" required>
                            <option value="" selected>--Seleccione un Cargo--</option>
                            <?php
                            $query = $pdo->prepare("SELECT * FROM tb_cargo");
                            $query->execute();
                            $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($usuarios as $usuario) {
                            ?>
                              <option value="<?php echo $usuario['nombre_cargo']; ?>"><?php echo $usuario['nombre_cargo']; ?></option>
                            <?php
                            }
                            ?>

                          </select>
                        </div>
                      </div>



                      <div class="col-sm-6 col-12">
                        <div class="form-group">
                          <label for="email">Direccion <span class="text-danger">(*)</span></label>
                          <input type="text" name="direccion" class="form-control" id="email" placeholder="Ingrese La direccion de su Domicilio" required />
                        </div>
                      </div>
                      <div class="col-sm-6 col-12">
                        <div class="form-group">
                          <label for="email">Correo Electronico <span class="text-danger">(*)</span></label>
                          <input type="email" name="correo" class="form-control" id="email" placeholder="juan@example.com" required />
                        </div>
                      </div>


                    </div>


                  </div>

                  <!-- /.card-body -->
                  <div class="card-footer">
                    <a href="<?php echo $URL; ?>/admin/usuarios/" class="btn btn-default">CANCELAR</a>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Asegurese de mandar la Informacion Correcta')">REGISTRAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container-fluid -->
  </div>
</div>
<?php include('../../layout/admin/parte2.php'); ?>