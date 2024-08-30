<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');
?>


<?php  include ('../../layout/admin/parte1.php'); ?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">SUBIR ARCHIVO</h1>
          </div><!-- /.col -->         
        </div><!-- /.row -->
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              SELECCIONE EL ARCHIVO A ADJUNTAR
            </h3>
          </div>
          <div class="card-body">           
          
            <div class="row justify-content-center">
                <div class="col-6">
                    <form action="controller_create_archivo.php" method="post" enctype="multipart/form-data">
                        <div class="form-group" hidden>
                            <label for="id_comprador">ID</label>
                            <input type="text" name="id_comprador" id="id_comprador" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="form-group" >
                            <label for="id_comprador">NUMERO DE MATRICULA</label>
                            <input class="form-control" type="text" name="matricula" id="matricula" required>
                        </div>
                        <div class="form-group">
                            <label for="file-upload">Selecciona un archivo para subir</label>
                            <div class="file-upload-container">
                                <input type="file" name="file" id="file-upload" accept=".pdf, .doc, .docx, .jpg, .png">
                                <p id="file-name">No se ha seleccionado ningún archivo</p>
                                <div id="file-success-icon" class="success-icon hidden">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-block" type="submit" value="Registrar">
                        </div>
                    </form>
                </div>
            </div>
                

                <style>
                    .form-group {
                        margin-bottom: 1rem;
                    }
                    .file-upload-container {
                        position: relative;
                        display: flex;
                        align-items: center;
                    }
                    #file-upload {
                        border: 1px solid #ccc;
                        padding: 0.5rem;
                        border-radius: 4px;
                        flex-grow: 1;
                    }
                    #file-name {
                        margin-left: 0.5rem;
                        color: #555;
                        flex-grow: 1;
                    }
                    .success-icon {
                        margin-left: 0.5rem;
                        font-size: 1.5rem;
                        color: green; /* Estilo para el icono verde */
                        transition: opacity 0.5s ease-in-out;
                    }
                    .success-icon.hidden {
                        opacity: 0;
                        visibility: hidden;
                    }
                    .btn-primary {
                        background-color: #007bff;
                        border: none;
                        color: #fff;
                        padding: 0.5rem 1rem;
                        border-radius: 4px;
                        cursor: pointer;
                    }
                    .btn-primary:hover {
                        background-color: #0056b3;
                    }
                </style>

                <script>
                    document.getElementById('file-upload').addEventListener('change', function() {
                        var fileName = this.files[0] ? this.files[0].name : 'No se ha seleccionado ningún archivo';
                        document.getElementById('file-name').textContent = fileName;

                        var successIcon = document.getElementById('file-success-icon');
                        if (this.files.length > 0) {
                            successIcon.classList.remove('hidden');
                            setTimeout(function() {
                                successIcon.classList.add('hidden');
                            }, 2000); // El icono desaparecerá después de 2 segundos
                        } else {
                            successIcon.classList.add('hidden');
                        }
                    });
                    window.onload = function(){
                        document.getElementById('matricula').focus();
                    }
                </script>

              
          </div>
        </div>
      </div>
    </div>
  </div>
<?php   include ('../../layout/admin/parte2.php'); ?>
 