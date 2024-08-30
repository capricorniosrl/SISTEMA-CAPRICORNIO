<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
?>
<?php
if (isset($_SESSION['session_age_clientes'])) {
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

                    <h1 class="m-0">Listado de Clientes Agendadas a la Visita de Terrenos</h1>



                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- /.card -->

            <div class="card card-primary">
                <div class="card-header ">
                    <h3 class="card-title">Listado de Clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable({
                                "pageLength": 10,
                                "language": {
                                    "emptyTable": "No hay información",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes Agendados",
                                    "infoEmpty": "Mostrando 0 a 0 de 0 Clientes Agendados",
                                    "infoFiltered": "(Filtrado de _MAX_ total Clientes Agendados)",
                                    "infoPostFix": "",
                                    "thousands": ",",
                                    "lengthMenu": "Mostrar _MENU_ Clientes Agendados",
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
                                    <th>NOMBRE CLIENTE</th>
                                    <th>C.I.</th>
                                    <th>CELULAR</th>
                                    <th>FECHA VISITA</th>
                                    <th>NRO. VISITANTES</th>
                                    <th>URBANIZACION</th>
                                    <th>DETALLES CLIENTE</th>
                                    <th>DETALLES</th>
                                    <th>ASISTIO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>

                            <tbody>
                                <!-- PREPARAMOS LA CONSULTA APRA LISTAR LOS USUARIOS DE LA BASE DE DATOS -->
                                <?php
                                $query = $pdo->prepare("SELECT cli.ci_cliente, ag.detalle_agenda, ag.id_agenda, ag.asistio, ag.fecha_visita, ag.visitantes, ag.detalle, cli.tipo_urbanizacion, cli.nombres, cli.apellidos, con.celular, UPPER(cli.detalle) as detalle_cliente FROM tb_contactos con INNER JOIN tb_clientes cli INNER JOIN tb_agendas ag WHERE ((((ag.estado=1 AND ag.id_cliente_fk = cli.id_cliente) AND cli.id_contacto_fk = con.id_contacto) AND ag.id_usuario_fk='$id_usuario') AND ag.estado=1) AND visitantes<>'' ORDER BY ag.id_agenda DESC");
                                $query->execute();

                                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                                $contador = 0;


                                foreach ($usuarios as $usuario) {

                                    $contador++;
                                ?>

                                    <tr>

                                        <td><?php echo $contador; ?></td>
                                        <td><?php echo $usuario['nombres'] . " " . $usuario['apellidos']; ?></td>
                                        <td><?php echo $usuario['ci_cliente']; ?></td>
                                        <td><?php echo $usuario['celular'] ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($usuario['fecha_visita'])); ?></td>
                                        <td><?php echo $usuario['visitantes'] . " "; ?><i class="fas fa-user-check" style="color: #007bff;"></i></td>
                                        <td><i class="fas fa-map-marked-alt" style="color: #007bff;"></i><?php echo " " . $usuario['tipo_urbanizacion']; ?></td>


                                        <td>
                                            <?php
                                            // Obtener el contenido del mensaje
                                            $detalle = strtoupper($usuario['detalle_cliente']);

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




                                        <?php
                                        if (substr($usuario['detalle_agenda'], 0, 2) == "SE") {
                                        ?>
                                            <td class="text-danger"><?php echo $usuario['detalle_agenda']; ?></td>
                                            <td>
                                                <!-- ESTILOS PARA EL CHECKBOX -->
                                                <style>
                                                    .custom-checkbox {
                                                        display: flex;
                                                        align-items: center;
                                                        cursor: pointer;
                                                    }

                                                    .custom-checkbox input[type=checkbox] {
                                                        position: absolute;
                                                        opacity: 0;
                                                    }

                                                    .custom-checkbox .checkbox-container {
                                                        display: flex;
                                                        align-items: center;
                                                        width: 40px;
                                                        height: 20px;
                                                        border-radius: 15px;
                                                        background-color: #dee2e6;
                                                        position: relative;
                                                        transition: background-color 0.3s;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked+.checkbox-container {
                                                        background-color: #28a745;
                                                        /* Verde cuando asistió */
                                                    }

                                                    .custom-checkbox input[type=checkbox]:not(:checked)+.checkbox-container {
                                                        background-color: #dc3545;
                                                        /* Rojo cuando no asistió */
                                                    }

                                                    .custom-checkbox .checkbox-slider {
                                                        position: absolute;
                                                        width: 24px;
                                                        height: 24px;
                                                        border-radius: 50%;
                                                        background: white;
                                                        top: -2px;
                                                        left: -2px;
                                                        transition: transform 0.3s;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked+.checkbox-container .checkbox-slider {
                                                        transform: translateX(20px);
                                                    }

                                                    .custom-checkbox .checkbox-text {
                                                        margin-left: 10px;
                                                        color: red;
                                                        font-size: 14px;
                                                        font-weight: bold;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked~.checkbox-text {
                                                        color: black;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:not(:checked)~.checkbox-text {
                                                        color: red;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:disabled~.checkbox-container {
                                                        background-color: #b6b4b4;
                                                    }
                                                </style>
                                                <label class="custom-checkbox" hidden>
                                                    <input
                                                        name="check"
                                                        type="checkbox"
                                                        autocomplete="off"
                                                        data-id="<?php echo $usuario['id_agenda']; ?>"
                                                        <?php echo $usuario['asistio'] == 'SI' ? 'checked' : ''; ?>>
                                                    <div class="checkbox-container">
                                                        <div class="checkbox-slider"></div>
                                                    </div>
                                                    <span class="checkbox-text"><?php echo $usuario['asistio'] == 'SI' ? 'ASISTIÓ' : 'NO ASISTIÓ'; ?></span>
                                                </label>
                                            </td>


                                            <td>
                                                <a href="informe.php?id=<?php echo $usuario['id_agenda']; ?>" type="button" class="btn btn-outline-success disabled" disabled hidden>LLENAR INFORME</a>
                                                <a href="designar.php?id=<?php echo $usuario['id_agenda']; ?>" type="button" class="btn btn-outline-primary disabled" disabled hidden> <i class="fas fa-user"></i> DESIGNAR</a>

                                            </td>
                                        <?php
                                        } else {
                                        ?>
                                            <td><strong><?php echo $usuario['detalle_agenda']; ?></strong></td>
                                            <td>
                                                <!-- ESTILOS PARA EL CHECKBOX -->
                                                <style>
                                                    .custom-checkbox {
                                                        display: flex;
                                                        align-items: center;
                                                        cursor: pointer;
                                                    }

                                                    .custom-checkbox input[type=checkbox] {
                                                        position: absolute;
                                                        opacity: 0;
                                                    }

                                                    .custom-checkbox .checkbox-container {
                                                        display: flex;
                                                        align-items: center;
                                                        width: 40px;
                                                        height: 20px;
                                                        border-radius: 15px;
                                                        background-color: #dee2e6;
                                                        position: relative;
                                                        transition: background-color 0.3s;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked+.checkbox-container {
                                                        background-color: #28a745;
                                                        /* Verde cuando asistió */
                                                    }

                                                    .custom-checkbox input[type=checkbox]:not(:checked)+.checkbox-container {
                                                        background-color: #dc3545;
                                                        /* Rojo cuando no asistió */
                                                    }

                                                    .custom-checkbox .checkbox-slider {
                                                        position: absolute;
                                                        width: 24px;
                                                        height: 24px;
                                                        border-radius: 50%;
                                                        background: white;
                                                        top: -2px;
                                                        left: -2px;
                                                        transition: transform 0.3s;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked+.checkbox-container .checkbox-slider {
                                                        transform: translateX(20px);
                                                    }

                                                    .custom-checkbox .checkbox-text {
                                                        margin-left: 10px;
                                                        color: red;
                                                        font-size: 14px;
                                                        font-weight: bold;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:checked~.checkbox-text {
                                                        color: black;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:not(:checked)~.checkbox-text {
                                                        color: red;
                                                    }

                                                    .custom-checkbox input[type=checkbox]:disabled~.checkbox-container {
                                                        background-color: #b6b4b4;
                                                    }
                                                </style>
                                                <label class="custom-checkbox">
                                                    <input
                                                        name="check"
                                                        type="checkbox"
                                                        autocomplete="off"
                                                        data-id="<?php echo $usuario['id_agenda']; ?>"
                                                        <?php echo $usuario['asistio'] == 'SI' ? 'checked' : ''; ?>>
                                                    <div class="checkbox-container">
                                                        <div class="checkbox-slider"></div>
                                                    </div>
                                                    <span class="checkbox-text"><?php echo $usuario['asistio'] == 'SI' ? 'ASISTIÓ' : 'NO ASISTIÓ'; ?></span>
                                                </label>
                                            </td>


                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">OPCIONES</button>


                                                        <?php
                                                        $id_agenda = $usuario['id_agenda'];
                                                        $query = $pdo->prepare("SELECT * FROM tb_informe  WHERE id_agenda_fk = $id_agenda");

                                                        $query->execute();
                                                        $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);
                                                        $contador_ver = 0;
                                                        foreach ($usuarios as $usuarios) {
                                                            $contador_ver++;
                                                        }

                                                        if ($contador_ver == 1) {
                                                        ?>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item disabled" href="informe.php?id=<?php echo $id_agenda; ?>" type="button">LLENAR INFORME</a>

                                                                <?php
                                                                if (substr($usuario['detalle_agenda'], 0, 2) != "DE") {
                                                                ?>
                                                                    <a class="dropdown-item disabled" href="designar.php?id=<?php echo $id_agenda; ?>" type="button"> DESIGNAR</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary" href="repro.php?id=<?php echo $id_agenda; ?>">REPROGRAMAR LLAMADA</a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary" href="repro_nuevo_cliente.php?id=<?php echo $id_agenda; ?>">REPROGRAMAR LLAMADA</a
                                                                        <?php
                                                                    }

                                                                        ?>>
                                                            </div>
                                                            <a target="_blank" href="../reportes/index.php?id=<?php echo $id_agenda; ?>" class="btn btn-default"><i class="fas fa-file-pdf fa-2x ml-2 text-danger btn btn-default"></i>REPORTE</a>



                                                        <?php
                                                        } else {
                                                        ?>


                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item " href="informe.php?id=<?php echo $id_agenda; ?>" type="button">LLENAR INFORME</a>

                                                                <?php
                                                                if (substr($usuario['detalle_agenda'], 0, 2) != "DE") {
                                                                ?>
                                                                    <a class="dropdown-item " href="designar.php?id=<?php echo $id_agenda; ?>" type="button"> DESIGNAR</a>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary" href="repro.php?id=<?php echo $id_agenda; ?>">REPROGRAMAR LLAMADA</a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div role="separator" class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-primary" href="repro_nuevo_cliente.php?id=<?php echo $id_agenda; ?>">REPROGRAMAR LLAMADA</a>
                                                                <?php
                                                                }

                                                                ?>

                                                            </div>


                                                        <?php
                                                        }

                                                        ?>





                                                    </div>

                                                </div>



                                            </td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                <?php
                                }
                                ?>


                            </tbody>

                            <!-- <tfoot>
                    <tr>
                        <th>Nro.</th>
                        <th>NOMBRE CLIENTE</th>
                        <th>CELULAR</th>
                        <th>FECHA VISITA</th>
                        <th>NRO. VISITANTES</th>
                        <th>URBANIZACION</th>
                        <th>DETALLES CLIENTE</th>
                        <th>DETALLES</th>
                        <th>ASISTIO</th>
                        <th>ACCIONES</th>
                    </tr>
                    </tfoot> -->
                        </table>
                    </div>


                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });

                        document.querySelectorAll('.custom-checkbox input[type=checkbox]').forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                let id = this.getAttribute('data-id');
                                let asistio = this.checked ? 'SI' : 'NO';

                                fetch('actualizar_asistencia.php', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: new URLSearchParams({
                                            id: id,
                                            asistio: asistio
                                        })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Registro actualizado exitosamente'
                                            });

                                            // Actualiza el texto del checkbox
                                            document.querySelector(`input[data-id="${id}"] + .checkbox-container + .checkbox-text`).textContent = asistio === 'SI' ? 'ASISTIÓ' : 'NO ASISTIÓ';

                                        } else {
                                            Toast.fire({
                                                icon: 'error',
                                                title: 'Hubo un problema al actualizar el registro'
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Error en la petición'
                                        });
                                    });
                            });
                        });
                    </script>




                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
</div>
<?php include('../../layout/admin/parte2.php');
?>