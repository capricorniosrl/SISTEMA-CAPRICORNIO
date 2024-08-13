<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');




    $id = $_GET['id'];


    $query=$pdo->prepare("SELECT * FROM tb_usuarios WHERE id_usuario=$id");
    $query->execute();

    $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($usuarios as $usuario) {
    

        $id_user = $usuario['id_usuario'];    
        $nombre = $usuario['nombre'];
        $ap_paterno = $usuario['ap_paterno'];
        $ap_materno =$usuario['ap_materno'];
        $cargo = $usuario['cargo'];
        $email = $usuario['email'];
        $celular = $usuario['celular'];
        $ci = $usuario['ci'];
        $direccion = $usuario['direccion'];
        $exp=$usuario['exp'];
     
    }




?>

<?php  include ('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edicion de Usuario</h1>
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
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">
                    <small>Llene la informacion con mucho cuidado</small>
                  </h3>
                </div>

                <!-- form start -->
                <form action="controller_edit.php" method="post">
                  
                  <div class="card-body">
                    <div class="row">
                        <input type="text" name="id_usuario" value="<?php echo $id_user?>" hidden>

                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="nombre">Nombres <span class="text-danger" >(*)</span> </label>
                          <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Ingrese nombre completo" value="<?php echo $nombre?>" required/>
                        </div>
                      </div>
                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="paterno">Apellido Paterno</label>
                          <input type="text" name="paterno" class="form-control" id="paterno" placeholder="Ingrese Apellido Paterno" value="<?php echo $ap_paterno?>"/>
                        </div>
                      </div>
                      <div class="col-sm-4 col-12 ">
                        <div class="form-group">
                          <label for="materno">Apellido Materno</label>
                          <input type="text" name="materno" class="form-control" id="materno" placeholder="Ingrese Apellido Materno" value="<?php echo $ap_materno?>"/>
                        </div>
                      </div>


                      <div class="col-sm-3 col-12">
                        <div class="form-group">
                          <label for="ci">Carnet <span class="text-danger" >(*)</span></label>
                          <input type="number" name="ci" class="form-control" id="ci" placeholder="Ingrese numero de Carnet de Identidad" value="<?php echo $ci?>" required/>
                        </div>
                      </div>

                      <div class="col-sm-2 col-12">
                        <div class="form-group">
                          <label for="cargo">Exp. <span class="text-danger" >(*)</span></label>
                          <select id="cargo" name="exp" class="form-control" required>
                            <option value="" selected>--Seleccione--</option>
                            <option value="LP." <?php echo ($exp == "LP.") ? "selected" : ""; ?>>LA PAZ</option>
                            <option value="OR." <?php echo ($exp == "OR.") ? "selected" : ""; ?>>ORURO</option>
                            <option value="PT." <?php echo ($exp == "PT.") ? "selected" : ""; ?>>POTOSI</option>
                            <option value="CBBA." <?php echo ($exp == "CBBA.") ? "selected" : ""; ?>>COCHABAMBA</option>
                            <option value="CH." <?php echo ($exp == "CH.") ? "selected" : ""; ?>>CHUQUISACA</option>
                            <option value="TJ." <?php echo ($exp == "TJ.") ? "selected" : ""; ?>>TARIJA</option>
                            <option value="PN." <?php echo ($exp == "PN") ? "selected" : ""; ?>>PANDO</option>
                            <option value="BN." <?php echo ($exp == "BN.") ? "selected" : ""; ?>>BENI</option>
                            <option value="SC." <?php echo ($exp == "SC.") ? "selected" : ""; ?>>SANTA CRUZ</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-sm-3 col-12">
                        <div class="form-group">
                          <label for="celular">Celular <span class="text-danger" >(*)</span></label>
                          <input type="number" name="celular" class="form-control" id="celular" placeholder="77777777" value="<?php echo $celular?>"/>
                        </div>
                      </div>
                      <div class="col-sm-4 col-12">


                        <div class="form-group">
                          <label for="cargo">cargo <span class="text-danger" >(*)</span></label>
                          <select id="cargo" name="cargo" class="form-control" required>
                            <option value="" selected>--Seleccione un Cargo--</option>
                            <option value="ADMINISTRATIVO" <?php echo ($cargo == "ADMINISTRATIVO") ? "selected" : ""; ?>>ADMINISTRATIVO</option>
                            <option value="SUPERVISOR" <?php echo ($cargo == "SUPERVISOR") ? "selected" : ""; ?>>SUPERVISOR</option>
                            <option value="ASESOR" <?php echo ($cargo == "ASESOR") ? "selected" : ""; ?>>ASESOR</option>
                            <option value="CLIENTE" <?php echo ($cargo == "CLIENTE") ? "selected" : ""; ?>>CLIENTE</option>
                          </select>
                        </div>
                      </div>


                      <div class="col-sm-6 col-12">
                        <div class="form-group">
                          <label for="email">Direccion <span class="text-danger" >(*)</span></label>
                          <input type="text" name="direccion" class="form-control" id="email" placeholder="Ingrese La direccion de su Domicilio"  value="<?php echo $direccion?>"required/>
                        </div>
                      </div>
                      <div class="col-sm-6 col-12">
                        <div class="form-group">
                          <label for="email">Correo Electronico <span class="text-danger" >(*)</span></label>
                          <input type="email" name="correo" class="form-control" id="email" placeholder="juan@example.com" value="<?php echo $email?>" required/>
                        </div>
                      </div>


                    </div>

                      
                  </div>

                  <!-- /.card-body -->
                  <div class="card-footer">
                    <a href="<?php echo $URL;?>/admin/usuarios" class="btn btn-default">CANCELAR</a>
                    <button type="submit" class="btn btn-outline-success" onclick="return confirm('Asegurese de mandar la Informacion Correcta')">ACTUALIZAR DATOS DEL USUARIO</button>
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
<?php   include ('../../layout/admin/parte2.php'); ?>
