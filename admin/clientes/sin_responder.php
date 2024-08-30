<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
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
                    <h1 class="m-0">Listado de que no Respondieron la Llamada</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- /.card -->
            <div class="card card-danger">
                <div class="card-header ">
                    <h3 class="card-title">CONTACTOS</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">

                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable({
                                "pageLength": 10,
                                "language": {
                                    "emptyTable": "No hay información",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                                    "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                                    "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                                    "infoPostFix": "",
                                    "thousands": ",",
                                    "lengthMenu": "Mostrar _MENU_ Clientes",
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
                                    <th>NOMBRES</th>
                                    <th>CONTACTO</th>
                                    <th>FECHA Y HORA REGISTRO</th>
                                    <th>DETALLES</th>
                                    <th>LLAMADA</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                                <?php
                                $query = $pdo->prepare("SELECT con.id_contacto, con.id_usuario_fk, con.celular, con.created_at, con.detalle, cli.detalle as detalle_cliente, cli.nombres, cli.apellidos, cli.id_cliente FROM tb_contactos con INNER JOIN tb_clientes cli
                        WHERE ((con.id_contacto=cli.id_contacto_fk) AND cli.detalle_llamada='NO CONTESTO') AND cli.id_usuario_fk='$id_usuario' ORDER BY id_contacto DESC");
                                $query->execute();

                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                                $contador = 0;
                                foreach ($usuarios as $usuario) {

                                    $detalle_sin_saltos = str_replace(array("\r\n", "\r", "\n"), '', $usuario['detalle_cliente']);

                                    $datos_contacto = $usuario['id_contacto'] . "||" . $usuario['celular'] . "||" . $usuario['id_usuario_fk'] . "||" . $usuario['nombres'] . "||" . $usuario['apellidos'] . "||" . $usuario['id_cliente'] . "||" . $detalle_sin_saltos;

                                    $contador++;

                                    $id = $usuario['id_contacto'];


                                ?>

                                    <tr>

                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?></td>

                                        <td>

                                            <a data-toggle="tooltip" data-placement="left" title="Enviar Mensaje al WhatsApp" target="_blank" href="https://wa.me/+591<?php echo $usuario['celular'] ?>"><i class="fab fa-whatsapp fa-xl btn btn-default rounded-circle shadow  " style="color: #25D366;"></i></a>
                                            <?php echo $usuario['celular']; ?>

                                        </td>

                                        <td>
                                            <?php echo $usuario['created_at']; ?></td>

                                        <td class="">
                                            <?php
                                            // Obtener el contenido del mensaje
                                            $detalle = $usuario['detalle_cliente'];

                                            // Usar preg_match para obtener el último mensaje después de un asterisco
                                            if (preg_match('/[^*]+\*([^*]+)$/', $detalle, $matches)) {
                                                $mensaje_a_mostrar = trim($matches[1]);
                                            } else {
                                                $mensaje_a_mostrar = trim($detalle);
                                            }

                                            // Mostrar el mensaje
                                            echo htmlspecialchars($mensaje_a_mostrar);
                                            ?>
                                        </td>


                                        <td>
                                            <i class="fas fa-phone-slash text-danger"></i><span class="text-danger"> NO CONTESTO LA LLAMADA</span>
                                        </td>

                                        <td>
                                            <!-- <a href="edit.php?id=<?php echo $id; ?>" type="button" class="btn btn-outline-success"><i class="fa fa-edit"></i></a> -->
                                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;" data-toggle="modal" data-target="#agendar" onclick="modal_agenda('<?php echo $datos_contacto ?>')">
                                                <i class="fas fa-calendar-alt"></i> HACER SEGUIMIENTO
                                            </button>
                                        </td>
                                    </tr>


                                <?php
                                }
                                ?>


                            </tbody>

                            <!-- <tfoot>
                    <tr>
                        <th>Nro.</th>
                        <th>CONTACTO</th>
                        <th>FECHA Y HORA REGISTRO</th>
                        <th>DETALLES</th>
                        <th>LLAMADA</th>
                        <th>ACCIONES</th>
                    </tr>
                    </tfoot> -->
                        </table>
                    </div>


                    <!-- ventana modal Nuevo Cliente -->
                    <div class="modal fade " id="agendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Cliente que no Respondieron la Llamada</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <SCRipt>
                                        function modal_agenda(datos_contacto) {
                                            datoscontacto = datos_contacto.split("||");
                                            $("#id_contacto").val(datoscontacto[0]);
                                            $("#celular_modal").val(datoscontacto[1]);
                                            $("#id_usuario").val(datoscontacto[2]);
                                            $("#nombres").val(datoscontacto[3]);
                                            $("#apellidos").val(datoscontacto[4]);
                                            $("#id_cliente").val(datoscontacto[5]);
                                            $("#detalle").val(datoscontacto[6]);
                                        }
                                    </SCRipt>
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
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label>id_cliente</label>
                                                    <input type="text" name="id_cliente" id="id_cliente" class="form-control" placeholder="id_contacto">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label>id_contacto</label>
                                                    <input type="text" name="id_contacto" id="id_contacto" class="form-control" placeholder="id_contacto">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <div class="form-group">
                                                    <label>id_usuario <span class="text-danger">*</span> </label>
                                                    <input type="text" name="id_usuario" id="id_usuario" class="form-control" placeholder="id_usuario" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>Nombres</label>
                                                    <input type="text" name="nombre" id="nombres" class="form-control" placeholder="Nombre Completo">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>Apellidos</label>
                                                    <input type="text" name="apellido" id="apellidos" class="form-control" placeholder="Apellidos Completos">
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
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Tipo Urbanizacion <span class="text-danger">*</span> </label>
                                                    <select class="form-control" name="urbanizacion" id="">
                                                        <option value="POLANCO">POLANCO</option>
                                                        <option value="TERRAZAS">TERRAZAS</option>
                                                        <option value="MIRADOR DEL SUR">MIRADOR DEL SUR</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">

                                            <div class="col-12 col-sm-6">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label>Detalle de Llamada <span class="text-danger">*</span> </label>
                                                    <select class="form-control" name="llamada" id="llamadaSelect">
                                                        <option value="CONTESTO">CONTESTO</option>
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

                                            <script>
                                                document.addEventListener('DOMContentLoaded', (event) => {
                                                    const today = new Date();
                                                    const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                                                    document.getElementById('agenda').value = formattedDate;

                                                    // Reset form when modal is hidden
                                                    $('#agendar').on('hidden.bs.modal', function() {
                                                        const form = $('#form-agendar')[0];
                                                        form.reset();
                                                        $('#additionalInputs').hide(); // Hide additional inputs if they were shown

                                                        // Reset the date field again after resetting the form
                                                        document.getElementById('agenda').value = formattedDate;
                                                    });
                                                });
                                            </script>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 col-sm-12">
                                                <div class="form-group">

                                                    <label>Detalle <span class="text-danger">*</span> </label>
                                                    <textarea style="text-transform: uppercase;" class="form-control" name="detalle" id="detalle" cols="30" rows="2" readonly hidden></textarea>
                                                    <textarea style="text-transform: uppercase;" name="detalle2" cols="30" rows="2" id="" class="form-control"></textarea>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Checkbox to show/hide additional inputs -->
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

                                                <!-- NUEVO FORMULARIO PARA REPROGRAMAR LLAMADA -->
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


                                                <!-- NUEVO FORMULARIO PARA AGENDAR -->
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
                                                                    form.addEventListener('submit', function(event) {
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
                                                                        }
                                                                    });
                                                                    event.preventDefault(); // Evita el envío del formulario
                                                                }
                                                            }
                                                        });
                                                    });

                                                    document.addEventListener('DOMContentLoaded', (event) => {
                                                        const today = new Date();
                                                        const formattedDate = today.toISOString().split('T')[0]; // YYYY-MM-DD
                                                        document.getElementById('agenda').value = formattedDate;

                                                        // Reset form when modal is hidden
                                                        $('#agendar').on('hidden.bs.modal', function() {
                                                            const form = $('#form-agendar')[0];
                                                            form.reset();
                                                            $('#additionalInputs').hide(); // Hide additional inputs if they were shown
                                                            $('#newFormInputs').hide(); // Hide new form inputs if they were shown

                                                            // Reset the date field again after resetting the form
                                                            document.getElementById('agenda').value = formattedDate;
                                                        });

                                                        // Check if the form is being submitted
                                                        document.getElementById('form-agendar').addEventListener('submit', function(event) {
                                                            updateFormAction();
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
                                                        const crearClienteUrl = '<?php echo $URL ?>/admin/clientes/controller_reprogramar_llamanda.php';
                                                        const nuevoCheckbox = document.getElementById('nuevoCheckbox');
                                                        const reprogramarCheckbox = document.getElementById('reprogramar');

                                                        // Cambia el action del formulario según el estado de los checkboxes
                                                        if (nuevoCheckbox.checked) {
                                                            form.action = agendarUrl;
                                                        } else if (reprogramarCheckbox.checked) {
                                                            form.action = crearClienteUrl;
                                                        } else {
                                                            form.action = '<?php echo $URL ?>/admin/clientes/controller_no_check.php'; // Acción predeterminada si ningún checkbox está marcado
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
</div>
<!-- <script src="script.js"></script> -->
<?php include('../../layout/admin/parte2.php');
?>