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

// Redireccionar después del envío del formulario para evitar reenvío
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $buscar = $_POST['buscar'];

  // Preparar la consulta
  $stmt = $pdo->prepare('SELECT id_comprador, nombre_1, ap_paterno_1, ap_materno_1, ci_1, exp_1, urbanizacion, com.celular_1 as celular, lote, manzano FROM tb_comprador com INNER JOIN tb_semicontado semi ON semi.id_comprador_fk = com.id_comprador WHERE ci_1 = :buscar');
  $stmt->bindParam(':buscar', $buscar);
  $stmt->execute();

  // Guardar los resultados en una variable de sesión
  $_SESSION['resultados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Redirigir al usuario para evitar reenvío del formulario
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit();
}

// Mostrar los resultados si están disponibles en la sesión
$results = isset($_SESSION['resultados']) ? $_SESSION['resultados'] : [];
unset($_SESSION['resultados']);
?>
<?php include('../../layout/admin/parte1.php'); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">BUSCAR AL CLIENTE POR EL CARNET DE IDENTIDAD</h1>
          <center>
            <h3>SEMICONTADO</h3>
          </center>
        </div>
      </div>
      <section class="content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-6">
              <div class="card card-primary animate_animated animate_flipInX">
                <div class="card-body">
                  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
      <div class="card card-primary animate_animated animate_flipInX">
        <div class="card-body">
          <style>
            .table-responsive_1 {
              width: 100%;
              overflow-x: auto;
            }

            table {
              width: 100%;
              border-collapse: collapse;
            }

            th,
            td {
              border: 1px solid #ddd;
              padding: 8px;
              text-align: left;
            }

            th {
              background-color: #f4f4f4;
            }
          </style>
          <div class="table-responsive_1">
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
                        <a class="btn btn-primary" href="<?php echo $URL ?>/admin/semi-contado/cliente_semicontado.php?variable=<?php echo urlencode($resultado['id_comprador']); ?>" class="btn btn-default">
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

<?php include('../../layout/admin/parte2.php'); ?>