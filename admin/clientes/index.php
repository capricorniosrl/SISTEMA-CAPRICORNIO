<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

if (isset($_SESSION['session_reg_clientes'])) {
  // echo "existe session y paso por el login";
} else {
  // echo "no existe session por que no ha pasado por el login";
  header('Location:' . $URL . '/admin');
}
?>
<?php include('../../layout/admin/parte1.php'); ?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Listado de Contactos</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <!-- /.card -->
      <div class="card card-primary">
        <div class="card-header ">
          <h3 class="card-title">CONTACTOS</h3>
        </div>
        <button class="col-6 col-sm-3 btn btn-danger mt-2 ml-2" data-toggle="modal" data-target="#exampleModalCenter"> <i class="fas fa-plus"></i> Nuevo Contacto</button>
        <!-- ventana modal Nuevo Cliente -->
        <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLongTitle">Registro de Nuevo Contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="formulario-Contacto">
                  <input type="text" name="id_usuario" id="" value="<?php echo $id_usuario ?>" hidden>
                  <div class="row ">
                    <div class="col d-none" id="mensaje_contacto">
                      <i class="fas fa-bullhorn text-danger"></i>Alerta
                      <div class="callout callout-danger">
                        <p class="text-danger" id="msjerror">* </p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <input type="text" name="nombre" id="nombre" hidden>
                    </div>
                    <div class="col-6">
                      <input type="text" name="apellidos" id="apellidos" hidden>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12 col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Celular <span class="text-danger">*</span> </label>
                        <input type="number" name="celular" id="celular" class="form-control" placeholder="Celular">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label>FECHA REGISTRO <span class="text-danger">*</span> </label>
                        <input type="date" id="fechaRegistro" name="fecha_registro" class="form-control" readonly>
                      </div>
                    </div>
                    <script>
                      document.addEventListener('DOMContentLoaded', (event) => {
                        const today = new Date();
                        const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                        document.getElementById('fechaRegistro').value = formattedDate;
                      });
                      // buscar si el contacto ya fue registrado con anterioridad
                      $("#celular").on("keyup", function() {
                        var celular = $("#celular").val(); //CAPTURANDO EL VALOR DE INPUT CON ID CEDULA
                        var longitudCelular = $("#celular").val().length; //CUENTO LONGITUD
                        //Valido la longitud 
                        if (longitudCelular >= 3) {
                          var dataString = 'celular=' + celular;
                          $.ajax({
                            url: 'verificarCelular.php',
                            type: "GET",
                            data: dataString,
                            dataType: "JSON",
                            success: function(datos) {
                              if (datos.success == 1) {
                                $("#respuesta").html(datos.message);
                                $('#mensaje1').removeClass('d-none');
                                $('#mensaje').addClass('d-none');
                                var inputNombre = document.getElementById('nombre');
                                inputNombre.value = datos.message_nombre;
                                var inputApellidos = document.getElementById('apellidos');
                                inputApellidos.value = datos.message_apellidos;
                                var inputCelular = document.getElementById('celular_recuperado');
                                inputCelular.value = datos.message_celular;
                              } else {
                                $("#respuesta").html(datos.message);
                                $('#mensaje1').addClass('d-none');
                                var inputNombre = document.getElementById('nombre');
                                inputNombre.value = '';
                                var inputApellidos = document.getElementById('apellidos');
                                inputApellidos.value = '';
                              }
                            }
                          });
                        }
                      });
                    </script>
                  </div>
                  <button class="btn btn-outline-info btn-block" type="submit">Registrar</button>
                </form>
                <form action="detalles_contacto.php" method="post">
                </form>
                <div class="row ">
                  <div class="col d-none" id="mensaje1">
                    <i class="fas fa-info text-info fa-lg"></i> <strong> Informacion </strong>
                    <hr style="height: 2px;" class="bg-info">
                    <div class="callout callout-info">
                      <p class="text-danger" id="respuesta"></p>
                      <form action="detalles_contacto.php" method="post">
                        <input type="text" name="celular_recuperado" id="celular_recuperado" hidden>
                        <button class="btn btn-danger" type="submit">ver detalles</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          $(document).ready(function() {
            // Cuando el modal se cierra
            $('#exampleModalCenter').on('hidden.bs.modal', function() {
              // Limpia los campos del formulario
              $('#formulario-Contacto')[0].reset();
              // Oculta los mensajes
              $('#mensaje_contacto').addClass('d-none');
              $('#mensaje1').addClass('d-none');
              // Limpia el contenido de los mensajes
              $('#msjerror').html('*');
              $('#respuesta').html('');
            });
            // Cuando el modal se abre
            $('#exampleModalCenter').on('shown.bs.modal', function() {
              // Enfoca el campo celular
              $('#celular').focus();
            });
          });
          
          function obtienedatos(){
                            let modal = document.getElementById('actualizar_contacto');
                          modal.addEventListener('shown.bs.modal', function(){
                            console.log("muestra datos: ");
                          });


                          
                          }
        </script>
        <!-- /.card-header -->
        <div class="card-body">
          <script>
            $(document).ready(function() {
              $('#example').DataTable({
                "pageLength": 10,
                "language": {
                  "emptyTable": "No hay información",
                  "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                  "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                  "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                  "infoPostFix": "",
                  "thousands": ",",
                  "lengthMenu": "Mostrar _MENU_ Usuarios",
                  "loadingRecords": "Cargando...",
                  "processing": "Procesando...",
                  "search": "Buscador:",
                  "zeroRecords": "Sin resultados encontrados",
                  "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                  }
                }
              });
            });
          </script>
          <div class="table-responsive">
            <table id="example" class="display " style="width:100%">
              <thead>
                <tr>
                  <th>Nro.</th>
                  <th>CONTACTO</th>
                  <th>FECHA Y HORA REGISTRO</th>
                  <th>DETALLES</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tbody>
                <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                <?php
                $query = $pdo->prepare("SELECT * FROM tb_contactos WHERE (estado=1 and detalle_agenda='NO') and id_usuario_fk=$id_usuario ORDER BY id_contacto DESC");
                $query->execute();
                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                $contador = 0;
                foreach ($usuarios as $usuario) {
                  $datos_contacto = $usuario['id_contacto'] . "||" . $usuario['celular'] . "||" . $usuario['id_usuario_fk'];
                  $contador++;
                  $id = $usuario['id_contacto'];
                ?>
                  <tr>
                    <td><?php echo $contador; ?></td>
                    <td>
                      <a data-toggle="tooltip" data-placement="left" title="Enviar Mensaje al WhatsApp" target="_blank" href="https://wa.me/+591<?php echo $usuario['celular'] ?>"><i class="fab fa-whatsapp fa-xl btn btn-default rounded-circle shadow  " style="color: #25D366;"></i></a>
                      <?php echo $usuario['celular']; ?>
                      <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" data-toggle="modal" data-target="#agendar" onclick="modal_agenda('<?php echo $datos_contacto ?>')">
                        <i class="fas fa-calendar-alt"></i> Agendar
                      </button>
                    </td>
                    <td><?php echo $usuario['created_at']; ?></td>
                    <td><?php echo $usuario['detalle']; ?></td>
                    <td>
                      <a href="" type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#actualizar_contacto" onclick="modal_actualizar_contacto('<?php echo $datos_contacto ?>')"><i class="fa fa-edit"></i></a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <script>
            $('#actualizar_contacto').on("click", function(){
              console.log("aqui datos de prueba");
            });
            
            document.addEventListener('DOMContentLoaded', (event) => {
              const today = new Date();
              const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
              document.getElementById('agenda').value = formattedDate;
              $('#agendar').on('hidden.bs.modal', function() {
                const form = $('#form-agendar')[0];
                form.reset();
                $('#additionalInputs').hide();
                document.getElementById('agenda').value = formattedDate;
              });
            });
          </script>
          <div class="modal fade" id="actualizar_contacto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-success">
                  <h5 class="modal-title" id="exampleModalLabel">Actualizar Contacto</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="formulario-Contacto_update">
                    <input type="text" name="id_contacto_actualizar" id="id_contacto_actualizar" value="" hidden>
                    <div class="row">
                      <div class="col-12 col-sm-12">
                        <div class="form-group">
                          <label for="celular_actualizar">Celular <span class="text-danger">*</span> </label>
                          <input type="number" name="celular_actualizar" id="celular_modal_actualizar" class="form-control" placeholder="Celular">
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-outline-info btn-block" type="submit">Actualizar</button>
                  </form>
                  <div class="row ">
                    <div class="col d-none" id="mensaje2">
                      <i class="fas fa-info text-info fa-lg"></i> <strong> Informacion </strong>
                      <hr style="height: 2px;" class="bg-info">
                      <div class="callout callout-info">
                        <p class="text-danger" id="respuesta2"></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade " id="agendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header bg-info">
                  <h5 class="modal-title" id="exampleModalLongTitle">Registro de Nuevo Cliente</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form-agendar" method="post" action="">
                    <div class="row ">
                      <div class="col d-none" id="mensaje">
                        <i class="fas fa-bullhorn text-danger"></i>
                        Alerta
                        <div class="callout callout-danger">
                          <p class="text-danger" id="msjerror">* </p>
                        </div>
                      </div>
                    </div>
                    <div class="row" hidden>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>id_contacto</label>
                          <input type="text" name="id_contacto" id="id_contacto" class="form-control">
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>id_usuario <span class="text-danger">*</span> </label>
                          <input type="text" name="id_usuario" id="id_usuario" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Nombres</label>
                          <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre Completo">
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Apellidos</label>
                          <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Apellidos Completos">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Celular <span class="text-danger">*</span> </label>
                          <input type="number" name="celular" id="celular_modal" class="form-control" placeholder="Celular" readonly>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Tipo Urbanizacion <span class="text-danger">*</span> </label>
                          <select class="form-control" name="urbanizacion" id="">
                            <?php
                            $query = $pdo->prepare("SELECT * FROM tb_urbanizacion");
                            $query->execute();
                            $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($usuarios as $usuario) {
                            ?>
                              <option value="<?php echo $usuario['nombre_urbanizacion']; ?>"><?php echo $usuario['nombre_urbanizacion']; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>Detalle de Llamada <span class="text-danger">*</span> </label>
                          <select class="form-control" name="llamada" id="llamadaSelect">
                            <option value="CONTESTO">CONTESTO</option>
                            <option value="NO CONTESTO">NO CONTESTO</option>
                            <option value="SIN_INTERES">CONTESTO PERO NO ESTA INTERESADO</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-sm-6">
                        <div class="form-group">
                          <label>FECHA REGISTRO <span class="text-danger">*</span> </label>
                          <input type="date" id="agenda" name="fecha_registro" class="form-control" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-12">
                        <div class="form-group">
                          <label>Detalle <span class="text-danger">*</span> </label>
                          <textarea style="text-transform: uppercase;" class="form-control" name="detalle" id="" cols="30" rows="2">SIN DETALLE</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col text-left">
                              <input type="checkbox" name="mi_checkbox" id="reprogramar" onclick="toggleAdditionalInputs()">
                              <label for="reprogramar">Reprogramar Llamada</label>
                            </div>
                            <div class="col text-right">
                              <input type="checkbox" name="mi_checkbox_agendar" id="nuevoCheckbox" onclick="toggleNewFormInputs()">
                              <label for="nuevoCheckbox">Agendar Visita</label>
                            </div>
                          </div>
                        </div>
                        <div id="additionalInputs" style="display: none;">
                          <div class="row">
                            <div class="col-12 col-sm-6">
                              <div class="form-group">
                                <label>Fecha de Llamada</label>
                                <input type="date" name="fecha_llamada" class="form-control">
                              </div>
                            </div>
                            <div class="col-12 col-sm-6">
                              <div class="form-group">
                                <label>Hora de Llamada</label>
                                <input type="time" name="hora_llamada" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="newFormInputs" style="display: none;">
                          <div class="row">
                            <div class="col-12 col-sm-6">
                              <div class="form-group">
                                <label>Fecha de Visita</label>
                                <input type="date" name="fecha_visita" class="form-control">
                              </div>
                            </div>
                            <div class="col-12 col-sm-6">
                              <div class="form-group">
                                <label>Número de Visitantes</label>
                                <select name="numero_visitantes" class="form-control">
                                  <option value="1 Personas">1 Personas</option>
                                  <option value="2 Personas">2 Personas</option>
                                  <option value="3 Personas">3 Personas</option>
                                  <option value="4 Personas">4 Personas</option>
                                  <option value="5 Personas">5 Personas</option>
                                  <option value="6 Personas">6 Personas</option>
                                  <option value="7 Personas">7 Personas</option>
                                  <option value="8 Personas">8 Personas</option>
                                  <option value="9 Personas">9 Personas</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <script>                         
                          document.addEventListener('DOMContentLoaded', function() {
                            const llamadaSelect = document.getElementById('llamadaSelect');
                            const reprogramarCheckbox = document.getElementById('reprogramar');
                            const nuevoCheckbox = document.getElementById('nuevoCheckbox');
                            const form = document.getElementById('form-agendar');

                            llamadaSelect.addEventListener('change', function() {
                              if (llamadaSelect.value === 'CONTESTO') {
                                reprogramarCheckbox.required = false; // No requerir checkboxes individualmente
                                nuevoCheckbox.required = false; // No requerir checkboxes individualmente
                                reprogramarCheckbox.disabled = false; // Habilitar checkboxes
                                nuevoCheckbox.disabled = false; // Habilitar checkboxes
                              } else if (llamadaSelect.value === 'NO CONTESTO' || llamadaSelect.value === 'SIN_INTERES') {
                                reprogramarCheckbox.checked = false; // Desmarcar el checkbox
                                nuevoCheckbox.checked = false; // Desmarcar el checkbox
                                reprogramarCheckbox.disabled = true; // Deshabilitar checkboxes
                                nuevoCheckbox.disabled = true; // Deshabilitar checkboxes
                              } else {
                                reprogramarCheckbox.required = false; // No requerir checkboxes individualmente
                                nuevoCheckbox.required = false; // No requerir checkboxes individualmente
                                reprogramarCheckbox.disabled = false; // Habilitar checkboxes
                                nuevoCheckbox.disabled = false; // Habilitar checkboxes
                              }
                            });
                            form.addEventListener('submit', function(event) {
                              if (llamadaSelect.value === 'CONTESTO') {
                                if (!reprogramarCheckbox.checked && !nuevoCheckbox.checked) {
                                  if (llamadaSelect.value === 'CONTESTO') {
                                    if (!reprogramarCheckbox.checked && !nuevoCheckbox.checked) {
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
                                        icon: "info",
                                        title: "<span style='color: #000000;'>Debes seleccionar al menos uno de los checkboxes</span>\n\t<span style='color: #007bff;'>1 Reprogramar Llamada\n\t2 Agendar Visita</span>"
                                      });
                                      event.preventDefault(); // Evita el envío del formulario
                                    }
                                    event.preventDefault();
                                  }
                                  event.preventDefault(); // Evita el envío del formulario
                                }
                              }
                            });
                          });
                          document.addEventListener('DOMContentLoaded', (event) => {
                            const today = new Date();
                            const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                            document.getElementById('agenda').value = formattedDate;
                            $('#agendar').on('hidden.bs.modal', function() {
                              const form = $('#form-agendar')[0];
                              form.reset();
                              $('#additionalInputs').hide();
                              $('#newFormInputs').hide();
                              document.getElementById('agenda').value = formattedDate;
                            });
                            document.getElementById('form-agendar').addEventListener('submit', function(event) {
                              updateFormAction();

                            });
                          });

                          // document.getElementById('form-agendar').addEventListener('submit', function(event) {
                          //   var confirmSubmit = confirm('¿Estás seguro de que deseas enviar los datos?');
                          //   if (!confirmSubmit) {
                          //     event.preventDefault(); // Cancela el envío del formulario si el usuario no confirma
                          //   }
                          // });
                          document.getElementById('form-agendar').addEventListener('submit', function(event) {
                            // Evita que el formulario se envíe de inmediato
                            event.preventDefault();

                            // Muestra la alerta con SweetAlert2
                            Swal.fire({
                              title: '¿Estás seguro?',
                              text: '¿Deseas registrar los datos que ingreso?',
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Sí, Registrar',
                              cancelButtonText: 'Cancelar'
                            }).then((result) => {
                              if (result.isConfirmed) {
                                // Si el usuario confirma, envía el formulario
                                event.target.submit();
                              }
                            });
                          });

                          function toggleAdditionalInputs() {
                            const reprogramarCheckbox = document.getElementById('reprogramar');
                            const additionalInputs = document.getElementById('additionalInputs');
                            const nuevoCheckbox = document.getElementById('nuevoCheckbox');
                            if (reprogramarCheckbox.checked) {
                              additionalInputs.style.display = 'block';
                            } else {
                              additionalInputs.style.display = 'none';
                            }
                          }

                          function toggleAdditionalInputs() {
                            const reprogramarCheckbox = document.getElementById('reprogramar');
                            const additionalInputs = document.getElementById('additionalInputs');
                            if (reprogramarCheckbox.checked) {
                              additionalInputs.style.display = 'block';
                            } else {
                              additionalInputs.style.display = 'none';
                            }
                            updateFormAction();
                          }

                          function toggleNewFormInputs() {
                            const nuevoCheckbox = document.getElementById('nuevoCheckbox');
                            const newFormInputs = document.getElementById('newFormInputs');
                            const reprogramarCheckbox = document.getElementById('reprogramar');
                            if (nuevoCheckbox.checked) {
                              reprogramarCheckbox.checked = false; // Uncheck 'Reprogramar Llamada'
                              reprogramarCheckbox.disabled = true; // Disable 'Reprogramar Llamada' checkbox
                              document.getElementById('additionalInputs').style.display = 'none'; // Hide 'Reprogramar Llamada' inputs
                              newFormInputs.style.display = 'block'; // Show 'Agendar Visita' inputs
                            } else {
                              reprogramarCheckbox.disabled = false; // Enable 'Reprogramar Llamada' checkbox
                              newFormInputs.style.display = 'none'; // Hide 'Agendar Visita' inputs
                            }
                            updateFormAction();
                          }

                          function updateFormAction() {
                            const form = document.getElementById('form-agendar');
                            const agendarUrl = '<?php echo $URL ?>/admin/agendar/index.php';
                            const crearClienteUrl = '<?php echo $URL ?>/admin/clientes/controller_create_cliente.php';
                            const nuevoCheckbox = document.getElementById('nuevoCheckbox');
                            const reprogramarCheckbox = document.getElementById('reprogramar');
                            if (nuevoCheckbox.checked) {
                              form.action = agendarUrl;
                            } else if (reprogramarCheckbox.checked) {
                              form.action = crearClienteUrl;
                            } else {
                              form.action = '<?php echo $URL ?>/admin/clientes/controller_create_cliente.php'; // Acción predeterminada si ningún checkbox está marcado
                            }
                          }
                        </script>
                      </div>
                    </div>
                    <button class="btn btn-outline-info btn-block" type="submit">Registrar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </div>
</div>
<script>
  var URL = "<?php echo $URL; ?>";
</script>
<SCript src="script.js"></SCript>
<?php include('../../layout/admin/parte2.php');
?>