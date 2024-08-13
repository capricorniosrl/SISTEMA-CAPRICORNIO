<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

?>
   <?php
if (isset($_SESSION['session_reportes'])) {
    // echo "existe session y paso por el login";
}else{
    // echo "no existe session por que no ha pasado por el login";
    header('Location:'.$URL.'/admin');
}
?>
<?php  include ('../../layout/admin/parte1.php'); ?>
 
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
            <h1>Generar Reporte</h1>
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
            <h3 class="card-title">Listar Clientes Agendados por Asesor</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row ">
                <form class="container-fluid" id="clientForm">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>Lista de Usuarios</label>
                                <select id="cliente_id" name="cliente_id" class="form-control select2 select2-primary" data-dropdown-css-class="select2-info" style="width: 100%;" required>
                                    <option value="" selected>Seleccione un Usuario</option>
                                        <?php
                                        $query=$pdo->prepare("SELECT * FROM tb_usuarios");
                                        $query->execute();
                                        $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($usuarios as $usuario) {
                                        ?>
                                            <option value="<?php echo $usuario['id_usuario'];?>"><?php echo $usuario['nombre']." ".$usuario['ap_paterno']." ".$usuario['ap_materno'];?></option>
                                        <?php
                                        }
                                        ?>
                                </select>                    
                            </div> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>INICIO</label>
                                <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio">                   
                            </div> 
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label>FIN</label>
                                <input class="form-control" type="date"  id="fecha_fin" name="fecha_fin">                   
                            </div> 
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">GENERAR REPORTE</button>                   
                </form>  
                <div class="col-12">
                  <div id="client-info" class="">
                      <!-- Aquí se mostrará la información del cliente en una tabla -->
                  </div>
                  <div id="pdf-preview" class="">
                      <!-- Aquí se mostrará el PDF generado -->
                  </div>  
                </div>

            </div>   
        
                   
          </div>
        </div>
      </div>
    </section>
</div>

<script>
    $('#clientForm').on('submit', function(e) {
        e.preventDefault();

        
        const clienteId = $('#cliente_id').val();
        const clienteInicio = $('#fecha_inicio').val();
        const clienteFin = $('#fecha_fin').val();
      
        $.ajax({
            url: 'controller_generar_pdf_cliente_reserva.php',
            type: 'POST',
            data: { cliente_id: clienteId, clienteInicio: clienteInicio ,clienteFin: clienteFin },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                     $('#client-info').html(`<p class="text-danger">${response.error}</p>`);
                    $('#pdf-preview').html('');
                } else {
                    
                    $('#client-info').addClass('d-none');
                    // Mostrar vista previa del PDF
                    $('#pdf-preview').html(`
                   
                        <a href="${response.pdf_url}" download="Reporte_${response.id_cliente}.pdf" class="btn btn-success mt-2 mb-2">Descargar PDF</a>
                         <br>
                        <iframe src="${response.pdf_url}" width="100%" height="600px" frameborder="0"></iframe>
                        
                    `);
                }
            },
            error: function() {
                $('#pdf-preview').html('');
            }
        });
    });
</script>




<?php include ('../../layout/admin/parte2.php'); ?>

<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function () {
    $('.select2').select2();
  });
</script>
