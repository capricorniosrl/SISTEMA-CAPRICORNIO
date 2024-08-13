<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>
<?php include ('../../layout/admin/parte1.php'); ?>
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />


<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">DETALLES DEL CLIENTE - SEMI CONTADO</h1>
        </div>
      </div>
      <section class="content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card card-primary animate__animated animate__zoomInUp">
                <div class="card-body">
                  <?php $id_comprador = $_GET['variable'];
                  echo $id_comprador;?>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>


  <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card card-primary animate__animated animate__flipInX">
                <div class="card-body">
                <?php 
                echo '<button onclick="window.open(\'index.php\', \'_blank\')">Volver</button>';
                ?>  
                </div>
              </div>
            </div>
</div>



</div>





<?php include ('../../layout/admin/parte2.php'); ?>




