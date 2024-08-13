<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

?>

<?php  include ('../../layout/admin/parte1.php'); ?>
 
<!-- Select2 -->
<link rel="stylesheet" href="../../public/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="../../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var formulario = document.getElementById('formulario');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            fetch('generar_pdf.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                var preview = document.getElementById('pdf-preview');
                if (data.error) {
                    preview.innerHTML = `<p class="text-danger">${data.error}</p>`;
                } else {
                    preview.innerHTML = `
                        <iframe src="${data.filename}" width="100%" height="600px" frameborder="0"></iframe>
                        <br>
                        <a href="${data.filename}" download="reporte_clientes.pdf" class="btn btn-success">Descargar PDF</a>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('pdf-preview').innerHTML = `<p class="text-danger">Hubo un problema con la solicitud.</p>`;
            });
        });
    } else {
        console.error('Formulario no encontrado');
    }
});
</script>

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
            <div class="row d-flex ">
                <form class="container-fluid" id="formulario">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Lista de Usuarios</label>
                                <select id="usuario" name="usuario" class="form-control select2 select2-primary" data-dropdown-css-class="select2-info" style="width: 100%;" required>
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
                        <div class="col-4">
                            <div class="form-group">
                                <label>INICIO</label>
                                <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio">                   
                            </div> 
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>FIN</label>
                                <input class="form-control" type="date"  id="fecha_fin" name="fecha_fin">                   
                            </div> 
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger">GENERAR REPORTE</button>                   
                </form>  
                
                <div id="pdf-preview">
                    <!-- Aquí se mostrará el PDF generado -->
                </div>
            </div>        
          </div>
        </div>
      </div>
    </section>
</div>

<?php include ('../../layout/admin/parte2.php'); ?>

<!-- Select2 -->
<script src="../../public/plugins/select2/js/select2.full.min.js"></script>
<script>
  $(function () {
    $('.select2').select2();
  });
</script>
