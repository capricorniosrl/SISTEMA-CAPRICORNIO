<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

if (isset($_SESSION['busqueda_cierres'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}

// Inicializar una variable para controlar la notificación
$showAlert = false;

// Redirigir después del envío del formulario para evitar reenvío de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $buscar = $_POST['buscar'];

  // Preparamos la consulta
  $stmt = $pdo->prepare('SELECT id_comprador, nombre_1, ap_paterno_1, ap_materno_1, ci_1, exp_1, urbanizacion, com.celular_1 as celular, lote, manzano FROM tb_comprador com INNER JOIN tb_credito semi ON semi.id_comprador_fk = com.id_comprador WHERE ci_1 LIKE :buscar');
  $stmt->bindValue(':buscar', "%$buscar%", PDO::PARAM_STR);
  $stmt->execute();

  // Guardar los resultados en una variable de sesión
  $_SESSION['resultados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Controlar si se deben mostrar los alertas
  if (empty($_SESSION['resultados'])) {
    $showAlert = true;
  }

  // Redirigir al usuario para evitar reenvío del formulario
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}

// Mostrar los resultados si están disponibles en la sesión
$results = isset($_SESSION['resultados']) ? $_SESSION['resultados'] : [];
unset($_SESSION['resultados']);
?>
<?php include('../../layout/admin/parte1.php'); ?>

<!-- Incluye SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">BUSCAR AL CLIENTE POR EL CARNET DE IDENTIDAD</h1>
          <center>
            <h3>CREDITO</h3>
          </center>
        </div>
      </div>
      <section class="content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-body">
                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                      <label for="buscar">INGRESE EL NRO. DE CARNET</label>
                      <input class="form-control" type="number" id="buscar" name="buscar" required>
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
      <div class="card card-primary ">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="example" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>Id_Comprador</th>
                  <th>NOMBRES</th>
                  <th>APELLIDO PATERNO</th>
                  <th>APELLIDO MATERNO</th>
                  <th>CI</th>
                  <th>EXPEDIDO EN:</th>
                  <th>CELULAR</th>
                  <th>URBANIZACION</th>
                  <th>PAGOS</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($results): ?>
                  <?php foreach ($results as $resultado): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($resultado['id_comprador']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['nombre_1']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['ap_paterno_1']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['ap_materno_1']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['ci_1']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['exp_1']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['celular']); ?></td>
                      <td><?php echo htmlspecialchars($resultado['urbanizacion']) . "<br> LOTE: " . htmlspecialchars($resultado['lote']) . "<br> MANZANO: " . htmlspecialchars($resultado['manzano']); ?></td>
                      <td>
                        <a href="<?php echo $URL ?>/admin/credito/cliente_credito.php?variable=<?php echo urlencode($resultado['id_comprador']); ?>" class="btn btn-primary">
                          <i class="fas fa-wallet"></i> VER SEGUIMIENTO
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="9">No se encontraron registros.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  <?php if ($showAlert): ?>
    Swal.fire({
      icon: 'error',
      title: 'No se encontraron registros',
      text: 'Intente con otro número de carnet.',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true
    });
  <?php endif; ?>
</script>

<?php include('../../layout/admin/parte2.php'); ?>