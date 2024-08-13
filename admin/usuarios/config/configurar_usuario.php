<?php
    include ('../../../app/config/config.php');
    include ('../../../app/config/conexion.php');

    include ('../../../layout/admin/session.php');
    include ('../../../layout/admin/datos_session_user.php');
?>
<?php  include ('../../../layout/admin/parte1.php'); ?>


    
   

  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuracion de Perfil</h1>
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



    <section class="content">
      <div class="container-fluid">
      <form class="form form-vertical" action="upload.php" method="POST" enctype="multipart/form-data">   
    <div class="row">
        <div class="col-12 col-md-5 col-lg-4 col-xl-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="form-group">
                        <label for="">IMAGEN</label><br>
                        <img class="mb-3 mt-3" style="object-fit: cover; width:100%; height:100%;"  src="<?php echo $URL."/admin/usuarios/".$foto_perfil?>" alt="">


                        <input type="file" name="img_nuevo" id="">
                        
                        <input hidden type="text" name="img_actual" id="" value="<?php echo $foto_perfil?>">
                    </div>
                </div>
            </div>            
        </div>

        <div class="col-12 col-md-7 col-lg-8 col-xl-9">
            <div class="card">            
                <div class="card-body">                
                    <h2 class="text-center">Datos del Usuario</h2>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" value="<?php echo $nombre?>" id="nombre" name="nombre">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="apellidos">Apellidos Paterno:</label>
                                <input type="text" class="form-control" value="<?php echo $ap_paterno?>" id="ap_paterno" name="ap_paterno">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nombre">Apellido Materno:</label>
                                <input type="text" class="form-control" value="<?php echo $ap_materno?>" id="ap_materno" name="ap_materno">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="apellidos">Ci:</label>
                                <input type="number" class="form-control" value="<?php echo $ci?>" id="ci" name="ci">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="cargo">Exp. <span class="text-danger" >(*)</span></label>
                                <select id="cargo" name="exp" class="form-control">
                                    <option value="">--Seleccione--</option>
                                    <option value="LP." <?php if(isset($exp) && $exp == "LP.") echo "selected"; ?>>LA PAZ</option>
                                    <option value="OR." <?php if(isset($exp) && $exp == "OR.") echo "selected"; ?>>ORURO</option>
                                    <option value="PT." <?php if(isset($exp) && $exp == "PT.") echo "selected"; ?>>POTOSI</option>
                                    <option value="CBBA." <?php if(isset($exp) && $exp == "CBBA.") echo "selected"; ?>>COCHABAMBA</option>
                                    <option value="CH."  <?php if(isset($exp) && $exp == "CH.") echo "selected"; ?>>CHUQUISACA</option>
                                    <option value="TJ." <?php if(isset($exp) && $exp == "TJ.") echo "selected"; ?>>TARIJA</option>
                                    <option value="PN." <?php if(isset($exp) && $exp == "PN.") echo "selected"; ?>>PANDO</option>
                                    <option value="BN." <?php if(isset($exp) && $exp == "BN.") echo "selected"; ?>>BENIZ</option>
                                    <option value="SC." <?php if(isset($exp) && $exp == "SC.") echo "selected"; ?>>SANTA CRUZ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="apellidos">Celular:</label>
                                <input type="text" value="<?php echo $celular?>" class="form-control" id="celular" name="celular">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form-group">
                                <label for="apellidos">Direccion:</label>
                                <input type="text" value="<?php echo $direccion?>" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary btn-block">ACTUALIZAR</button>
    </div>
</form>

      </div>
    </section>
  </div>

<?php  include ('../../../layout/admin/parte2.php'); ?>

