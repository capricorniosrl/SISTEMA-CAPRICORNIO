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
          <h1 class="m-0">BUSCAR AL CLIENTE POR EL CARNET DE INDETIDAD</h1>
        </div>
      </div>
      <section class="content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card card-primary animate__animated animate__flipInX">
                <div class="card-body">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                      <label for="buscar">INGRESE EL NRO. DE CARNET</label>
                      <input class="form-control" type="number" id="buscar" name="buscar">
                    </div>
                    <input type="submit" value="Buscar" class="form-control">
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>


  <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="card card-primary animate__animated animate__flipInX">
                <div class="card-body">
  

              
                <div class="table-responsive">
                  <table class="table" id="example" class="display " style="width:100%">
                    <thead>
                      <tr>
                        <th>Id_Comprador</th>
                        <th>NOMBRES</th>
                        <th>APELLIDO PATERNO</th>
                        <th>APELLIDO MATERNO</th>
                        <th>CI</th>
                        <th>EXPEDIDO EN:</th>
                        <th>CELULAR</th>
                        <th>PAGOS</th>
                      </tr>
                    </thead>
                    <?php
                      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                      $buscar = $_POST['buscar'];
                      // Conectamos a la base de datos
                      $conn = new PDO('mysql:host=localhost;dbname=bd_capricornio', 'root', '');
                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                      // Preparamos la consulta
                      $stmt = $conn->prepare('SELECT * FROM tb_comprador WHERE ci_1 LIKE :buscar');
                      $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
                      $stmt->execute();

                      // Mostramos los resultados
                      $resultados = $stmt->fetchAll();
                      if ($resultados) {
                          echo '<h2>Resultados de la búsqueda</h2>';
                          foreach ($resultados as $resultado) {
                            $id_com = $resultado['id_comprador'];
                      ?>
          <tbody>
            <tr>
              <th>
          <?php
            echo '<p>' . $resultado['id_comprador'] . '</p>';
          ?>
          </th>
          <th>
             <?php
           echo '<p>' . $resultado['nombre_1'] . '</p>';
          ?> 
          </th>
          <th>
          <?php
            echo '<p>' . $resultado['ap_paterno_1'] . '</p>';
          ?>
          </th>
          <th>
            <?php
            echo '<p>' . $resultado['ap_materno_1'] . '</p>';
          ?>
          </th>
          <th>
            <?php
            echo '<p>' . $resultado['ci_1'] . '</p>';
          ?>
          </th>
          <th>
          <?php
            echo '<p>' . $resultado['exp_1'] . '</p>';
          ?>
          </th>
          <th>
          <?php
            echo '<p>' . $resultado['celular_1'] . '</p>';
          ?>
          </th>
          <th>
          <a href="" type="button" class="btn btn-primary" data-toggle="modal" data-target="#actualizar_contacto" onclick="mostrarmensaje('<?php echo $id_com; ?>')" ?><i class="fas fa-wallet"></i></a>
          <script>
  function mostrarmensaje(a){
    localStorage.setItem('id_c', a);
    console.log(a);
    window.location.href = 'buscar_cliente.php?variable=' + a;
  }
</script>
          </th>
          </tr>
          
            </tbody>
          <?php
        }
    } else {
     ?>
     <script>
      const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: "error",
  title: "NO SE ENCONTRARON REGISTRO"
});
     </script>
     <?php
    }
}
?>
                   

<!--                    <tfoot>
                    <tr>
                        Resultados de la Busqueda
                    </tr>
                    </tfoot>-->
                  </table>
                </div>



<!--?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $buscar = $_POST['buscar'];
    // Conectamos a la base de datos
    $conn = new PDO('mysql:host=localhost;dbname=bd_capricornio', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparamos la consulta
    $stmt = $conn->prepare('SELECT * FROM tb_comprador WHERE ci_1 LIKE :buscar');
    $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
    $stmt->execute();

    // Mostramos los resultados
    $resultados = $stmt->fetchAll();
    if ($resultados) {
        echo '<h2>Resultados de la búsqueda</h2>';
        foreach ($resultados as $resultado) {
            echo '<p>' . $resultado['id_comprador'] . '</p>';
            echo '<p>' . $resultado['nombre_1'] . '</p>';
            echo '<p>' . $resultado['ap_paterno_1'] . '</p>';
            echo '<p>' . $resultado['ap_materno_1'] . '</p>';
            echo '<p>' . $resultado['ci_1'] . '</p>';
            echo '<p>' . $resultado['exp_1'] . '</p>';
            echo '<p>' . $resultado['celular_1'] . '</p>';
        }
    } else {
        echo '<p>No se encontraron resultados</p>';
    }
}
?>-->
                </div>
              </div>
            </div>
          </div>



</div>







<?php include ('../../layout/admin/parte2.php'); ?>




