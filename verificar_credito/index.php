<?php
include ("../app/config/config.php");
include ("../app/config/conexion.php");

// Inicializar variables
$idcu = null;
$datos = null;

// Verificar si el parámetro idcu está presente en la URL
if (isset($_GET['idcu'])) {
    $data = base64_decode($_GET['idcu']);
    list($encrypted_number, $iv) = explode('::', $data);

    $key = 'mi_clave_secreta'; // La misma clave utilizada para encriptar
    $iv = base64_decode($iv);

    if (strlen($iv) === 16) {
        $idcu = openssl_decrypt($encrypted_number, 'AES-256-CBC', $key, 0, $iv);
    } else {
        $idcu = null; // En caso de IV incorrecto, asignar null
    }
  

    // Consultar la base de datos
    $sql = $pdo->prepare("SELECT * FROM tb_cuotas_credito cu
    INNER JOIN tb_credito semi
    INNER JOIN tb_comprador com
    WHERE ((cu.id_credito_fk=semi.id_credito) AND semi.id_comprador_fk=com.id_comprador) AND id_cuota=:idcu");

    $sql->bindParam(':idcu', $idcu, PDO::PARAM_INT);
    $sql->execute();
    $datos = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet"/>
</head>
<body style="background-color: #eaeaea;">

<header>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <!-- Container wrapper -->
        <div class="container-fluid  w-auto my-auto  d-sm-flex">
            <!-- Navbar brand -->
            <a class="navbar-brand mt-0 mt-lg-0" href="#">
                <img src="../public/img/ICONO.png" height="45" alt="MDB Logo" loading="lazy"/>
            </a>
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">SISTEMA DE VERIFICACION</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card text-center mt-5">
            <div class="card-header"> 
                <h5> <strong>DETALLES DEL COMPROBANTE</strong></h5>
            </div>
            <div class="card-body">
                <?php if ($datos): ?>
                    <div class="row">
                        <div class="col-lg-10 col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">NOMBRE DEL CLIENTE</th>
                                        <th scope="col">CI</th>
                                        <th scope="col">EXP</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider table-divider-color">
                                    <tr>
                                        <td><?php echo htmlspecialchars($datos['nombre_1'] . " " . $datos['ap_paterno_1'] . " " . $datos['ap_materno_1']); ?></td>
                                        <td><?php echo htmlspecialchars($datos['ci_1']); ?></td>
                                        <td><?php echo htmlspecialchars($datos['exp_1']); ?></td>
                                    </tr>                             
                                </tbody>
                            </table>
                            <div class="row justify-content-center">
                                <div class="col-12 col-sm-6">
                                    <table class="table text-start table-striped">
                                        <tr>
                                            <td class="bg-primary text-white"><b class="text-start">FECHA PAGO</b></td>
                                            <td><p class="card-text"><?php echo htmlspecialchars($datos['fecha_registro_pago']); ?></p></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-primary text-white"><b class="text-start">MONTO PAGO</b></td>
                                            <td><p class="card-text"><?php echo htmlspecialchars($datos['monto']); ?></p></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-primary text-white"><b class="text-start">TIPO PAGO</b></td>
                                            <td><p class="card-text"><?php echo htmlspecialchars($datos['tipo_pago']); ?></p></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-primary text-white"><b class="text-start">NRO. RECIBO</b></td>
                                            <td><p class="card-text"><?php echo htmlspecialchars($datos['numero_recibo']); ?></p></td>
                                        </tr>
                                        <tr>
                                            <td class="bg-primary text-white"><b class="text-start">NRO. CUOTA</b></td>
                                            <td><p class="card-text"><?php echo htmlspecialchars($datos['nombre_cuota']); ?></p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Importante!</h4>
                                <hr>
                                <p class="mb-0">
                                    Si la información expuesta coincide con la información impresa del certificado que desea validar, el certificado puede considerarse válido, caso contrario es inválido.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-2 col-12">
                            <img src="doc_ok.png" alt="logo" width="120">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">DATOS NO ENCONTRADOS!</h4>
                        
                        <hr>
                        <p class="mb-0">
                            los datos no fueron encontrados 
                        </p>
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
</body>
</html>
